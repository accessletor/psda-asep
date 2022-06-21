<?php  
session_start();
if (isset($_SESSION['login'])) {
	header("Location: index.php");
	exit;
}
require 'functions.php';
if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$result = mysqli_query($conn,"SELECT * FROM user WHERE username = '$username'");
	// cek username
	if (mysqli_num_rows($result) === 1) {
		// cek passwordny
		$row = mysqli_fetch_assoc($result);
		if (password_verify($password, $row['password'])) {
			// set session
			$_SESSION['login'] = true;
			header("Location: index.php");
			exit;
		}
	}
	$error = true;
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css">
</head>

<body>
	<div class="container">
		<h1>Login</h1>
		<?php if (isset($error)) : ?>
			<p style="color: red; font-style: italic;">Username / password salah</p>
		<?php endif; ?>
		<form action="" method="post">
			<label for="username">Username</label><br>
			<input type="text" name="username" id="username"><br>
			<label for="password">Password</label><br>
			<input type="password" id="password" name="password"><br>
			<button type="submit" name="login">Log in</button>
			<p> Belum punya akun?
				<a href="registrasi.php">Register di sini</a>
			</p>
		</form>
	</div>
</body>
</html>