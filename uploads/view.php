<!DOCTYPE HTML>
<?php
include( 'images_sqlite.php' );
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
function Extension($patch) {

	$path = pathinfo( $patch );
	return $path[ 'extension' ];
}
	$author = "";
	if( isset( $_GET['name'] ) ) {
		if (file_exists($_GET['name'])) {
			$tlala = getImageDetails( $_GET['name'] );
			if (isset($tlala[2])) {
				$author = $tlala[3];
				$date = $tlala[1];
				$nam2e = $tlala[4];
			} else {
				$date = "Unknown";
				$author = "Not found";
			}
		} else {
			echo "<script>document.location = '../index.php'</script>";
			return;
		}
	} elseif ( isset( $_GET['action'] ) ) {
		$action = $_GET['action'];
		if ($action == "authorDelete" && isset($_GET['image'])) {
			$image = $_GET['image'];
			$details = getImageDetails( $image );
			if (isset($details[1])) {
				if (isset($_COOKIE['LoggedIn'])) {
					$LoginName = $_COOKIE['LoggedIn'];
					$author = $details[3];
					if ($LoginName == $author) {
                        $date = date("d/m/Y l");
                        insertLog( $author, ' - '.$date.': You have deleted your own image which was named '.$details[4].'.' );
						removeImageFromName( $image );
						unlink($image);
						echo "<script>document.location = '../index.php'</script>";
					} else {
						echo "<script>document.location = '../index.php'</script>";
					}
				} else {
					echo "<script>document.location = '../index.php'</script>";
				}
			} else {
				echo "<script>document.location = '../index.php'</script>";
			}
		} else {
			echo "<script>document.location = '../index.php'</script>";
		}
	} else {
		if (isset($_POST['image_name'])) {
			if (file_exists($_POST['image_name'])) {
				$_GET['name'] = $_POST['image_name'];
				if ($_POST['commentText'] == "") {

				} else {
					insertComment( $_GET['name'], $_POST['commentAuthor'], $_POST['commentText'] );
				}
				$tlala = getImageDetails( $_POST['image_name'] );
				if (isset($tlala[2])) {
					$author = $tlala[3];
					$date = $tlala[1];
					$nam2e = $tlala[4];
				} else {
					$date = "Unknown";
					$author = "Not found";
				}
			} else {
				echo "<script>document.location = '../index.php'</script>";
				return;
			}
		} else {
			die( 'ERROR: Restricted place for you!' );
			return;
		}
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
  		<script src="../js/view.js"></script>
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
                        <?php
                            if (isset( $_COOKIE['LoggedIn'] ) ) {
                                echo '
                                    <li>
                                        <a href="../profile.php">
                                            Profile
                                        </a>
                                    </li>
                                ';
                                if (isAdmin(  $_COOKIE['LoggedIn'] ) == "True" ) {
                                    echo '
                                        <li>
                                            <a href="../admin2.php">
                                                Admin Panel
                                            </a>
                                        </li>
                                    ';
                                }
                                echo '
                                    <li>
                                        <a href="../logout.php">
                                            Logout
                                        </a>
                                    </li>';
                            } else {

                            echo '
        				        <li>
        					       <a href="../login.php">
        						    Login
        					    </a>
        				        </li>
                                <li>
                                    <a href="../register.php">
                                        Register
                                    </a>
                                </li>
                            ';
                            }
                        ?>
                        <li class="active">
                        	<a href="">
                        		Viewing <?php echo $nam2e; ?>
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
				<img <?php echo 'src='.$_GET['name'] ?> /><br>
				<span style="font-size: 18pt; text-align: center;">
					Image name: <?php echo $nam2e; ?>
					<br>
					Author: <?php
							echo $author;
							?>
					<br>
					Picture Size: <?php  list($width, $height) = getimagesize($_GET['name']); echo $width.'x'.$height; ?>
					<br>
					File size: <?php echo Size( $_GET['name'] ); ?>
					<br>
					File extension: <?php echo Extension( $_GET['name'] ); ?>
					<br>
					Upload date: <?php echo $date; ?>
					<br>
					<a href=<?php echo $_GET['name']; ?> download>Download file (click this text)</a>
					<br>
					Comments:
					<br>
					<br>
					<?php
						$tlala = getImageDetails( $_GET['name'] );
						$comments = array();
						if (isset($tlala[1])) {
							$len = sizeof($tlala);
							for ($i=0; $i < $len; $i++) {
								if (gettype($tlala[$i]) == "array") {
									$comments[ ] = $tlala[$i];
								}
							}
						}
						if (empty($comments)) {
							echo '<b style="color: red;">No comments were uploaded</b><br><Br>';
						} else{
							for ($i=0; $i < sizeof($comments); $i++ ) {
								echo '
									<blockquote style="text-align: left;">
										<p>
											'.$comments[$i][0].'
										</p>
										<footer>
										Author:
											'.$comments[$i][1].'
										</footer>
									</blockquote>
								';
							}
						}
						if (isset($_COOKIE['LoggedIn'])) {
						$username = $_COOKIE['LoggedIn'];
						if ($username == $author) {
							echo '<button class="btn btn-danger deleteImage" id="'.$_GET['name'].'">Delete this image as you are the owner of it!</button>';
						}
						echo '
							<form action="view.php" method="POST" class="form-horizontal" role="form">
								<div class="form-group">
									<label for="text">
										Comment author:
									</label>
									<input type="text" name="commentAuthor" value="'.$_COOKIE['LoggedIn'].'" readonly>
									<br>
									<br>
									<textarea class="form-control" rows="5" name="commentText" id="comment">

									</textarea>
									<label for="submit">
										Click submit to post your comment!
									</label>
									<br>
									<input type="submit" class="btn btn-primary">
									<input type="hidden" value="'.$_GET['name'].'" name="image_name">
								</div>
							</form>
						';
						} else {
							echo '<b style="color: red">Comment form is disabled for you until you login. If you don\'t have a account, please register and log in to comment on this picture! Thank you for registering or logging in!</b>';
						}
						echo '<br><br><br>';
						if (isset($_GET['redirect'])) {
						if (!isset($_COOKIE['LoggedIn'])) {
							if ($_GET['redirect'] == "admin2.php") {
								$_GET['redirect'] = "index.php";
							}
							echo '
							<form action="'.$_GET['redirect'].'" method="get">
    							<input type="submit" value="Go back" name="Submit" id="frm1_submit" />
							</form>';
						}
					 	elseif(isset($_COOKIE['LoggedIn'])) {
					 		if (isAdmin($_COOKIE['LoggedIn']) && $_GET['redirect'] == "admin2.php") {
								echo '
								<form method="post" action="../admin2.php" class="form-horizontal" role="form">
									<div class="form-group">
										<label for="submit">
											Ready? Let\'s go back and do some moderation!
										</label>
									</div>
								</form>
								';
							} else {
								if ($_GET['redirect'] == "admin2.php") {
									$_GET['redirect'] = "index.php";
								}
								echo '
									<form action="../'.$_GET['redirect'].'">
    									<input type="submit" value="Go back" />
									</form>';
								}
							}
						}

					?>
				</span>
				<br>
				<br>
				<br>
				<br>
		</div>
	</body>
</html>
