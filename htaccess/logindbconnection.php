<?php
$conn = new mysqli('127.0.0.1', 'root', 'Info310!', 'users');
if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}
?>
