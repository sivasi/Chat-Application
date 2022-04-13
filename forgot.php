<?php 

include 'config.php';

error_reporting(0);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//check if the user

function sendMail($email,$v_code){
	
	require("PHPMailer/PHPMailer.php");
	require("PHPMailer/SMTP.php");
	require("PHPMailer/Exception.php");
	$mail = new PHPMailer(true);
	try {
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'askgroup121@gmail.com';                     //SMTP username
		$mail->Password   = 'Ananya@12345';                                //SMTP password
		$mail->SMTPSecure =   PHPMailer::ENCRYPTION_STARTTLS;              //Enable implicit TLS encryption
		$mail->Port       =  587;                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	 
		//Recipients
		$mail->setFrom('askgroup121@gmail.com', 'Ask Group');
		$mail->addAddress($email);     //Add a recipient

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Password reset verification mail';
		$mail->Body    = "Click the link below to verify the email address and reset password 
		<a href='https://learn2earn.xyz/verify1.php?email=$email&verification_code=$v_code'>Click here.</a>";
		$mail->send(); 
		return true;
	} catch (Exception $e) {
		return false;		 
	}
}
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
    $email = $_POST['email'];
	$password = md5($_POST['password']);
    $cpassword=md5($_POST['cpassword']);
    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            $sql = "SELECT * FROM users WHERE username='$username' && email='$email'";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $v1_code=bin2hex(random_bytes(16));
                $result_fetch=mysqli_fetch_assoc($result);
                $update="UPDATE `users` SET is_verified='0' , password='$password' , verification_code1='$v1_code' WHERE `email`='$result_fetch[email]' ";
                if(mysqli_query($conn,$update)){
                    $sql1 = "SELECT * FROM users WHERE username='$username' && email='$email'";
                    $run = $conn->query($sql1);
                    $row = mysqli_fetch_assoc($run);
                    if( ($row['password']==$password) && ($row['is_verified']==0) &&   $row['verification_code1']==$v1_code){
                        if(sendMail($_POST['email'],$v1_code)){
                            echo "<script>alert('Mail sent succussfully! please check mail-id for password reset');
                            window.location.href='index.php'</script>";
                        }
                        else{
                            echo "<script>alert('Woops! Something Wrong Went. mail doesnot sent..Password didnot reset..please check your internet connection')</script>";
                        }
                    }
                    else {
                        echo "<script>alert('Woops! Something Wrong Went. or server down....try later ..Password didnot reset')</script>";
                    }
                }
                else {
					echo "<script>alert('Woops! Something Wrong Went. or server down..Password didnot reset')</script>";
				}
            } 
            else {
                echo "<script>alert('Woops! Email-id is Wrong..')</script>";
            }
        }
        else{
            echo "<script>alert('Woops! Username is wrong..')</script>";
        }
    }
    else {
		echo "<script>alert('Password and Confirm password Not Matched.')</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style2.css">

	<title>Ask Group</title>
</head>
<body>
	<div class="heading">Ask Group</div>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 1.5rem; font-weight: 800;">Reset Password</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
            <div class="input-group">
				<input type="password" placeholder="New-password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm new-password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Reset password</button>
			</div>
			<p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
			<p class="login-register-text">Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>
</html>