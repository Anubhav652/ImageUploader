<!DOCTYPE HTML>
<html>
    <head>
        <title>Homepage - Images</title>
        <link rel="stylesheet" type="text/css" href="design/style.css"> 
    </head>
    <body>
        <h1 class="title">Anubhav's Image Uploader</h1><br><br><br>
        <div class="block" style="height: 50vh;">
            You are at image uploading section.
            <a href="index.php" style="color: blue;">Return</a>
        </div>
        <div class="console">
            <?php
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    echo '<b>1</b> Checking file type.<br>';
                    if($check !== false) {
                        echo '<b>2</b> File is a <b>image</b>.<br>';
                        $uploadOk = 1;
                    } else {
                        echo "<b>2</b> <span style='color: red'>Error:</span><br>File is not an <b>image</b>.<br>";
                        $uploadOk = 0;
                    }
                }
                // Check if file already exists
                echo '<b>3</b> Checking for file exist<br>';
                if (file_exists($target_file)) {
                    echo "<b>4</b> <span style='color: red'>Error:</span> Sorry, file already exists.<br>";
                    $uploadOk = 0;
                } else {
                    echo '<b>4</b> File doesn\'t exist, continuing process.<br>';
                }
                echo '<b>5</b> Checking file size.<br>';
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 5000000) {
                    echo "<b>6</b> <span style='color: red'>Error:</span> Sorry, your file is larger than 5 MB.<br>";
                    $uploadOk = 0;
                } else {
                    echo '<b>6</b> File is less than 5 MB. Continuing process!<br>';
                }
                // Allow certain file formats
                echo '<b>7</b> Checking the file format.<br>';
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                    echo "<b>8</b> <span style='color: red'>Error:</span> Sorry, only JPG, JPEG and PNG files are allowed.<br>";
                    $uploadOk = 0;
                }
                if ($uploadOK == 1) {
                    echo '<b>8</b> File format is valid. <br>';
                }
                // Check if $uploadOk is set to 0 by an error
                echo '<b>9</b> Checking if file can upload. <br>';
                if ($uploadOk == 0) {
                    echo "<b>10</b> <span style='color: red'>Error:</span> Sorry, your file was not uploaded.<br>";
                    // if everything is ok, try to upload file
                } 
                else {
                    echo '<b>10</b> File has no problems.<br>';
                    echo '<b>11</b> Starting upload process <br>'; 
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "<b>12</b> The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
                    } 
                    else {
                        echo "<b>12</b> <span style='color: red'>Error:</span> Sorry, there was an error uploading your file.<br>";
                        echo 'Some debug info: ';
                        print_r($_FILES);
                    }
                }
            ?>
        </div> 
    </body>
</html>
