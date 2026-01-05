<?php
$servername = "localhost";
$username = "root";  // Update as needed
$password = "";      // Update as needed
$dbname = "admin_panel";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
