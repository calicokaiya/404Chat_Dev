<?php
	include "./includes/includes.php";

	$author = protectString($_SESSION["username"]);
	$message_string = protectString($_POST["message_content"]);
	$roomident = $_SESSION['roomID'].$_SESSION['roomname'];
	$message_string = encrypt_data($roomident, $message_string);
	$roomID = $_SESSION['roomID'];
	$userID = $_SESSION['userID'];

	if($roomID != '1') {
	  $sql = "INSERT INTO messages (RoomID, UserID, MessageContent) VALUES ('$roomID', '$userID', '$message_string')";
		if(mysqli_query($link, $sql)) {
	    echo mysqli_info($link);
	  }
		else {
			echo "error".mysqli_error($link);
		}
	}
	mysqli_close($link)
?>
