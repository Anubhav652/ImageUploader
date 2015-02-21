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
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Administrator Page - Images
		</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>
	<body oncontextmenu="return false;">
		  <div class="jumbotron">
    		<h1>
    			Anubhav\'s Image Uploader
    		</h1>
  		</div>
  		<nav class="navbar navbar-inverse">
  			<div class="container-fluid">
    			<div class="navbar-header">
      				<a class="navbar-brand" href="index.php">
      					Anubhav\'s Image Uploader
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
			<form action="upload.php" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
    			<span style="font-size: 14pt;">
    				Select image to upload:
    			</span>
    			<div class="form-group">
    			 	<label for="file">
    			 		File to upload
    			 	</label>
    			 	<br>
    				<input type="file" name="fileToUpload" id="fileToUpload">
    			</div>
    			<div class="form-group">
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
      					echo '<a href="uploads/view.php?name='.$value.'"> <img class="img-thumbnail" src="uploads/'.$value.'" width="50" height="50" /> </a>';
						echo '<br><b style="color: grey; text-decoration: none; font-size: 7pt;">Author name: '.file_get_contents('uploads/'.$value.'.info').'</b><br><a class="button" href="admin2.php?pass='.$v.'&action=delete&target='.$value.'" style="color: red; text-decoration: none; font-size: 10pt; height: 50px;">Delete</a>';
						echo '<br><button class="btn btn-default" id="changeAuthor">Change author name</button>';
						echo '<br><button class="btn btn-default" id="suspendImage">Suspend image</button>';
					}		 
				}
				if( $totaluploads == 0 ) {
					echo '<span style="color: red; font-size: 12pt;"> No images were uploaded. </span>';
				}
			}
		?>
