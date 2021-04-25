<?php
	if(!defined('BASE_ENCRYPTION_DIR')) define('BASE_ENCRYPTION_DIR', 'E:\xampp\htdocs\404chat_developer\php\includes\encryption');
  include "./includes/encryption/encryption.php";

  $message = "5Zp/qijabsjUgsR5aRFXFQ==";
  $roomident = '4testroom';
  $decrypted_message = decrypt_data($roomident, $message);
  echo "Message: ".$message."<br>";
  echo "Decrypted Message: ".$decrypted_message."<br>";
?>
