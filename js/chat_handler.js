//Takes text and outputs prepared HTML string for consistency
function create_system_command(text) {
	let system = [
		'<div class=\"message\"><i>&ltSYSTEM&gt ',
		'</i></div>'
	];

	return system[0] + text + system[1];
}

function cm_createroom(data) {
	$.ajax({
		type: "POST",
		url: "./php/create_room.php",
		data: data,
		success: function(response) {
			$("#chatbox_messages").append(response);
		},
		complete: function() {
			scroll_to_bottom();
		}
	});
}

function cm_joinroom(data) {
	$.ajax({
		type: "POST",
		url: "./php/join_room.php",
		data: data,
		success: function(response) {
			$("#chatbox_messages").append(response);
			nb_update_current_room();
			update_userlog();
		},
		complete: function() {
			scroll_to_bottom();
		}
	});
}

function cm_help() {
	console.log('Displaying help');
	helpstring = [
		create_system_command("/help displays this message"),
		create_system_command("ROOMNAME [PASSWORD] joins a room. Password is optional. (Example: /join newroom 123)"),
		create_system_command("/create ROOMNAME [PASSWORD] creates a room. Password is optional and ROOMNAME must be 1 word only.\
		Both are case sensitive. (Example: /create newroom 123)</i><br>"),
	];

	helpstring.forEach(command => {
		$("#chatbox_messages").append(command);
	});
}

function cm_notfound(command) {
	let message = create_system_command(command + " is not a valid command. Use /help for more info");
	$("#chatbox_messages").append(message);
}

//Determines if message is command
function message_is_command(message) {
	//If the message doesn't start with a "/", it's not a command
	if (message[0] != '/') {
		return false
	}
	//Prepares message for checks
	message = message.toLowerCase();
	message = message.trim();
	message = message.split(' ');

	//Determines what to do with message
	message_commands(message)
	return true;
}

//Determines which command is being called and acts on it
function message_commands(message) {
	let command = message[0]
	let first_arg = second_arg = ''
	if (message.length > 1) {
		first_arg = message[1];
	}
	if (message.length > 2) {
		second_arg = message[2];
	}

	let data = {
		roomname: first_arg,
		password: second_arg
	}

	//Determines which command was sent
	//Create room
	if (command == '/create') {
		cm_createroom(data);
	}

	//Join room
	else if (command == '/join') {
		cm_joinroom(data)
		nb_update_current_room();
	}

	//Help
	else if (command == '/help') {
		cm_help();
	}

	else {
		cm_notfound(command);
	}
}

//Determines if message is valid
function message_is_valid(message) {
	if (message.length != 0 && message.length < 2000) {
		return true
	}
	return false
}
