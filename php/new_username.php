<?php
	include "./includes/includes.php";

	if(isset($_POST['username'])) {
		register_user($_POST['username'], $link);
	}
	else {
		echo "username not set";
	}
	mysqli_close($link);
?>
