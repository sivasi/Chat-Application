<?php 

include 'config.php';

error_reporting(0);

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//check if the user is already logged in

if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
}
//function to send mail to user email-address 
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
		$mail->Subject = 'Email Verification from Ask Group application';
		$mail->Body    = "Thanks for registration! 
		Click the link below to verify the email address 
		<a href='https://www.learn2earn.xyz/verify.php?email=$email&verification_code=$v_code'>Click here.</a>";

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
	$cpassword = md5($_POST['cpassword']);

	if ($password == $cpassword) {
		$sql = "SELECT * FROM users WHERE username='$username'";
		$result = mysqli_query($conn, $sql);
		if (!$result->num_rows > 0 ) {
			$sql = "SELECT * FROM users WHERE email='$email'";
			$result = mysqli_query($conn, $sql);
			if (!$result->num_rows > 0 ) {
				$v_code=bin2hex(random_bytes(16));
				$sql = "INSERT INTO users (username, email, password,created_at,verification_code,is_verified)
				VALUES ('$username', '$email', '$password',CURRENT_TIMESTAMP(),'$v_code','0')";
				$result = mysqli_query($conn, $sql);
				if ($result && sendMail($_POST['email'],$v_code)){
					echo "<script>alert('Wow! User Registration Completed...please check Email id (spam folder) for email confirmation')</script>";
					$username = "";
					$email = "";
					$_POST['password'] = "";
					$_POST['cpassword'] = "";
				} else {
					echo "<script>alert('Woops! Something Wrong Went. or server down')</script>";
				}
			} 
			else {
				echo "<script>alert('Woops! Email Address Already Exists.')</script>";
			}
		}
		else{
			echo "<script>alert('Woops! Username Already Exists.')</script>";
		}
	} 
	else {
		echo "<script>alert('Password Not Matched.')</script>";
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="heading">Ask Group</div>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 1.5rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" id="email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>
</html>