<?php
	$loadauthor = "false";
	$loadwebsite = null;
	include 'uploads/images_sqlite.php';
	function call_out( ) {
		return ;
	}
	if (isset($_COOKIE['LoggedIn'])) {
		if (isAdmin($_COOKIE['LoggedIn'])) {
			$loadwebsite = true;
		}
	}

	if ($loadwebsite == true) {
		if (isset( $_GET['action'] ) ) {
			$action = $_GET['action'];
			$targetfile = $_GET['target'];
			if ($action == 'delete') {
				if (file_exists('uploads/'.$targetfile)) {
					$fileDetails = getImageDetails( $targetfile );
					if (isset($fileDetails[3])) {
						$date = date("d/m/Y l");
						insertLog( $fileDetails[3], ' - '.$date.': Your image has been deleted by '.$_COOKIE['LoggedIn'].' and it was named '.$targetfile.'.' );
					}
					insertLog( $_COOKIE['LoggedIn'], ' - ' .$date. ': You have deleted a image which was named '.$targetfile.'.' );
					chmod('uploads', 0666);
					unlink('uploads/'.$targetfile);
					removeImageFromName( $targetfile );

				}
			} elseif ($action == 'author') {
				$loadauthor = "true";
			} elseif ($action == "restrict") {
				$fileDetails = getImageDetails( $targetfile );
				if (isset($fileDetails[3])) {
					$date = date("d/m/Y l");
					insertLog( $fileDetails[3], ' - '.$date.': Your image has been restricted by '.$_COOKIE['LoggedIn'].' which is named '.$targetfile.'.' );
				}
				insertLog( $_COOKIE['LoggedIn'], ' - ' .$date. ': You have restricted a image which was named '.$targetfile.'.' );
				$yo = updateColumnOfImageByName( $targetfile, "restricted", "Yes" );
			} elseif ($action == "remover") {
				$fileDetails = getImageDetails( $targetfile );
				if (isset($fileDetails[3])) {
					$date = date("d/m/Y l");
					insertLog( $fileDetails[3], ' - '.$date.': Your image has removed from restricted status by '.$_COOKIE['LoggedIn'].' which iss named '.$targetfile.'.' );
				}
				insertLog( $_COOKIE['LoggedIn'], ' - ' .$date. ': You have removed restrictions from a image which was named '.$targetfile.'.' );
				$yo = updateColumnOfImageByName( $targetfile, "restricted", "No" );
			}
		}
	if (isset($_POST['data_author']) && isset($_POST['image'])) {
		$author = $_POST['data_author'];
		$author2 = $_POST['image'];
		$fileDetails = getImageDetails( $author2 );
		if (isset($fileDetails[3])) {
			$date = date("d/m/Y l");
			insertLog( $fileDetails[3], ' - '.$date.': You have been removed as a author of a image by '.$_COOKIE['LoggedIn'].' which is named '.$author2.'.' );
		}
		insertLog( $_COOKIE['LoggedIn'], ' - ' .$date. ': You have changed a author of the image which was named '.$author2.'.' );
		$yo = updateColumnOfImageByName( $author2, "author", $author );
	}
	function getInfo( $file ) {
		$imageDetails = getImageDetails( $file );
		$arra = array( $imageDetails[ 3 ], $imageDetails[2] );
		return $arra;
	}
?>
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
      					Anubhav's Image Uploader
      				</a>
    			</div>
    			<div>
      				<ul class="nav navbar-nav">
        				<li>
        					<a href="index.php">
        						Home
        					</a>
        				</li>
                        <?php
                            if (isset( $_COOKIE['LoggedIn'] ) ) {
                                echo '
                                    <li>
                                        <a href="profile.php">
                                            Profile
                                        </a>
                                    </li>';
                                if (isAdmin(  $_COOKIE['LoggedIn'] ) == "True" ) {
                                    echo '
                                        <li class="active">
                                            <a href="admin2.php">
                                                Admin Panel
                                            </a>
                                        </li>
                                    ';
                                }
                                echo '
                                    <li>
                                        <a href="logout.php">
                                            Logout
                                        </a>
                                    </li>
                                ';
                            } else {

                            echo '
        				        <li>
        					       <a href="login.php">
        						    Login
        					    </a>
        				        </li>
                                <li>
                                    <a href="register.php">
                                        Register
                                    </a>
                                </li>
                            ';
                            }
                        ?>
        			</ul>
    			</div>
 		 	</div>
		</nav>
		<br><br><br>
		<div class="container">
			<br>
			<br>
		<div class="block" >
			<span style="font-size: 18pt;">Images</span>
			<?php
				echo "<br>";
				$target = 'uploads/';
				$weeds = array('.', '..', 'view.php');
				$uploads = 0;
				$totaluploads = 0;
				echo '
					<span id="imagetoshow"></span>
					<div class="form-group">
  					<label for="sel1">Select list:</label>
  					<select class="form-control" id="sel1">';
                $images = glob($target . "*.jpg");
                $images2 = glob($target . "*.png");
                $images3 = glob($target . "*.jpeg");
                $allimages = array();
                $gap = 0;

                if (!empty($images)) {
                    foreach($images as $image) {
                         array_push($allimages, $image);
                    }
                }
                if (!empty($images2)) {
                    foreach($images2 as $image) {
                        array_push($allimages, $image);
                    }
                }
                    if (!empty($images3)) {
                        foreach($images3 as $image) {
                            array_push($allimages, $image);
                        }
                    }

                    if (!empty($allimages)) {
                        foreach($allimages as $image) {
                        	$image = str_replace("uploads/", "", $image);
                            $details = getInfo($image);
                            $totaluploads++;
                            $author = $details[0];
                            $restricted = $details[1];
                            echo '<option class="" value="'.$image.'">Author: '.$author.' |  Image name: '.$image.' | Restricted: '.$restricted.'</option>';
						}
					}

					echo '</select>';
					echo '</div>';
					if( $totaluploads == 0 ) {
						echo '<span style="color: red; font-size: 12pt;"> No images were uploaded. (buttons are disabled now) </span>';
						echo '<script>
							var yolo = document.getElementById( "sel1" );
							yolo.setAttribute( "class", "no-images form-control" );
						</script>';
					} else {
						echo '<br>';
						echo '<button class="btn btn-default delete">Delete</button>';
						echo '<button class="btn btn-default author">Change author name</button>';
						echo '<button class="btn btn-default imaged">View image details</button>';
						echo '<button class="btn btn-default restrict">Restrict image to admins</button>';
					}
			}
			if ($loadauthor == "true") {

				echo '
				<br>
				<br>
				<form action="admin2.php" method="POST" role="form">
					<div class="form-group">
						<label for="sel2">
				 			Select a author:
						</label>
  						<select class="form-control" id="sel2" name="data_author">
				';

				$usernames = getAllUsername();

				for ($i=0; $i < count($usernames); $i++ ) {
					echo '<option>'.$usernames[$i].'</options>';
				}

				echo '
  						</select>
  						<br>
  						<input type="submit" value="Change author" class="btn btn-primary">
  						<input type="hidden" name="image" value="'.$_GET['target'].'">
					</div>
				</form>';
             }
