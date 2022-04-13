
<header>
    <input type="checkbox" id="check" class="icon1">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    <div class="title">Ask Group</div>
    <div class="usersname"><div class="u">Welcome <br><?php echo $_SESSION['username']; ?></div></div>
    <div class="box">
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
        while($rows = mysqli_fetch_array($runs)){
            if(($rows['username']!=$_SESSION['username'])&& ($rows['is_verified']==1)){
        ?>
                <div class="container"><input class="asub" type="submit" form="personal" value="<?php echo $rows['username']; ?>" name="tonamebutton">></div>
        <?php
            }
        }
        ?>
    </div>
</header>
