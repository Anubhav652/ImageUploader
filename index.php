
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
        <script>
            var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
            };
        </script>
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
                        <?php
                            include( 'uploads/images_sqlite.php' );
                            if (isset( $_COOKIE['LoggedIn'] ) ) {
                                echo '
                                    <li>
                                        <a href="profile.php">
                                            Profile
                                        </a>
                                    </li>';
                                if (isAdmin( $_COOKIE['LoggedIn'] ) == "True" ) {
                                    echo '
                                        <li>
                                            <a href="admin2.php">
                                                Admin Panel
                                            </a>
                                        </li>
                                    ';
                                }
                                echo '<li>
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
              <span style="font-size: 14pt;">
            Select image to upload:
          </span>
			<form action="upload.php" class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
    			<div class='form-group'>
    			 	<label for="file">
    			 		File to upload
    			 	</label>
    			 	<br>
    				<input type="file" onchange="loadFile(event)" name="fileToUpload" id="fileToUpload" accept="image/*" class="btn btn-default btn-file">
                    <br>
                    <span style="color: blue; font-size: 18pt;">
                        Image Preview:
                    </span>
                    <br>
                    <img id="output" class="img-thumbnail" width="100" height="100" />
    			</div>
    			<div class='form-group'>
    				<label for="edit">
    					Type your name:
    				</label>
                    <?php
   	 				   if (isset($_COOKIE['LoggedIn'])) {
                            echo '<input type="edit" name="author" id="name" value="'.$_COOKIE['LoggedIn'].'" readonly> <b style="color: green;">This editbox is disabled as you have logged in. Your username is used as the name of the uploader.</b>';
                        } else {
                            echo '<input type="edit" name="author" id="name" value="Guest" readonly> <b style="color: blue">Please log in, if you don\'t our administration team will transfer the image, but it is not recommended.</b>';
                        }
   	 			    ?>
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
                            $imagetruename = str_replace( "uploads/", "",$image );
                            $details = getImageDetails($imagetruename);
                            if ($gap == 5) {
                                $gap = 0;
                                echo '<br>';
                            }
                            if ($details[2] == "No") {
                                $totaluploads++;
                                $gap++;
                                echo '<a href="uploads/view.php?name='.$imagetruename.'&redirect=index.php"> <img class="img-thumbnail" src="'.$image.'" width="200" height="200" /> </a>';
                            }
                        }
                    }   
					if( $totaluploads == 0 ) {
						echo '<span style="color: red; font-size: 12pt;"> No images were uploaded. </span>';
					}
				?>
		</div>
	</body>
</html>
