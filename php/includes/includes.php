<?php
	if(session_status() == PHP_SESSION_NONE) session_start();
	include_once "connect.php";
	include_once "functions.php";
	include_once "settings.php";
	include_once "prevent_curl.php";
?>
