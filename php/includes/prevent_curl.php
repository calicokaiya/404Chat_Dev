<?php
	$useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
	if(strstr($useragent, 'CURL')) {
		die();
	}
?>
