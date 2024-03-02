<?php

define('ROOT', realpath(__DIR__ . '/..') . '/');
require_once ROOT . 'config.php';


header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');


// Create connection
$conn = mysqli_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


//include("../config.php");
$data = array();
$jsonObj = array();
$uid = $_GET['uid'];


// echo $_GET['qr_code_id'];

$qr_code_id = mysqli_real_escape_string($conn, intval($_REQUEST['qr_code_id']));
$country_code = mysqli_real_escape_string($conn, $_REQUEST['country_code']);
$os_name = mysqli_real_escape_string($conn, $_REQUEST['os_name']);
$city_name = mysqli_real_escape_string($conn, $_REQUEST['city_name']);
$country_name = mysqli_real_escape_string($conn, $_REQUEST['country_name']);
$browser_name = mysqli_real_escape_string($conn, $_REQUEST['browser_name']);
$referrer_host = mysqli_real_escape_string($conn, $_REQUEST['referrer_host']);
$referrer_path = mysqli_real_escape_string($conn, $_REQUEST['referrer_path']);
$device_type = mysqli_real_escape_string($conn, $_REQUEST['device_type']);
$browser_language = mysqli_real_escape_string($conn, $_REQUEST['browser_language']);
$utm_source = mysqli_real_escape_string($conn, $_REQUEST['utm_source']);
$utm_medium = mysqli_real_escape_string($conn, $_REQUEST['utm_medium']);
$utm_campaign = mysqli_real_escape_string($conn, $_REQUEST['utm_campaign']);
$ip_address = mysqli_real_escape_string($conn, $_REQUEST['ip_address']);
$datetime = date('Y-m-d H:i:s');
$created_at = date('Y-m-d H:i:s');
$updated_at = date('Y-m-d H:i:s');

/** Check */
$uniqueUser = "SELECT COUNT(*) FROM qrscan_statistics WHERE qr_code_id = '{$qr_code_id}' AND os_name = '{$os_name}' AND ip_address = '{$ip_address}' AND browser_name = '{$browser_name}'";

$is_unique = 1;

$queryResource = mysqli_query($conn, $uniqueUser) or die(mysqli_error($conn));
// echo mysqli_num_rows($queryResource);
$row = mysqli_fetch_array($queryResource);

$total = $row[0];
if ($total > 0) {
    $is_unique = 0;
} else {
    $is_unique = 1;
}


$sql = "INSERT INTO qrscan_statistics (qr_code_id, country_code, os_name,city_name,country_name,browser_name,
        referrer_host,referrer_path,device_type,browser_language,utm_source,utm_medium,utm_campaign,is_unique,
        ip_address,datetime,created_at,updated_at)
        VALUES ('$qr_code_id', '$country_code', '$os_name','$city_name','$country_name','$browser_name',
        '$referrer_host','$referrer_path','$device_type','$browser_language','$utm_source','$utm_medium','$utm_campaign','$is_unique',
        '$ip_address','$datetime','$created_at','$updated_at')";



$add_data_query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$json = array("status" => true, "result" => "Data added");
@mysqli_close($conn);
header('Content-type: application/json');

die();
