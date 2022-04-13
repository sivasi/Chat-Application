<?php 

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['username'])) {
    header("Location: main.php");
}

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$sql = "SELECT * FROM users WHERE username='$username'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$sql = "SELECT * FROM users WHERE username='$username' && password='$password'";
		$result = mysqli_query($conn, $sql);
		if ($result->num_rows > 0) {
			$row = mysqli_fetch_assoc($result);
			if($row['is_verified']==1){
				$_SESSION['username'] = $row['username'];
				header("Location: main.php");
			}
			else{
				echo "<script>alert('Woops! Your email-address is not verified..please verify it by checking the mail to log in')</script>";
			}
		} 
		else {
			echo "<script>alert('Woops! Password is Wrong..')</script>";
		}
	}
	else{
		echo "<script>alert('Woops! Username is wrong..')</script>";
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
			<p class="login-text" style="font-size: 1.5rem; font-weight: 800;">Login</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
			<p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
			<p class="login-register-text">Forgot password? <a href="forgot.php">Click Here</a>.</p>
		</form>
	</div>
</body>
</html>