<?php
if(!defined('BASE_ENCRYPTION_DIR')) define('BASE_ENCRYPTION_DIR', 'E:\xampp\htdocs\404chat_developer\php\includes\encryption');
include BASE_ENCRYPTION_DIR."\\encryption.php";

//Handles strings so they are safe to send to databse
function protectString($string)
{
  global $link;
  $string = trim($string);
  $string = htmlspecialchars($string, ENT_QUOTES);
  $string = mysqli_real_escape_string($link, $string);
  return $string;
}

//Allows user to redownload all messages in database
function reload_messages($link)
{
  $sql = 'UPDATE `users` SET `last_seen_message_id` = \'0\' WHERE `users`.`UserID` = '.$_SESSION['userID'];
  mysqli_query($link, $sql);
}

//Deletes all the information on a user
function delete_user_info($link)
{
  	$userID = $_SESSION['userID'];
    $sql = [
      'DELETE FROM messages WHERE UserID = '.$userID,
      'DELETE FROM users WHERE userID = '.$userID
    ];

  	foreach($sql as $query) {
  		if(!mysqli_query($link, $query)) {
	      echo "Something went wrong".mysqli_error($link);
    	}
  	}

    session_destroy();
    header('location: ../'.USERNAMECHANGE_FILENAME);
}

//Sets $_SESSION variables and registers user in database
function register_user($username, $link)
{

  //Verifies username validity
  if(username_is_valid()) {
    //Protects username and sets user room
    $_SESSION['username'] = $username = protectString($_POST['username']);
    $_SESSION['roomname'] = 'main';
    $_SESSION['roomID'] = 1;
    $_SESSION['userID'] = '';

    //Sends query to DB
    $sql = [
      "INSERT INTO `users` (`Username`, `room_id`, `last_seen_message_id`, `daily_deletion`) VALUES ('$username', '1', '0', '1')",
      "SELECT * FROM users WHERE Username = '$username' AND room_id = '1' AND last_seen_message_id = '0' ORDER BY UserID DESC "
    ];

    if(mysqli_query($link, $sql[0])) {
      //Gets UserID
      if($result = mysqli_query($link, $sql[1])) {
        $row = mysqli_fetch_array($result);
        $_SESSION['userID'] = $row[0];
        header('location: ../'.CHAT_FILENAME); #Redirects user to chat
        return true;
      }
    }
  }
  header('location: ../'.USERNAMECHANGE_FILENAME);
  return false;
}

//Checks if user is registered in session and in db
function user_is_registered($link)
{
  //Checks for session variables first
  if(isset($_SESSION['username']) && isset($_SESSION['userID']) && isset($_SESSION['roomname']) && isset($_SESSION['roomID'])) {
    //Checks if they correspond to database
    $sql = 'SELECT * FROM users WHERE Username = \''.$_SESSION['username'].'\' AND UserID = '.$_SESSION['userID'];
    if(mysqli_num_rows(mysqli_query($link, $sql)) == 1) {
      return true;
    }
  }
  return false;
}

//Checks if username is valid
function username_is_valid()
{
  if(isset($_POST['username'])) {
    //Checks username length
    if(strlen($_POST['username']) >= 3 && strlen($_POST['username']) <= 20) {
      //Checks for "<br>" inside username (). If username doesn't have it, returns true.
      $brposition = stripos($_POST['username'], '<br>');
      if($brposition == '') {
        return true;
      }
    }
  }
  else {
    echo "Username is not set (".$_POST['username'].")";
  }
  return false;
}

//Checks if the room is valid
function room_is_valid($room)
{
  if (strlen($room) < 3 || strlen($room) > 20)
  {
    return false;
  }
  return true;
}

//Deals with room creation
function createroom($link, $room, $password)
{
  $roomid = $_SESSION['roomID'];
  //Encrypts room name and password
  $enc_room = encrypt_room_data($room, $password);
  $enc_room_name = $enc_room["roomname"];
  $enc_room_password = $enc_room["password"];
  //Creates new room in database
  $sql = "INSERT INTO rooms (Roomname, RoomPassword, daily_deletion) VALUES ('$enc_room_name', '$enc_room_password', '1')";
  if(check_existing_room($link, $room)) {
    if(mysqli_query($link, $sql)) {
      api_response('Created ' . $room . ' successfully!');
      joinroom($link, $room, $password);

      //Creates encryption key in .dat file
      $roomident = $_SESSION['roomID'];
      $encryption_info = create_encryption_data();
      write_to_encryption_file($roomident, $encryption_info);
    }
  }
  else {
    joinroom($link, $room, $password);
  }
}

//Checks if roomname already exists to prevent duplicates
function check_existing_room($link, $room)
{
  $enc_room = encrypt_room_data($room)["roomname"];
  $sql = "SELECT * FROM rooms WHERE Roomname = '$enc_room'";
  $numrows = mysqli_num_rows(mysqli_query($link, $sql));
  if ($numrows != 0)
  {
    $room = decrypt_room_data($room)["roomname"];
    api_response("ERROR: $room already exists. Attempting to join instead with given roomname and password instead...");
    return false;
  }
  return true;
}

//Deals with connection to room
function joinroom($link, $room, $password)
{
  $userID = $_SESSION['userID'];
  //Looks for the right room
  $enc_room = encrypt_room_data($room)["roomname"];
  if($password != '') {
    $enc_password = encrypt_room_data('', $password)["password"];
  }
  else {
    $enc_password = '';
  }
  $sql = "SELECT * FROM rooms WHERE RoomName = '$enc_room' AND RoomPassword = '$enc_password' ORDER BY RoomID DESC";
  if ($result = mysqli_query($link, $sql))
  {
    $results = mysqli_fetch_array($result, MYSQLI_ASSOC);
    //If room is found, tries to update user in database
    if (mysqli_num_rows($result) != 0)
    {
      //Defines necessary variables to update user in database
      $roomID = $results['RoomID'];
      $room = decrypt_room_data($results['RoomName'])["roomname"];
      //Updates user in database
      $sql = "UPDATE users SET room_id = '$roomID' WHERE users.UserID = '$userID'";
      if (mysqli_query($link, $sql))
      {
        //Changes user's room
        $_SESSION['roomID'] = $roomID;
        $_SESSION['roomname'] = $room;
        api_response('Joined ' . $room . ' successfully!');
      }
    }
    else
    {
      api_response('Could not find room. Check if name and password combination is correct');
    }
  }
}

//Gets all the messages
function get_messages($link)
{
  //Gets Info
  $last_seen = get_last_seen_message_id($link);
  $roomID = $_SESSION['roomID'];
  $sql = "SELECT * FROM messages JOIN users ON messages.UserID = users.UserID
  WHERE messages.RoomID = '$roomID' AND messageID > $last_seen ORDER BY MessageID ASC";
  $result = mysqli_query($link, $sql);

  //Returns messages in JSON and sets most recent seen in DB
  $last_seen = create_message_json($result);
  if (!is_null($last_seen))
  {
    set_most_recent_seen($link, $last_seen);
  }
}

//Outputs all messages in JSON format
function create_message_json($result)
{
  $roomident = $_SESSION['roomID'];
  $numrows = mysqli_num_rows($result);
  $i = 1;
  if ($numrows > 0)
  {
    echo '{"messages":[';
    while ($row = mysqli_fetch_assoc($result))
    {
      echo '{"messageid":"' . $row['MessageID'] . '",';
      echo '"roomid":"' . $row['RoomID'] . '",';
      echo '"userID":"' . $row['UserID'] . '",';
      echo '"username":"' . $row['Username'] . '",';
      echo '"content":"' . decrypt_data($roomident, $row['MessageContent']) . '"}';
      if ($i == $numrows) {
        echo "]}";
        $last_seen = $row['MessageID'];
      }
      else {
        echo ",";
      }
      $i++;
    }
    return $last_seen;
  }
}

//Determines which message user has last seen
function get_last_seen_message_id($link)
{
  $userID = $_SESSION['userID'];
  $sql = "SELECT * FROM users WHERE userID = '$userID'";
  $row = mysqli_fetch_array(mysqli_query($link, $sql) , MYSQLI_ASSOC);
  return $row['last_seen_message_id'];
}

//Updates last_seen_message_id in database
function set_most_recent_seen($link, $last_seen)
{
  $userID = $_SESSION['userID'];
  $sql = "UPDATE users SET last_seen_message_id = '$last_seen' WHERE userID = '$userID'";
  mysqli_query($link, $sql);
}

//Prints current room
function get_current_room($link)
{
  echo 'Current room: '.$_SESSION['roomname'];
}

//Returns current username
function get_current_username($link)
{
  echo 'Username: '.$_SESSION['username'];
}

//Deals with API responses (printing error messages and such)
function api_response($response)
{
  echo "<div class=\"message\"><i>&ltSYSTEM&gt $response</i></div>";
}
?>
