<?php
$servername = "db";          // This is the service name from docker-compose.yml (NOT localhost!)
$username   = "root";
$password   = "root_password";
$db_name    = "bookhive_db";

$conn = new mysqli($servername, $username, $password, $db_name, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
