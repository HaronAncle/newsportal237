<?php
$target_dir = "/static/userlogo/";
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$uploadOk = 1;

if (file_exists($target_file)) {
    $filename = pathinfo($target_file, PATHINFO_FILENAME);
    $extension = pathinfo($target_file, PATHINFO_EXTENSION);
    $increment = '';
    while (file_exists($target_dir . $filename . $increment . '.' . $extension)) {
        $increment++;
    }
    $target_file = $target_dir . $filename . $increment . '.' . $extension;
}

// Check file size
if ($_FILES["foto"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["foto"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>