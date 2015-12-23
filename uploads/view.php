<!DOCTYPE HTML>
<?php

function Size($path)
{
    $bytes = sprintf('%u', filesize($path)+1000);

    if ($bytes > 0)
    {
        $unit = intval(log($bytes, 1024));
        $units = array('B', 'KB', 'MB', 'GB');

        if (array_key_exists($unit, $units) === true)
        {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }
    }

    return $bytes;
}
function Extension($patch) {
	$path = pathinfo( $patch );
	return $path[ 'extension' ];
}
	$author = "";
	if( isset( $_GET['name'] ) ) {
		if (file_exists($_GET['name'].'.info')) {
			$file = fopen( $_GET['name'].'.info', "r" );
			$r = fread( $file, filesize( $_GET['name'].'.info' ) );
			$exp = explode( ",", $r );
			$author = $exp[0];
			$date = $exp[2] or "Unknown";
			fclose( $file );
		} else {
			echo "<script>document.location = '../index.php'</script>";
			return;
		}
	} else {
		die( 'ERROR: Restricted place for you!' );
		return;
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Viewing a image
		</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="../js/bootstrap.min.js"></script>
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
        					<a href="../index.php">
        						Home
        					</a>
        				</li>
        				<li>
        					<a href="../admin.php">
        						Admin
        					</a>
        				</li>
        			</ul>
    			</div>
 		 	</div>
		</nav>
		<br><br><br>
		<div class="container">
			<br>
			<br>
			<div class="block" >
				<img <?php echo 'src='.$_GET['name']; ?> /><br>
				<span style="font-size: 18pt; text-align: center;">
					Author: <?php 
							echo $author;
							?>
					<br>
					Picture Size: <?php  list($width, $height) = getimagesize($_GET['name']); echo $width.'x'.$height; ?>
					<br>
					File size: <?php echo Size( $_GET['name'] ); ?>
					<br>
					File extension: <?php echo Extension( $_GET['name'] ); ?>
					<br>
					Upload date: <?php echo $date; ?>
					<br>
					<a href=<?php echo $_GET['name']; ?> download>Download file (click this text)</a>
					<br>
					<?php 
						if (isset($_GET['redirect'])) {
							if(isset($_POST['pass'])) {
								echo '
								<form method="post" action="../admin2.php" class="form-horizontal" role="form">
									<div class="form-group">
										<label for="submit">
											Ready? Let\'s go back and do some moderation!
										</label>
										<input type="submit" value="Click here to go back!" class="btn btn-primary">
										<input type="hidden" name="username" value="'.$_POST['username'].'">
										<input type="hidden" name="password" value="'.$_POST['pass'].'">
									</div>
								</form>
								';
							} elseif(isset($_POST['username'])) {
								echo '
								<form method="post" action="../admin2.php" class="form-horizontal" role="form">
									<div class="form-group">
										<label for="submit">
											Ready? Let\'s go back and do some moderation!
										</label>
										<input type="submit" value="'.$_POST['username'].'" class="btn btn-primary">
										<input type="hidden" name="username" value="'.$_POST['username'].'">
									</div>
								</form>
								';
						} else {
								if ($_GET['redirect'] == "admin2.php") {
									$_GET['redirect'] = "index.php";
								}
								echo '<a href="../'.$_GET['redirect'].'">Go back!</a>';
							}
						}

					?>
				</span>
				<br>
				<br>
				<br>
				<br>
		</div>
	</body>
</html>
