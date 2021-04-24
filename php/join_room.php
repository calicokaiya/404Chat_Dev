<?php
	include "./includes/includes.php";

	$room = protectString($_POST['roomname']);
	$password = protectString($_POST['password']);
	$userID = protectString($_SESSION['userID']);

	joinroom($link, $room, $password);
	mysqli_close($link);
?>
