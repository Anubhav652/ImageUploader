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
	$author = "";
	if( isset( $_GET['name'] ) ) {
		if (file_exists($_GET['name'].'.info')) {
			$file = fopen( $_GET['name'].'.info', "r" );
			$r = fread( $file, filesize( $_GET['name'].'.info' ) );
			$author = $r;
			fclose( $file );
		} else {
			die( );
			return;
		}
	} else {
		die( );
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
				<span style="font-size: 18pt; text-align: center;">
					Author: <?php 
							echo $author;
							?>
					<br>
					Picture Size: <?php  list($width, $height) = getimagesize($_GET['name']); echo $width.'x'.$height; ?>
					<br>
					File size: <?php echo Size( $_GET['name'] ); ?>
					<br>
					<a href=<?php echo $_GET['name']; ?> download>Download file (click this text)</a>
				</span>
				<br>
				<br>
				<img <?php echo 'src='.$_GET['name']; ?> />
				<br>
				<br>
		</div>
	</body>
</html>
