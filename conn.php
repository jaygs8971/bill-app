<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$db = "invoice";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
global $conn;
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


echo '<script type="text/JavaScript"> 
     console.log("Connected successfully");
     </script>';


//$conn->close();
