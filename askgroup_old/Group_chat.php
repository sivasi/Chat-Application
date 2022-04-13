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
		<header>
			<div class="title">
				Ask Group
			</div>
            <div class="usersname"><div class="u">Welcome <br><?php echo $_SESSION['username']; ?></div></div>
		</header>

<form id="myform" action="Group_chat.php" method="POST" >
    <div class="inner_div" id="chathist">
        <?php
         if (!isset($_SESSION['username'])) {
             header("Location: index.php");
         }
        if (isset($_POST['submit'])){
            $link = mysqli_connect("localhost",
	        			"root", "Ananya@12345", "chat_app");
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
        $pass = "Ananya@12345";
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
    <footer>
        <div class="message"><input id="msg"  class="msg" name="msg" placeholder="Type your message.."></div>
        <div class="sub"><input class="input2" type="submit" id="submit"
			name="submit" value="send"></div>
        <div class="refresh"><button class="re">Refresh</button></div>
        <div class="log"><button class="out"  onclick="location.href='logout.php'">Log out</button></div>
	</footer>
    <div class="endf">
       <div class="tst"> Copyright @2021 | Made by Aditya Kumar <br></div> 
    </div>
</form>
</main>
</div>

</body>

</html>