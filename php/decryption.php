<?php
	include "./includes/includes.php";

  $string = 'Hello world!';
  $enc_string = encryption_404chat($string, 'encrypt');
  $dec_string = encryption_404chat($enc_string, 'decrypt');
  echo "Encrypted string: ".$enc_string;
  echo "<br>Decrypted string: ".$dec_string;
?>
