<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
$_SESSION['toname']=$_POST['tonamebutton'];
if(isset($_SESSION['toname'])){
    header("Location: personal.php");
}
else{
    echo "<script>alert('please select any menu option to chat with them')</script>";
    header("Location: main.php");
}
?>