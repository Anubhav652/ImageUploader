<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Homepage - Images
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
        				<li class="active">
        					<a href="index.php">
        						Home
        					</a>
        				</li>
        				<li>
        					<a href="admin.php">
        						Admin
        					</a>
        				</li>
        			</ul>
    			</div>
 		 	</div>
		</nav>
		<br><br><br>
		<div class="container">
              <span style="font-size: 14pt;">
            Select image to upload:
          </span>
			<form action="upload.php" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
    			<div class='form-group'>
    			 	<label for="file">
    			 		File to upload
    			 	</label>
    			 	<br>
    				<input type="file" name="fileToUpload" id="fileToUpload">
    			</div>
    			<div class='form-group'>
    				<label for="edit">
    					Type your name:
    				</label>
   	 				<input type="edit" name="author" id="name" value="Your Name">
   	 			</div>
   	 			<div class="form-group">
   	 				<label for="submit">
   	 					Click to upload
   	 				</label>
   	 				<input type="submit" value="Upload Image" name="submit" class="btn btn-default">
				</div>
			</form>
			<br>
			<br>
			<div class="block" >
				<span style="font-size: 18pt; text-align: center;">
					Images
				</span>
				<br>
				<br>
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
      						echo '<a href="uploads/view.php?name='.$value.'"> <img class="img-thumbnail" src="uploads/'.$value.'" width="50" height="50" /> </a>';
						}		 
					}
					if( $totaluploads == 0 ) {
						echo '<span style="color: red; font-size: 12pt;"> No images were uploaded. </span>';
					}
				?>
		</div>
	</body>
</html>
