<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "productdb"; // change to your DB name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
