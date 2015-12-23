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
            function dangerCheck( points, text ) {
                if( points == 0 ) {
                    text.setAttribute( 'class', 'text-danger' );
                }
            }
            function goodCheck( points, text ) {
                if ( points == 100 ) {
                    text.setAttribute( 'class', 'texxt text-success' );
                    text.innerHTML = "<br><br>" + text.innerHTML + "<br><br>"
                }
            }
            function proUpdate( progress ) {
                var pro = document.getElementById( "proshow" );
                var cl = "text text-danger"
                if (progress <= 25) {
                    cl = "text text-danger"
                } else if (progress <= 50) {
                    cl = "text text-warning"
                } else if (progress <= 75) { 
                    cl = "text text-primary"
                } else if (progress <= 100) {
                    cl = "text text-success"
                }
                pro.setAttribute( 'class', cl )
            }
            function progressandtext( p, t ) {
                var progressBar = document.getElementById( 'pro' );
                var text = document.getElementById( 'text' );
                progressBar.setAttribute( 'aria-valuenow', p );
                progressBar.setAttribute( 'style', 'width: ' + p + '%' );
                text.innerHTML = t;
                dangerCheck( p, text );
                goodCheck( p, text );
                proUpdate( p );
            }
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
                        <li>
                            <a href="admin.php">
                                Admin
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <br>
        <br>
        <div class="container">
            <b class="text-primary" id="text">Please wait, uploading the image!</b>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0"
                aria-valuemin="0" aria-valuemax="50" style="width:1%" id="pro"><b id="proshow" style="font-size: 12pt;">0%</b>
                <span class="sr-only"></span>   
            </div>
        </div>
            <?php
                $target_dir = "uploads/";
                $target_file = $target_dir .   basename($_FILES["fileToUpload"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $target_file_to_upload = $target_dir.hash( "md5", basename( $_FILES['fileToUpload']['name'])).'.'.$imageFileType;
                $uploadOk = 1;
                
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    echo '<script>progressandtext( 5, "Checking for file type" )</script>';
                    if($check !== false) {
                        echo '<script>progressandtext( 10, "File is a image - Continue" )</script>';;
                        $uploadOk = 1;
                    } else {
                        echo '<script>progressandtext( 0, "Sorry file upload was failed due to: ERROR CODE IMAGE - 001: File was not an image | Seeing this error even if file was an image? Contact the webmaster!" )</script>';;
                        return;
                    }
                }
                // Check for author name
                if($_POST['author']=="Your Name") {
                    $_POST['author'] = "Anon";
                } elseif($_POST['author']=="") {
                    $_POST['author'] = "Anon";
                }
                // Check if file already exists
                echo '<script>progressandtext( 15, "Checking for file existence" )</script>';
                if (file_exists($target_file)) {
                    echo '<script>progressandtext( 0, "Sorry file upload was failed due to: ERROR CODE IMAGE - 002: Target already exists | Resolve this issue by renaming your file | Seeing this error even if file was an image? Contact the webmaster! " )</script>';;
                    return;
                } else {
                    echo '<script>progressandtext( 10, "A file with this file name doesn\'t exist - Continue" )</script>';
                }
                echo '<script>progressandtext( 25, "Checking for file size - Max FILE SIZE is 5MB" )</script>';
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 5000000) {
                    echo "<script>progressandtext( 0, 'Sorry file upload was failed due to: ERROR CODE IMAGE - 003: File size was more than 5MB!' )</script>";;
                    return;
                } else {
                    echo '<script>progressandtext( 20, "File size is less than 5 MB - Continue" )</script>';
                }
                // Allow certain file formats
                echo '<script>progressandtext( 40, "Checking for file extensions - Only JPG, JPEG and PNG files are allowed!" )</script>';
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                    echo $imageFileType;
                    echo "<script>progressandtext( 0, 'Sorry file upload was failed due to: ERROR CODE IMAGE - 004: EXTENSION_ERROR: Wrong extension, allowed ones are PNG, JPG and JPEG. You may request to allow more extensions! EXTENSION_FOUND: ".$imageFileType."')</script>";;
                    return;
                }
                if ($uploadOk == 1) {
                    echo '<script>progressandtext( 55, "Checking for file size - Max FILE SIZE is 5MB" )</script>';
                }
                // Check if $uploadOk is set to 0 by an error
                echo '<script>progressandtext( 60, "Preparing to upload the file!" )</script>';
                if ($uploadOk == 0) {
                    echo "<script>progressandtext( 0, 'Sorry file upload was failed due to: ERROR CODE IMAGE - UNKNOWN: File was not uploaded due to an unknown reason!' )</script>";
                    // if everything is ok, try to upload file
                } 
                else {
                    echo '<script>progressandtext( 70, "File is ready to be uploaded - Uploading" )</script>';
                    echo '<script>progressandtext( 80, "File is now uploading" )</script>'; 
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_to_upload)) {
                        $handle = fopen("uploads/".hash( "md5", basename( $_FILES["fileToUpload"]["name"]) ).'.'.$imageFileType.'.info', "w+");
                        $format = $_POST['author'].',No,'.date("d/m/Y l");
                        fwrite( $handle, $format);
                        echo "<script>progressandtext( 100, 'You have uploaded ".basename( $_FILES["fileToUpload"]["name"])." file!' )</script>";
                        echo '<button class="btn btn-success" onclick="location.href = \'uploads/view.php?name='.hash( "md5", basename( $_FILES["fileToUpload"]["name"]) ).'.'.$imageFileType.'&redirect=index.php\'">View file!</button>';
                    }
                    else {
                        echo "<script>progressandtext( 0, 'Sorry file upload was failed due to: ERROR CODE IMAGE - UNKNOWN: File was not uploaded due to an unknown reason!' )</script>";
                    }
                }
            ?>
        </div> 
    </body>
</html>
