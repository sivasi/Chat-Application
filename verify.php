<?php
require("config.php");

if(isset($_GET['email'])&& isset($_GET['verification_code'])){
    $query="SELECT * FROM `users` WHERE `email`='$_GET[email]' AND `verification_code`='$_GET[verification_code]'";
    $result=mysqli_query($conn,$query);
    if($result){ 
        if(mysqli_num_rows($result)==1){
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['is_verified']==0){
                $update="UPDATE `users` SET `is_verified`='1' WHERE `email`='$result_fetch[email]' ";
                if(mysqli_query( $conn,$update)){
                    echo "<script>alert('Wow! Email verification successful');
                    window.location.href='index.php';
                    </script>";
                } 
                else{  
                   echo "<script>alert('Hey! Email-Address didn't verified')</script>";
                }
            }
            else{
                echo "<script>
                alert('Hey! Email-Address already verified');
                window.location.href='index.php';
                </script>";
            }
        }
    }
    else{
        echo "<script>alert('Woops! Email address not registered or verification code mismatched')</script>";
    }
}
?>