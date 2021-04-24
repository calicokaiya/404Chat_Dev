<?php
	include "../includes/includes.php";

	//First, it deletes all info where daily_delete = 1.
	//Then, it resets the auto_increment values.
	//Then it adds all the information needed.

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
		'INSERT INTO `rooms`(`RoomID`, `RoomName`, `RoomPassword`) VALUES (1, \'VVdyVGpUeGlsR3pIT0RUQWxTWFZuUT09\', \'\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'SlJwWHg5STZWajlSbytBOUtmbG94MzdWU1Erd2JNdzRWaWgwSW5keG1HWmYraThzaExuWkk3WGtqYzU5dkJOUHplRE5OMUdCd3gwd3hNNDMxbHA0ZGlKSHFacmx5NGViMDdTcENuLzF5cTQ9\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'S1pNakRES2FGM0U1dEtWQ29Ub1F5YnBmL0JDM2JqM3QwSHNWWHZPSHFSdGV6ZjgrcUplam04aHVENDgyQW1lTnBvWjVPMm1mMldRY0draUFzeFJjbDY2cmhJYmdLVEs1SFl4bWRYN3hGQzFKMVpHRVhxK1ZsdTlVUTJkZ2RKVXBiU1VVems5STBLMzNhVXRqMkdxUFZRPT0=\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'ODcvb2VIWENZd0pyanVpN3UyblhnZjBkcE1GZExyT3R3Wkd2TlJlM2V5YWFIVkl4a21TMjN4c0NLdGVZc3JOdjJWWEp6Q21HdFIzV1B1YVIvQWdVLzhGdG9ENkFCTWJHQ0xKRUJOd1BtcTRheCtud2k4Vk9OOVFGMUVnTDVQVWU=\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'MERHa3F6TmYrSTRPT1FkNUtsT3lPK01nTkU2eHIyNnJ5UzhaeUQ1VzYwdG9sM0pnRkJCam5vQUU4a0FrRjJaSWJOV2NLajIwbU1hbFdjL0R2Z01OQmJLRXJoL0xPdGFHdHFhYWhnV2J5QWs1QzhaMGRnVjBXNmtyYzI0SU83VDN5WWtmdHkwWHkzOWdyZHFkSlYzUUF3PT0=\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'aGY2SWxsVGFwWWxHVlhSTngyTVhPemE4aXcvSVZHaElGMWFqeFJwWkRMVHg4dVFNTkhGSkxmSk5LLy9vb3hPbm1aNGVHdHpmL1hlOGJNTGxOenhuUDh3Vm5wTzhsMUQ0LzBqVDl2ZXZ3UUJpMVpPSTdxT3hXNDBqTDNPODlVb1BDVDRHV3EvY3QxTW5PYmwycDVCSFh3PT0=\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'S3RFam5QRlZLR0QvRzJQZ0prTEUzUGZWdGRNU05xelpWaVE4YUw2SjUzb2lyVmZvRDk1ZUVXMHMweWZhdm9wdFhndnBYT1Jnd25rdGp5Q3Q5KzFrUFZDRnV5RVY3a2NUSDh3N1BaWmpuNVNhNkhBZ1g1T2NmUGtLeFNYc2dtcUhjK2wzTXhMTnJRR3piQ1pOLzBPR1hRPT0=\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'UityY3FaOUlWd0pFcDRuQktWOUpZZEdMaXdlcDJycXowSmFXOHVhdlFVN3I5ajExb3oza2VmeDFOT3dTaFBmbG50cDJoS2dmZllNbVFlMXNSNmw2cDkwREVlenV2eDE3SitIWWlxVlpIWC9zL3JiQkh4VGQ2UDN5R3ordm5TWTVidGlTbjl4M0YxNWFzOElOZ3VwTkhkUE53OWc1QVdPcEVxbjNGVHFDQ2RVPQ==\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'bUN0OVE1a0F6b29maXNzNy9lbjFyTXRCSEwzeGt0emt6Q3JqZi9LNlhlU3MvdGZ3NWttbWVwNXkyQ2p3MjhaZGI4UUtaYWZFQ3pOOWtRNWJxbFlxMWZkNmRyc2tFb1JzY0I0S1lWV0w5S0lvV20vNVhLK1hXbWNPdzM2dE9OeTQ=\')',
		'INSERT INTO `messages`(`RoomID`, `UserID`, `MessageContent`) VALUES (1, 1, \'cVdRbmxYci9WeU12WEs0YWVnNGUyZTQ1aHV6by9hYU16QVpzUitWdFUxYWwvZk1Jd0hVc1ZNaFhia0w4dHpEWndpcnZuZ3creHRsWURDeHNkWkpVUEE9PQ==\')'
	];

	foreach($sql as $query) {
		mysqli_query($link, $query);
	}

	mysqli_close($link);

/*'Welcome to 404Chat, where privacy and anonymity is number 1 priority.'
'We don&#039;t keep any information about you in our databases, and all messages are deleted every hour.'
'If you want, you can request to delete your messages sooner with the click of a button.'
'To create a private chatroom, use the command /create roomname [password] (where password is optional)'
'To join a chatroom use the command /join roomname [password] (where password is optional as well)'
'The creator of the website is not responsible or liable for any information leaks caused by you.'
'This project was developed by a programming student. Take that as you will about security (more info on the about page)'
'You may not write in the main channel, and if this somehow gets popular and breaks, well...'
'Just know that that was never the plan.'
'If this is your first time here, check out the about page.'*/
?>
