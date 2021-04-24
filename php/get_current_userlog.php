<?php
	include "./includes/includes.php";

	function get_current_userlog($link) {
		$sql = 'SELECT * FROM `users` WHERE room_id = '.$_SESSION['roomID'];
		$result = mysqli_query($link, $sql);
		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				echo $row['Username']."<br>";
			}
		}
	}

	if(user_is_registered($link)) {
		get_current_userlog($link);
	}

	mysqli_close($link);

/*
It will get everyone that is in current user room and present it back.
*/
