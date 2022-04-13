<?php 

$server = "localhost";
$user = "root";
$pass = "Ananya@12345";
$database = "login_register_pure_coding";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>