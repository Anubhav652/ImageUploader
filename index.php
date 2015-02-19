<!DOCTYPE HTML>
<html>
	<head>
		<title>Homepage - Images</title>
		<link rel="stylesheet" type="text/css" href="design/style.css">	
	</head>
	<body oncontextmenu="return false;">
		<h1 class="title">Anubhav's Image Uploader</h1><br><br><br>
		<form action="upload.php" method="post" enctype="multipart/form-data">
    		Select image to upload:
    		<input type="file" name="fileToUpload" id="fileToUpload">
   	 		<input type="submit" value="Upload Image" name="submit">
		</form>
		<div class="block" >
			Images
			<?php
				echo "<br>";
				$target = 'uploads/';
				$weeds = array('.', '..', 'view.php');
				$uploads = 0;
				$directories = array_diff(scandir($target), $weeds);   
				foreach($directories as $value) {
   					if ( $uploads == 4 ) {
   						echo '<br>';
   						$uploads = 0;
   					}
      				$uploads = $uploads+1;

      				echo '<a href="uploads/view.php?name='.$value.'"> <img src="uploads/'.$value.'" width="50" height="50" /> </a>';
				}		 
			?>
		</div>
	</body>
</html>
