<?php
	$loadwebsite = null;
	if (isset( $_GET['pass'] ) ) {
		$v = $_GET['pass'];
		require( 'adminconf.php' );
		if (sha1( $securekey )==$v) {
			$loadwebsite = true;
		}
	}
	if ($loadwebsite == true) {
		if (isset( $_GET['action'] ) ) {
			$action = $_GET['action'];
			$targetfile = $_GET['target'];
			if ($action == 'delete') {
				unlink('uploads/'.$targetfile);
				unlink('uploads/'.$targetfile.'.info');
			} elseif ($action == 'author') {
				$targetfile = fopen( 'uploads/'.$_GET['target'].'.info', "w" );
				$newauth = $_GET['authorname'];
				fwrite($targetfile, $newauth);
				fclose( $targetfile );
			}
		}
	echo ' 
<!DOCTYPE HTML>
<html>
	<head>
		<title>Homepage - Images</title>
		<link rel="stylesheet" type="text/css" href="design/style.css">	
		<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="author.js"></script>
	</head>
	<body oncontextmenu="return false;">
		<h1 class="title">Anubhav\'s Image Uploader</h1><br><br><br>
		<form action="upload.php" method="post" enctype="multipart/form-data">
    		<span style="font-size: 14pt;">Select image to upload:</span>
    		<input type="file" name="fileToUpload" id="fileToUpload">
   	 		<input type="submit" value="Upload Image" name="submit">
		</form>
		<div class="block" >
			<span style="font-size: 18pt;">Images</span>';
						echo "<br>";
				$target = 'uploads/';
				$weeds = array('.', '..', 'view.php');
				$uploads = 0;
				$totaluploads = 0;
				$directories = array_diff(scandir($target), $weeds);   
				foreach($directories as $value) {
   					if ( strpos( $value, ".info" ) == false ) {

	   					if ( $uploads == 2 ) {
   							echo '<br><br><br><br><br>';
   							$uploads = 0;
   						}
      					$uploads = $uploads+1;
      					$totaluploads = $totaluploads+1;
      					$v = $_GET['pass'];
      					echo '<a href="uploads/view.php?name='.$value.'"> <img src="uploads/'.$value.'" width="50" height="50" /> </a>';
						echo '<br><b style="color: grey; text-decoration: none; font-size: 7pt;">Author name: '.file_get_contents('uploads/'.$value.'.info').'</b><br><a class="button" href="admin2.php?pass='.$v.'&action=delete&target='.$value.'" style="color: red; text-decoration: none; font-size: 10pt; height: 50px;">Delete</a>';
						echo '<br><button class="button" id="changeAuthor">Change author name</button>';
						echo '<br><button class="button" id="suspendImage">Suspend image</button>';
					}		 
				}
				if( $totaluploads == 0 ) {
					echo '<span style="color: red; font-size: 12pt;"> No images were uploaded. </span>';
				}
	}
?>
