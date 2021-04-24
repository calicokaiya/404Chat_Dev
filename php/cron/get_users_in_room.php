<?php
	include "./includes/includes.php";

	print_r($_SESSION);
	$sql = 'SELECT * FROM users WHERE RoomID = '.$_SESSION['roomID'];
	if(mysqli_query($link)) {
		echo
	}

	mysqli_close($link);
?>
