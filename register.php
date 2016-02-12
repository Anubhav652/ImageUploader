<!DOCTYPE HTML>
<?php
	if (isset($_COOKIE['LoggedIn'])) {
		echo '<script>location.href="index.php"</script>';
	}
	$MESSAGE = "Messages are noted here when you click the register button.";
	include 'uploads/images_sqlite.php';

	if (isset( $_GET['username']) && isset( $_GET['password'] )) {
		$username = $_GET['username'];
		$password = $_GET['password'];
		$exist = doesAccountExist(  $username );
		if ($exist == "Yes") {
			$MESSAGE = "ERROR: Account already exists! Please choose another username!";
		} else {
			$MESSAGE = "You have registered your account!";
			registerAccount( $username, $password );
		}
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Register - Images
		</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="js/bootstrap.min.js"></script>
	</head>
	<body oncontextmenu="return false;">
  		<nav class="navbar navbar-inverse">
  			<div class="container-fluid">
    			<div class="navbar-header">
      				<a class="navbar-brand" href="index.php">
      					Anubhav's Image Uploader
      				</a>
    			</div>
    			<div>
      				<ul class="nav navbar-nav">
        				<li>
        					<a href="index.php">
        						Home
        					</a>
        				</li>
        				<li>
        					<a href="login.php">
        						Login
        					</a>
        				</li>
        				<li class="active">
        					<a href="">
        						Register
        					</a>
        				</li>
        			</ul>
    			</div>
 		 	</div>
		</nav>
		<div class="container">
			<br>
			<br>
			<br>
			<span style="font-size: 18pt;">
				Register
			</span>
			<br>
			<form action="register.php" method="get">
				<div class="form-group">
					<label for="username">
						Enter username
					</label>
					<input type="edit" name="username">
					<br>
					<br>
					<label for="password">
						Enter password
					</label>
					<input type="password" name="password">
				</div>
				<div class="form-group">
					<input class="btn btn-primary" value="Register" type="submit">
				</div>
			</form>
			<b class="label label-warning" style="font-size: 10pt;">
				<?php
					echo $MESSAGE;
				?>
			</b>
		</div>
	</body>
</html>

