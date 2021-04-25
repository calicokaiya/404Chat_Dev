<?php
	include "..\\includes\\includes.php";

	//UPDATED COMMENTS, I'M TOO LAZY TO UPDATE THEM RN, CONCEPT IS THE SAME.
	//First, it deletes all info where daily_delete = 1.
	//Then, it resets the auto_increment values.
	//Then it adds all the information needed.

	delete_encryption_files();
	delete_encrypted_directory();
	create_encrypted_directory();
	create_encryption_file();

	//All messages to be written to admin page
	$messages = [
		'Welcome to 404Chat, where privacy and anonymity is number 1 priority.',
		'We don\'t keep any identifiable information about you in our databases (except for your username), '.
			'all messages are deleted periodically, and the database is reset once a day.',
		'If you want, you can request to delete your messages sooner with the click of a button.',
		'To create a private chatroom, use the command /create roomname [password] (where password is optional)',
		'To join a chatroom use the command /join roomname [password] (where password is optional as well)',
		'The creator of the website is not responsible or liable for any information leaks caused by you.',
		'This project was developed by a programming student. Take that as you will about security (more info on the about page)',
		'You may not write in the main channel, and if this somehow gets popular and breaks, well...',
		'Just know that that was never the plan.',
		'If this is your first time here, check out the about page.'
	];

	//Protects all messages
	$messages_protected = [];
	foreach($messages as $message) {
		array_push($messages_protected, protectString($message));
	}

	//Deals with encryption
	$enc_info = create_encryption_data();
	$roomident = '1main';
	print_r($enc_info);
	write_to_encryption_file($roomident, $enc_info);
	$messages_encrypted = [];
	foreach($messages_protected as $message) {
		$message = openssl_encrypt($message, $enc_info['method'], $enc_info['key'], $enc_info['options'], $enc_info['iv']);
		array_push($messages_encrypted, $message);
	}

	//Query array
	$sql = [
		'DELETE FROM users WHERE daily_deletion = 1',
		'DELETE FROM messages',
		'DELETE FROM rooms WHERE daily_deletion = 1',
		'ALTER TABLE users AUTO_INCREMENT=1',
		'ALTER TABLE messages AUTO_INCREMENT=1',
		'ALTER TABLE rooms AUTO_INCREMENT=1',
		'UPDATE users set daily_deletion = REPLACE(daily_deletion, 0, 1);',
		'UPDATE rooms set daily_deletion = REPLACE(daily_deletion, 0, 1);',
		'INSERT INTO `users`(`UserID`, `Username`, `room_id`, `last_seen_message_id`) VALUES (1, \'Admin\', 1, 0)',
	];

	//Creates new main room
	$room_name = encrypt_room_data('main')["roomname"];
	$room_creation_query = "INSERT INTO `rooms`(`RoomID`, `RoomName`, `RoomPassword`) VALUES (1, '$room_name', '')";
	array_push($sql, $room_creation_query);

	//Appends welcome messages
	foreach($messages_encrypted as $message) {
		$command = "INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, '$message')";
		array_push($sql, $command);
	}

	//Executes alll queries
	foreach($sql as $query) {
		if(!mysqli_query($link, $query)) {
			echo "$query.<br>Error: ".mysqli_error($link)."<br>";
		}
	}

	mysqli_close($link);
?>
