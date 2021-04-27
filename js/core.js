//Updates userlog
function update_userlog() {
	//Make an AJAX call to determine if user is registered or not
	$.ajax({
		type: "GET",
		url: "./php/get_current_userlog.php",
		success: function(response) {
			$("#userlog_userlist").html(response);
		}
	});
}

//Updates current room in navbar
function nb_update_current_room() {
	//Make an AJAX call to get a room
	$.ajax({
		type: "GET",
		url: "./php/get_current_room.php",
		success: function(response) {
			$("#navbar_room").text(response);
		}
	});
}

//Updates current username in navbar
function nb_update_current_username() {
	//Make an AJAX call to get current username
	$.ajax({
		type: "GET",
		url: "./php/get_current_username.php",
		success: function(response) {
			$("#navbar_username").text(response);
		}
	});
}


//Sends message
function send_message() {
	event.preventDefault();
	let message_content = $('#chatbox_messageinput').val();

	//check for chat commands before sending
	if (message_is_valid(message_content)) {
		if (!message_is_command(message_content)) {
			message_info = {
				message_content: message_content,
			};

			//Sends messages to the database
			$.ajax({
				type: "POST",
				url: "./php/post_message.php",
				data: message_info,
				error: function() {
					alert('Error sending message. Check your connection and try again.');
				}
			});

		}
	} else {
		alert('Message must not be empty, and it must be smaller than 2000 characters.')
	}

	//Resets text in message box
	$("#chatbox_messageinput").val("");
	scroll_to_bottom();
}

//Downloads messages
function get_messages() {
	$.ajax({
		type: "GET",
		url: "./php/get_messages.php",
		success: function(response) {
			//If user is not set
			if (response == '0') {
				document.location.reload(true);
			}

			//If we actually receive messages
			else if(response != '0' && response != '') {
				try {
					let jsoncontents = JSON.parse(response);
					for (i in jsoncontents.messages) {
						let author = jsoncontents.messages[i].username;
						let message = jsoncontents.messages[i].content;
						let outputstring = '<div class="message"><b>' + author + ':</b> ' + message + '</div>';
						$("#chatbox_messages").append(outputstring);
					}
				}
				catch(e) {

				}
				finally {
					scroll_to_bottom();
				}
			}
		},
	});
}

//Scrolls chat to the bottom
function scroll_to_bottom() {
	let element = document.getElementById("chatbox_messages");
	element.scrollTop = element.scrollHeight
}

function reload_messages() {
	$.ajax({
		type: "GET",
		url: "./php/reload_messages.php",
		success: function(response) {
			$("#chatbox_messages").append('<div class="message"><i>&ltSYSTEM&gt Reloading messages...</i></div>');
			get_messages();
		},
	});
}

function set_reset_false() {
	$.ajax({
		type: "GET",
		url: "./php/set_reset_false.php",
		success: function(response) {
			$("#chatbox_messages").append(response);
		},
	});
}

//Cleans chat locally
function clean_chat() {
	$("#chatbox_messages").empty();
}

function apply_theme(theme) {
	console.log(theme);
	if(theme == 'dark') {
		$("#navbar").removeClass("navbar-light");
		$("#navbar").removeClass("bg-light");
		$("#navbar").addClass("navbar-dark");
		$("#navbar").addClass("bg-dark");
		$("body").css("background-color", "#1A1A1A");
		$("body").css("color", "#FFFFFF");
		$("#chatbox_container").css("border", "1px solid white");
	}
	else {
		$("#navbar").removeClass("navbar-dark");
		$("#navbar").removeClass("bg-dark");
		$("#navbar").addClass("navbar-light");
		$("#navbar").addClass("bg-light");
		$("body").css("background-color", "white");
		$("body").css("color", "black");
		$("#chatbox_container").css("border", "1px solid black");
	}
}

function change_theme(old_theme) {
	let theme = ''
	if(old_theme == 'light') {
		theme = 'dark';
	}
	else {
		theme = 'light';
	}
	console.log('Changing from ' + old_theme + ' to ' + theme);
	return theme;
}

//Toggles between 3secs and 1sec wait time to get new messages, and changes btn text
function toggle_datasaver(get_message_delay) {
	if(get_message_delay == 1) {
		console.log('Turning data saver on');
		get_message_delay = 3;
		$("#btn_toggle_datasaver").text('Data saving mode (Enabled)');
	}
	else {
		console.log('Turning data saver off');
		get_message_delay = 1;
		$("#btn_toggle_datasaver").text('Data saving mode (Disabled)');
	}
	console.log('Returning ' + get_message_delay);
	return get_message_delay;
}

function update_time() {
	$.ajax({
		type: "GET",
		url: "./php/get_current_time.php",
		success: function(response) {
			$("#servertime").text(response);
		},
	});
}


//Document load...
$(document).ready(function() {
	console.log('Jquery loaded')
	let theme = 'dark';
	nb_update_current_room();
	nb_update_current_username();
	get_messages();
	update_userlog();
	update_time();

  //Sends messages
  $("#sendmsg_button").click(function() {
		send_message();
  });

  //Receives messages and updates userlog
  setInterval(() => {
    get_messages();
  }, 1000*1);

	//Updates clock
	setInterval(() => {
		update_time();
	}, 1000*60);

	//Updates userlog
	setInterval(() => {
		update_userlog();
	}, 1000*5);

		//Detects when user presses enter to send message
	$(document).keypress(function (e) {
		var key = e.which;
		if(key == 13)  // the enter key code
		{
			$('#sendmsg_button').click();
		}
	});

	//Detects when user clicks "reload messages" button
	$("#btn_reload_messages").click(function() {
		reload_messages();
	});

	//Detects when user clicks "reload messages" button
	$("#btn_dont_reset").click(function() {
		set_reset_false();
	});

	//Cleans chat locally
	$("#btn_clean_chat").click(function() {
		clean_chat();
	});

	//Toggles between light and dark mode
	$("#btn_toggle_darkmode").click(function() {
		theme = change_theme(theme);
		apply_theme(theme);
	});

	//NOT WORKING: Turns on data saver mode (gets messages every 3 secs instead of 1)
	$("#btn_toggle_datasaver").click(function() {
		get_message_delay = toggle_datasaver(get_message_delay);
	});
});
