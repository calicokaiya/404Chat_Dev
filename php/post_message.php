<?php
	include "./includes/includes.php";

	$author = protectString($_SESSION["username"]);
	$message_string = protectString($_POST["message_content"]);
	$roomID = $_SESSION['roomID'];
	$userID = $_SESSION['userID'];
	$message_string = encrypt_data($roomID, $message_string);

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
