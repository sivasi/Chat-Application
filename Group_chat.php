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
    <meta http-equiv="refresh" content="60; URL=Group_chat.php">
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
<form id="myform" action="" method="POST" ></form>
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
    <div class="inner_div" id="chathist">
        <?php
             if (!isset($_SESSION['username'])) {
                 header("Location: index.php");
             }
            if (isset($_POST['submit'])){
                $link = mysqli_connect("localhost",
	            			"root", "", "chat_app");
	            // Check connection
	            if($link === false){
	            	die("ERROR: Could not connect. "
	            			. mysqli_connect_error());
	            }
	            
	            // Escape user inputs for security
	            $un= mysqli_real_escape_string(
	            		$link, $_SESSION['username']);
	            $m = mysqli_real_escape_string(
	            		$link, $_REQUEST['msg']);
    
	            // Attempt insert query execution
	            $sql = "INSERT INTO chats (uname, msg, dt)
	            			VALUES ('$un', '$m',CURRENT_TIMESTAMP())";
	            if(mysqli_query($link, $sql)){
	            	;
	            } else{
	            	echo "ERROR: Message not sent!!!";
	            }
	            
	            // Close connection
	            mysqli_close($link);
            }
            ?>
    
            <?php
            $host = "localhost";
            $user = "root";
            $pass = "";
            $db_name = "chat_app";
            $con = new mysqli($host, $user, $pass, $db_name);
            
            $query = "SELECT * FROM chats";
            $run = $con->query($query);
            while($row = mysqli_fetch_array($run)){
                if($row['uname']==$_SESSION['username']){
                ?>
                    <div id="message1" class="message1">
                        <div class="message1a">
                        <span class="box1"> <?php echo $row['msg']; ?> </span> <br/>
                        <div>
                            <span class="box12"> <?php echo $row['uname']; ?>, <?php echo $row['dt']; ?> </span>
                        </div>
                        </div>
                    </div>
                    <br/><br/>
                <?php
                }
                else
                {
                ?>
                        <div id="message2" class="message2">
                            <div class="message2a">
                            <span class="box2"> <?php echo $row['msg']; ?></span> <br/>
                            <div>
                                <span class="box22"> <?php echo $row['uname']; ?>, <?php echo $row['dt']; ?> </span>
                            </div>
                            </div>
                        </div>
                        <br/><br/>
                <?php
                } 
            }
                ?>
                <div id="vis"></div>
    </div>
    <?php include'footer.php' ?>
</div>
</main>
</div>

</body>

</html>
