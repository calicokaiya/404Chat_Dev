<?php
	include "./includes/includes.php";

	//Defines needed variables and protects them
	if(isset($_POST['roomname']) && isset($_POST['password'])) {
	  $room = protectString($_POST['roomname']);
	  $password = protectString($_POST['password']);

	  //Creates room and joins it
	  if(room_is_valid($room)) {
	    createroom($link, $room, $password);
		  //joinroom($link, $room, $password); This is now executed in the createroom() method.
	  }
		else {
	    api_response('Room name provided was invalid. Must be between 3 and 20 characters.');
	  }
	}

	//Closes connection
	mysqli_close($link)
?>
