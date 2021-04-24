<?php
	#Includes need to be different to be run through a php terminal
	include __DIR__."\..\includes\includes.php";

	#Variables to log info in a text file
	$date = date("d/m/Y h:i:s");
	$log_string = "Wiped messages from db on: ".$date."\n";

	#This doesn't work when running through a php file, for some reason??? IDK why :S
	$file = "delete_messages_log.txt";
	$handle = fopen($file, 'w+') or die("Error opening file!");
	fwrite($handle, "Hello!");#$log_string);
	fclose($handle);

	$sql = [
		'DELETE FROM messages WHERE messages.RoomID != 1',
		'UPDATE `users` SET `last_seen_message_id` = \'9\' WHERE `users`.`UserID` = '.$_SESSION['userID'],
		'ALTER TABLE messages AUTO_INCREMENT=1'
	];

	foreach($sql as $query) {
		mysqli_query($link, $query);
	}

	echo "Ran message deletion script!\n";
	mysqli_close($link);
?>
