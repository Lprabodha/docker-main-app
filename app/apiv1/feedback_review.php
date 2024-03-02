<?php
define('ROOT', realpath(__DIR__ . '/..') . '/');
require_once ROOT . 'config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST,OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// Create connection
$conn = mysqli_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$data = json_decode(file_get_contents("php://input"));

$qr_code     = mysqli_real_escape_string($conn, trim($data->qr_code_id));
$category    = mysqli_real_escape_string($conn, trim($data->category));
$comment     = mysqli_real_escape_string($conn, trim($data->comment));
$star        = mysqli_real_escape_string($conn, trim($data->star));
$email       = mysqli_real_escape_string($conn, trim($data->email));
$phone       = mysqli_real_escape_string($conn, trim($data->phone));



$sql = "INSERT INTO feedback_reviews(qr_code, category,comment, star, email, phone)  VALUES ('$qr_code',
'$category','$comment','$star','$email', '$phone')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "erorr" => mysqli_error($conn)]);
}

// Close connection
mysqli_close($conn);

die();
