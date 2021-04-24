<?php
	include "./includes/includes.php";

	$author = protectString($_SESSION["username"]);
	$message_string = protectString($_POST["message_content"]);
	$message_string = encryption_404chat($message_string, 'encrypt');
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
