<!DOCTYPE HTML>
<?php
	include 'adminconf.php';
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Administrator Login - Images
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
        					<a href="admin.php">
        						Admin
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
			<form method="post" action="admin2.php" class="form-horizontal" role="form">
				<span style="font-size: 18pt;">
					Adminstration login
				</span>
				<br>
				<div class="form-group">
					<label for="username">
						Enter username
					</label>
					<input type="edit" name="username">
					<?php
						if ($security) {
							echo '
							<br>
							<br>
							<label for="password">
								Enter password
							</label>
							<input type="password" name="password">
							';
						}
					?>
				</div>
				<div class="form-group">
					<label for="submit">
						Click to login
					</label>
					<input type="submit" value="Login" class="btn btn-primary">
				</div>
				</form>
				<?php
				    if (isset( $_GET[ 'error' ] ) ) {
    					echo '<b class="label label-danger" style="font-size: 10pt;">ERROR: Wrong username/password provided or session timed out! If it is still not working, contact the owner!</b>';
    				}
				?>
			</div>
	</body>
</html>

