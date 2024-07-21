<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one you want to allow
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$target_dir = "C:/xampp/htdocs/kynan/assets/img/produk/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is an actual image or fake image
if (isset($_FILES["file"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo json_encode(['success' => false, 'message' => 'File is not an image.']);
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo json_encode(['success' => false, 'message' => 'Sorry, file already exists.']);
    $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 500000) {
    echo json_encode(['success' => false, 'message' => 'Sorry, your file is too large.']);
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo json_encode(['success' => false, 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo json_encode(['success' => false, 'message' => 'Sorry, your file was not uploaded.']);
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo json_encode(['success' => true, 'message' => 'The file ' . basename($_FILES["file"]["name"]) . ' has been uploaded.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Sorry, there was an error uploading your file.']);
    }
}
