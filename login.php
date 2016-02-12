<!DOCTYPE HTML>
<?php
	if (isset($_COOKIE['LoggedIn'])) {
		echo '<script>location.href="index.php"</script>';
	}
	$MESSAGE = "Messages are noted here when you click the login button.";
	$Login = "";
	include 'uploads/images_sqlite.php';

	if (isset( $_GET['username']) && isset( $_GET['password'] )) {
		$username =  $_GET['username'];
		$password = sha1( $_GET['password'] );
		$exist = accountExist( $username, $password);
		$MESSAGE = $exist;
		if ($exist == "Success! You have logged in, please wait, redirecting you to the homepage!") {
			setcookie("LoggedIn", $_GET['username']);
			$Login = "Yes";
		}
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			if ($Login == "Yes") {
				echo  '
				<script>
					location.href = "index.php";
				</script>';
			}
		?>
		<title>
			Login - Images
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
        				<li class="active">
        					<a href="">
        						Login
        					</a>
        				</li>
        				<li>
        					<a href="register.php">
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
				Login
			</span>
			<br>
			<form action="login.php" method="get">
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
					<input class="btn btn-primary" value="Login" type="submit">
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

