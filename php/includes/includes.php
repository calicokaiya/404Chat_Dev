<?php
	if(session_status() == PHP_SESSION_NONE) session_start();
	include "connect.php";
	include "functions.php";
	include "settings.php";
	include "prevent_curl.php";
?>
