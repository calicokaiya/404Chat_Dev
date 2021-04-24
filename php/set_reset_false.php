<?php
	include "./includes/includes.php";
	$sql = [
		'UPDATE `users` SET `daily_deletion` = 0 WHERE `users`.`UserID` = '.$_SESSION['userID'],
		'UPDATE `rooms` SET `daily_deletion` = 0 WHERE `rooms`.`roomID` = '.$_SESSION['roomID']
	];
	foreach($sql as $query) {
		mysqli_query($link, $query);
	}

	api_response('Won\'t delete your information or kick you out on today\'s daily reset.');
	api_response('Feel free to press the "delete my info" button at any time if you change your mind.');

	mysqli_close($link);
?>
