<?php 
$host = "localhost";
$user = "root";
$password = "";
$dbName = "form_1";

$conn = new mysqli($host, $user, $password, $dbName);

if($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}
?>
