<!DOCTYPE HTML>
<?php
	include 'uploads/images_sqlite.php';

	if (!isset($_COOKIE['LoggedIn'])) {
		echo '<script>location.href="index.php"</script>';
	}

	$Login = $_COOKIE['LoggedIn'];
	$Yes = "";
	$arrayToAns = "";
	$information = "";
	//
	$answer1 = $Login.",".getUserImageCount($Login);
	$Option1 = "Account Name,Image Upload Count";
	//
	//
	function arrayToAnswer( $option, $answer ) {
		$option = explode(",", $option);
		$answer = explode(",", $answer);
		$string = "";
		foreach ($option as $key => $opt) {
			$string = $string.",".$opt.":".$answer[$key];
		}
		return $string;
	}

	function outputLogs(  ) {
		$logs = getLogs( $_COOKIE['LoggedIn'] );
		if (gettype($logs) == "array") {
			echo '<ul class="list-group">';

			for ($i=0; $i < count($logs); $i++) {
				$logResult = $logs[$i];
				echo '<li style=\'background-color: orange; color: white;\' class=\'list-group-item\'>'.$logResult.'</li>';
				echo '<br>';
			}

			echo '</ul>';
		} else {
			echo "<span style='color: red;'>No log was found for this account</span>";
		}
	}

	function outputAnsweres( $string ) {
		$str = explode(",", $string);
		foreach ($str as $str2) {
			$str3 = explode( ":", $str2 );
			if (isset($str3[0]) && isset($str3[1])) {
				echo $str3[0].': '.$str3[1].'<br>';
			}
		}
	}
	$arrayToAns = "";
	if (isset($_POST['Images']) ) {
			$Yes = "2";
			$information = "Below it shows the images you have uploaded";
	} elseif (isset( $_POST['Account'] )) {
			$Yes = "1";
			$information = 'Below it shows the normal information of account';
			$arrayToAns = arrayToAnswer( $Option1, $answer1 );
	} elseif (isset( $_POST['Event'] )) {
			$Yes = "3";
			$information = "Below it event information (logs about what you have done)";
	} else {
		$Yes = "1";
		$information = "Below it shows the normal information of account";
		$arrayToAns = arrayToAnswer( $Option1, $answer1 );
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Profile page - Images
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
        				<li>
        					<a href="index.php">
        						Home
        					</a>
        				</li>
                        <?php
                            if (isset( $_COOKIE['LoggedIn'] ) ) {
                                echo '
                                    <li class="active">
                                        <a href="profile.php">
                                            Profile
                                        </a>
                                    </li>';
                                if (isAdmin(  $_COOKIE['LoggedIn'] ) == "True" ) {
                                    echo '
                                        <li>
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
		<div class="container">
			<br>
			<br>
			<br>
			<span style="font-size: 18pt;">
				Profile page
			</span>
			<br>
			<br>
			<form action="profile.php" method="POST">
				<ul class="nav nav-tabs">
					<?php
						if ($Yes == "1") {
  							echo '<li class="active">
  								<a href="">
  									<input type="submit" value="Account information" name="Account">
  								</a>
  							</li>
  							<li>
  								<a href="">
  									<input type="submit" value="My images" name="Images">
  								</a>
  							</li>
 							<li>
  								<a href="">
  									<input type="submit" value="Event log" name="Event">
  								</a>
  							</li>
  							';
  						} elseif($Yes == "2") {
  							echo '<li>
  								<a href="">
  									<input type="submit" value="Account information" name="Account">
  								</a>
  							</li>
  							<li class="active">
  								<a href="">
  									<input type="submit" value="My images" name="Images">
  								</a>
  							</li>
  							<li>
  								<a href="">
  									<input type="submit" value="Event log" name="Event">
  								</a>
  							</li>
  							';
  						} else {
  							echo '
  							<li>
  								<a href="">
  									<input type="submit" value="Account information" name="Account">
  								</a>
  							</li>
  							<li>
  								<a href="">
  									<input type="submit" value="My images" name="Images">
  								</a>
  							</li>
  							<li class="active">
  								<a href="">
  									<input type="submit" value="Event log" name="Event">
  								</a>
  							</li>
  							';
  						}
  					?>
				</ul>
			</form>
			<br>
			<br>
			<b class="label label-warning" style="font-size: 10pt;">
				<?php
					echo $information;
				?>
			</b>
			<br>
			<br>
			<br>
			<span style="font-size: 18pt;">
				<?php
					if ($Yes == '2') {
						$images = getImagesOfUsers( $Login );
						if (gettype($images) == "array") {
							foreach( $images as $imagename) {
								echo '<a href="uploads/view.php?name='.$imagename.'&redirect=profile.php"> <img class="img-thumbnail" src="uploads/'.$imagename.'" width="200" height="200" /> </a>';
							}
						} else {
							echo $images;
						}
					} elseif($Yes == '1') {
						echo outputAnsweres( $arrayToAns );
					} elseif($Yes == "3") {
						outputLogs();
					}
				?>
			</span>
		</div>
	</body>
</html>
