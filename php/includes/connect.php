<?php
$server = "127.0.0.1";
$username = "root";
$password = "";
$database = "404chat";

// Create connection
$link = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$link) {
  echo "Error: Unable to connect to MySQL.";
  echo "Debugging errno: " . mysqli_connect_errno();
  echo "Debugging error: " . mysqli_connect_error();
  exit;
}
?>
