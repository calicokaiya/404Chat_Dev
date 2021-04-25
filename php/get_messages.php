<?php
	include "./includes/includes.php";

	if(user_is_registered($link)) {
		get_messages($link);
	}
	else {
		session_destroy();
		echo '0';
	}
	
	mysqli_close($link);
?>
