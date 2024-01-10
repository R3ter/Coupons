<?php
$servername = "localhost";
$username = "waleed1";
$password = "waleed";

$conn = new mysqli($servername, $username, $password, "Coupon");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>