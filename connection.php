<?php
// Database connection settings
$host = "localhost";
$user = "root";
$password = '';
$db_name = "milk_tea_shop";

// Establishing the connection
$con = mysqli_connect($host, $user, $password, $db_name);

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>