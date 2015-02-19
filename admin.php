<!DOCTYPE HTML>
<html>
	<head>
		<title>Homepage - Admin</title>
		<link rel="stylesheet" type="text/css" href="design/style.css">	
	</head>
	<body oncontextmenu="return false;">
		<h1 class="title">Anubhav's Image Uploader</h1><br><br><br>
			<form method="post" action="">
				<span style="font-size: 18pt;">Adminstration login</span>
				<span style="font-size: 18pt;">Enter security key</span>
				<input type="password" name="password">
				<input type="submit" value="Login">
			</form>
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
