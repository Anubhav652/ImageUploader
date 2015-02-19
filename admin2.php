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
			}
		}
	echo '
<!DOCTYPE HTML>
<html>
	<head>
		<title>Homepage - Images</title>
		<link rel="stylesheet" type="text/css" href="design/style.css">	
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

	   					if ( $uploads == 4 ) {
   							echo '<br><br>';
   							$uploads = 0;
   						}
      					$uploads = $uploads+1;
      					$totaluploads = $totaluploads+1;
      					echo '<a href="uploads/view.php?name='.$value.'"> <img src="uploads/'.$value.'" width="50" height="50" /> </a>';
						echo '<br><a href="admin2.php?pass='.$v.'&action=delete&target='.$value.'" style="color: red; text-decoration: none; font-size: 10pt;">Delete</a>';
					}		 
				}
				if( $totaluploads == 0 ) {
					echo '<span style="color: red; font-size: 12pt;"> No images were uploaded. </span>';
				}
	}
?>
