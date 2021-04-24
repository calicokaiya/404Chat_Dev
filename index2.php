<?php
	session_start();

	if(!isset($_SESSION['username'])) {
		header('location: ./index.php');
		echo 'username is not set';
	}

	include "./imports/head.html";
?>
	<script src="js/chat_handler.js"></script>
	<script src="js/core.js"></script>
	<title>Chat</title>
</head>
<?php
	include "./imports/navbar.php";
?>
<body>
	<?php
	include "./imports/time_info.php";
	include "./imports/chatbox.html";
	include "./imports/button_bar.html";
	?>
	</body>
</html>
