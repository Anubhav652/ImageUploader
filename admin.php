<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Administrator Login - Images
		</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>
	<body oncontextmenu="return false;">
		 <div class="jumbotron">
    		<h1>
    			Anubhav's Image Uploader
    		</h1>
  		</div>
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
				<form method="post" action="" class="form-horizontal" role="form">
					<span style="font-size: 18pt;">
						Adminstration login
					</span><br>
					<div class="form-group">
						<label for="password">
							Enter security key
						</label>
						<input type="password" name="password">
					</div>
					<div class="form-group">
						<label for="submit">
							Click to login
						</label>
						<input type="submit" value="Login" class="btn btn-default">
					</div>
				</form>
			</div>
	</body>
</html>
<?php
	require( 'adminconf.php' );
    if (isset( $_POST[ 'password' ] ) ) {
    	$value = $_POST[ 'password' ];
    	if ( $value == $securekey ) {
    		$sec = sha1( $securekey );
    		echo "<script>window.location = 'admin2.php?pass=".$sec."'</script>";
    	} else {
    		echo 'False password';
    	}
    }
?>
