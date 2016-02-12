<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "images";
// DO not change below this AT ALL
$columns = "image_name,restricted,author,date,original_image_name";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
$conn->query("CREATE TABLE IF NOT EXISTS comments( image_name TEXT, Comment TEXT, CommentAuthor TEXT )");
$conn->query("CREATE TABLE IF NOT EXISTS login( hashedUsername TEXT, hashedPassword TEXT, isAdmin INT )");
$conn->query("CREATE TABLE IF NOT EXISTS logs( username TEXT, Log TEXT )");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function insertLog( $username, $log ) {
	global $conn;
    $log = "LOG NOTE: ".$log;
	$query = "INSERT INTO logs(username, Log) VALUES( '".$username."', '".$log."' )";
    if ($conn->query($query)) {
        return "True";
    } else {
        return "False";
    }
}

function getLogs( $username ) {
    global $conn;
    $query = "SELECT * FROM logs WHERE username = '".$username."'";
    $con = $conn->query($query);
    if ($con->num_rows > 0) {
        $array = array( );
        while ($row = $con->fetch_assoc()) {
            $array[ ] = $row['Log'];
        }
        return $array;
    } else {
        return "Error";
    }
}

function doesAccountExist( $username ) {
	global $conn;
	if ($username !== "") {
		$query = "SELECT hashedUsername FROM login WHERE hashedUsername='".$username."'";
		$con = $conn->query($query);
		if ($con->num_rows == 0 ) {
			return "No";
		} else {
			return "Yes";
		}
	}
}

function getAllUsername( ) {
	global $conn;
	$query = "SELECT * FROM login";
	$con = $conn->query($query);
	$usernameList = array();
	while ($row = $con->fetch_assoc()) {
		$usernameList[ ] = $row['hashedUsername'];
	}
	return $usernameList;
}

function isAdmin( $username ) {
	global $conn;
	if ($username !== "") {
		$query = "SELECT isAdmin FROM login WHERE hashedUsername='".$username."'";
		$con = $conn->query($query);
		if ($con->num_rows == 0) {
			return "No such row";
		} else {
			$assoc = $con->fetch_assoc();
			$val = $assoc['isAdmin'];
			if ($val == 1) {
				return "True";
			}
		}
	}
}

function accountExist( $username, $password ) {
	global $conn;
	if ($username !== "" && $password !== "") {
		$query = "SELECT hashedPassword FROM login WHERE hashedUsername='".$username."'";
		$con = $conn->query($query);
		if ($con->num_rows == 0 ) {
			return "Error: No such username exists";
		} else {
			$fetch = $con->fetch_assoc();
			$pass = $fetch['hashedPassword'];
			if ($password == $pass) {
				return "Success! You have logged in, please wait, redirecting you to the homepage!";
			} else {
				return "Error: Wrong username/password";
			}
		}
	} else {
		return "Error: No username/password provided!";
	}
}

function registerAccount( $name, $password ) {
	global $conn;
	$username = $name;
	$pass = sha1( $password );
	// checking for username existing below
	$check = doesAccountExist( $username );
	if ($check == "No") {
		$conn->query( 'INSERT INTO login(hashedUsername, hashedPassword, isAdmin) VALUES( "'.$username.'", "'.$pass.'", "0" )' );
		return "Success! Account was created, now you can use it at the login page!";
	} else {
		return "Error: Username already exists. Please choose another username!";
	}
}

function insertImage( $name, $date, $restrict, $author, $name2 ) {
	global $columns;
	global $conn;
	$query = "INSERT INTO image(".$columns.") VALUES( '".$name."', '".$restrict."', '".$author."', '".$date."', '".$name2."' )";
	if ($conn->query($query) === TRUE) {
		return "TRUE";
	} else {
		echo 'QUERY fail.';
		return "FALSE";
	}
}

function insertComment( $image, $author_name, $comment) {
	global $conn;
	$query = "INSERT INTO comments(image_name,Comment,CommentAuthor) VALUES( '".$image."', '".$comment."', '".$author_name."')";
	if ($conn->query($query) === TRUE) {
		return "TRUE";
	} else {
		echo $conn->error;
		return "FALSE";
	}
}

function getImagesOfUsers( $u ) {
	global $conn;
	global $columns;

	if ( doesAccountExist($u) == "Yes" ) {
		$query = "SELECT image_name FROM image WHERE author='".$u."'";
		$q =  $conn->query($query);
		if ($q->num_rows > 0) {
			$a = array( );
			while( $row = $q->fetch_assoc() ) {
				$a[ ] = $row['image_name'];
			}
			return $a;
		} else {
			return "No images were uploaded by you.";
		}
	} else {
		return "No images were uploaded by you.";
	}
}

function getUserImageCount( $u ) {
	global $conn;
	global $columns;

	if ( doesAccountExist( $u ) == "Yes" ) {
		$query = "SELECT image_name FROM image WHERE author='".$u."'";
		$q =  $conn->query($query);
		if ($q->num_rows > 0) {
			return "$q->num_rows";
		} else {
			return "0";
		}
	} else {
		return "0";
	}
}

function getImageDetails( $name ) {
	global $columns;
	global $conn;
	$query = "SELECT * FROM image WHERE image_name='".$name."'";
	$q = $conn->query($query);
	$a = array();
	if ($q->num_rows > 0) {
		$result = $q->fetch_assoc();
		array_push($a, $result['image_name']);
		array_push($a, $result['date']);
		array_push($a, $result['restricted']);
		array_push($a, $result['author']);
		array_push($a, $result['original_image_name']);
	} else {
		return "FALSE";
	}
	$query2 = "SELECT Comment,CommentAuthor FROM comments WHERE image_name='".$name."'";
	$q2 = $conn->query( $query2 );
	$comments = array( );
	if ($q2->num_rows > 0) {
		while ( $row =  $q2->fetch_assoc() ) {
			$a[ ] = array( $row[ 'Comment' ], $row['CommentAuthor'] );
		}
	}
	return $a;
}


function removeImageFromName( $name ) {
	global $conn;
	$query = "DELETE FROM image WHERE image_name='".$name."'";
	$query2 = "DELETE FROM comments WHERE image_name='".$name."'";
	if ($conn->query($query) === TRUE) {
		if ($conn->query($query2) === TRUE) {
			return "Done";
		}
	} else {
		return "Not done!";
	}
}

function updateColumnOfImageByName( $image_name, $column_name, $value ) {
	global $conn;
	$query = "UPDATE image SET ".$column_name."='".$value."' WHERE image_name='".$image_name."'";
	if ($conn->query($query) === TRUE) {
		return "Successfull";
	} else {
		return $conn->error;
	}
}
?>
