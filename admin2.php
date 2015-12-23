<?php
	$loadwebsite = null;
	include 'acheck.php';
	function call_out( ) {
		return ;
	}
	if (isset( $_POST['password'] ) ) {
		$check = checkLogin( $_POST['username'], $_POST['password'] );
		if ($check === true) {
		 	$loadwebsite = true;
		} else {
			echo '<script>document.location = "admin.php?error"</script>';
		}
	} elseif (isset( $_POST['username'] ) ) {
		$check = checkLogin( $_POST['username'] );
		if ($check === true) {
		 	$loadwebsite = true;
		} else {
			echo '<script>document.location = "admin.php?error"</script>';
		}
	}
	
	if ($loadwebsite == true) {
		if (isset( $_GET['action'] ) ) {
			$action = $_GET['action'];
			$targetfile = $_GET['target'];
			if ($action == 'delete') {
				if (file_exists('uploads/'.$targetfile)) {
					chmod('uploads', 0666);
					unlink('uploads/'.$targetfile);
					unlink('uploads/'.$targetfile.'.info');
				}
			} elseif ($action == 'author') {
				$targetfile = fopen( 'uploads/'.$_GET['target'].'.info', "w" );
				$newauth = $_GET['authorname'];
				fwrite($targetfile, $newauth);
				fclose( $targetfile );
			} elseif ($action == "restrict") {
				$targetfile = fopen( 'uploads/'.$_GET['target'].'.info', "w" );
				$targetread = readfile( 'uploads/'.$_GET['target'].'.info' );
				fwrite($targetfile, $targetread.',Yes');
				fclose( $targetfile );				
			} elseif ($action == "remover") {
				$targetfile = fopen( 'uploads/'.$_GET['target'].'.info', "w" );
				$targetread = readfile( 'uploads/'.$_GET['target'].'.info' );
				$expo2 = explode(",", $targetread);
				fwrite($targetfile, $expo2[0]);
				fclose( $targetfile );
			}
		}
	function getInfo( $filePath ) {
		$open = fopen( $filePath, "r" );
		$read = fread( $open, filesize( $filePath ) );
		if ( strpos($read,',') === false ) {
			return explode( ",", $read.',No' );
		} else {
			$expo = explode( ",", $read );
			return $expo;
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
		<link rel="stylesheet" href="css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="js/bootstrap.min.js"></script>
  		<script>
  			function callOut() {
			var e = document.getElementById("sel1");
			var strUser = e.options[e.selectedIndex].text;
			return strUser;
			}			
  		</script>
  		<script src="js/images.js"></script>
	</head>
	<body oncontextmenu="return false;">
  		<nav class="navbar navbar-inverse">
  			<div class="container-fluid">
    			<div class="navbar-header">
      				<a class="navbar-brand" href="index.php">
      					Anubhav\'s Image Uploader
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
		<br><br><br>
		<div class="container">
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
				echo '
				<span id="imagetoshow"></span>
				<div class="form-group">
  					<label for="sel1">Select list:</label>
  					<select class="form-control" id="sel1">';
  					$v = $_POST['username'];
      				if (isset($_POST['password'])) {
      					$v = $v.",".$_POST['password'];
      				}
					foreach($directories as $value) {
   						if ( strpos( $value, ".info" ) == false ) {
   							if ($value == "view.php") {

   							} else {
	   							if ( $uploads == 2 ) {
   									echo '<br><br><br><br><br>';
   									$uploads = 0;
   								}
      							$uploads = $uploads+1;
      							$totaluploads = $totaluploads+1;
      							$ar = getInfo('uploads/'.$value.'.info' );
      							$author = $ar[0];
      							$restricted = $ar[1];
      							echo '<option class="" id="'.$v.'" value="'.$value.'">Author: '.$author.' |  Image name: '.$value.' | Restricted: '.$restricted.'</option>';
							}
						}		 
					}

					echo '</select>';
					echo '</div>';
					if( $totaluploads == 0 ) {
						echo '<span style="color: red; font-size: 12pt;"> No images were uploaded. </span>';
					}
					$some = call_out();
					echo '<br>';
					echo '<button id="'.$v.'" class="btn btn-default delete">Delete</button>';
					echo '<button id="'.$v.'" class="btn btn-default author">Change author name</button>';
					echo '<button id="'.$v.'" class="btn btn-default imaged">View image details</button>';
					echo '<button id="'.$v.'" class="btn btn-default restrict">Restrict image to admins</button>';
					

			}
		?>
