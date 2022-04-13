<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask Group</title>
    <script src="https://kit.fontawesome.com/89337bc6e5.js" crossorigin="anonymous"></script>
</head>
<link href="style.css" rel="stylesheet" type="text/css">
<body onload="show_func()">
<script>
function show_func(){
 
 var element = document.getElementById("chathist");
    element.scrollTop = element.scrollHeight;
  
 }
 
 </script>
<div id="container">
	<main>
<form id="myform" action="Group_chat.php" method="POST" ></form>
<form id="refresh" action="" method="POST" ></form>
<form id="personal" action="personal1.php" method="POST" ></form>
   <?php include 'header.php';?>
<div class="myform1">
    <div class="boxa">
        <div class="container"><a class="asub1" href="main.php">Home</a></div>
        <div class="container"><a class="asub1" href="Group_chat.php">Group Chat</a></div>
        <?php
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db_name = "login_register_pure_coding";
        $con = new mysqli($host, $user, $pass, $db_name);
        
        $querys = "SELECT * FROM users";
        $runs = $con->query($querys);
        ?>
        <?php
        while($rows = mysqli_fetch_array($runs)){
            if(($rows['username']!=$_SESSION['username'])&& ($rows['is_verified']==1)){
        ?>
                <div class="container"><input class="asub" type="submit" form="personal" value="<?php echo $rows['username']; ?>" name="tonamebutton"></div>
        <?php
            }
        }
        ?>
    </div>
    <div class="inner_div_main" id="chathist">
        <div class="myInfo">
            <p class="datainfo1">Your personal info</p>
            <?php
            $usename=$_SESSION['username'];
            $querys = "SELECT * FROM users WHERE username='$usename'";
            $runs = $con->query($querys);
            $fetchinfo=mysqli_fetch_assoc($runs);
            ?>
            <div class="datainfo">Your Name: <?php echo $fetchinfo['name'] ?></div>
            <div class="datainfo">Your Username: <?php echo $fetchinfo['username'] ?></div>
            <div class="datainfo">Your Email-Address: <?php echo $fetchinfo['email'] ?></div>
        </div>
    </div>
    <footer>
        <div class="sub_main"><input form="myform" class="input2" type="submit" id="submit"
			name="submit" value="Group Chat"></div>
        <div class="log_main"><button class="out"  onclick="location.href='logout.php'">Log out</button></div>
    </footer>
    <div class="endf">
    <div class="tst"> Copyright @2022 | Made by <a class="tst1" href="https://www.instagram.com/a_d_i___t_y_a_/"> Aditya </a>and <a class="tst1" href="https://www.instagram.com/rishabh_iitr/"> Rishabh</a><br></div> 
</div>
</div>
</main>
</div>

</body>

</html>