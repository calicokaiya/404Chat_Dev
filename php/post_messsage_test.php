<?php
	include "./includes/includes.php";


	if(isset($_POST['message_content'])) {
		echo $_POST['message_content'];
	}
	else {
		echo "What the fuck";
	}
	mysqli_close($link)
?>
