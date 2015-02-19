<!DOCTYPE HTML>
<html>
	<head>
		<title>Homepage - Images</title>
		<link rel="stylesheet" type="text/css" href="design/style.css">	
	</head>
	<body oncontextmenu="return false;">
		<h1 class="title">Anubhav's Image Uploader</h1><br><br><br>
		<form action="upload.php" method="post" enctype="multipart/form-data">
    		<span style="font-size: 14pt;">Select image to upload:</span>
    		<input type="file" name="fileToUpload" id="fileToUpload">
   	 		<input type="edit" name="author" id="name" value="Your Name">
   	 		<input type="submit" value="Upload Image" name="submit">
		</form>
		<h1 style="font-size: 18pt;">Are you admin? <a href="admin.php"> Click here.</a></h1>
		<div class="block" >
			<span style="font-size: 18pt;">Images</span>
			<?php
				echo "<br>";
				$target = 'uploads/';
				$weeds = array('.', '..', 'view.php');
				$uploads = 0;
				$totaluploads = 0;
				$directories = array_diff(scandir($target), $weeds);   
				foreach($directories as $value) {
   					if ( strpos( $value, ".info" ) == false ) {

	   					if ( $uploads == 4 ) {
   							echo '<br>';
   							$uploads = 0;
   						}
      					$uploads = $uploads+1;
      					$totaluploads = $totaluploads+1;
      					echo '<a href="uploads/view.php?name='.$value.'"> <img src="uploads/'.$value.'" width="50" height="50" /> </a>';
					}		 
				}
				if( $totaluploads == 0 ) {
					echo '<span style="color: red; font-size: 12pt;"> No images were uploaded. </span>';
				}
			?>
		</div>
	</body>
</html>
