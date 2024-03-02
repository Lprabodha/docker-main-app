<?php

define('ROOT', realpath(__DIR__ . '/..') . '/');
require_once ROOT . 'config.php';


header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-PINGOTHER, Content-Type');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, GET, POST,OPTIONS");
header("Access-Control-Allow-Headers: Special-Request-Header");

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

$sql = "SELECT q.data, q.settings, q.uId, q.qr_code_id, q.type, q.status, u.plan_expiration_date  FROM qr_codes q JOIN users u ON q.user_id = u.user_id WHERE uId= '$uid'";
//  $sql = mysqli_query($conn,$query)or die(mysqli_error($conn));


$get_data_query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_num_rows($get_data_query) != 0) {
  $result = array();

  while ($r = mysqli_fetch_array($get_data_query)) {
    extract($r);
    $result[] = array("data" => $data, "settings" => $settings, "uId" => $uId, "qr_code_id" => $qr_code_id, "type" => $type, "status" => $status);
  }

  $isPlanExpire = (new DateTime($plan_expiration_date) < new DateTime()) ? true : false;

  $json = array("status" => 1, "result" => $result, 'is_expire' => $isPlanExpire);
} else {
  $json = array("status" => 0, "error" => "Data not found!");
}
@mysqli_close($conn);
// Set Content-type to JSON
header('Content-type: application/json');
echo json_encode($json);


//      $rows = [];
//      while($row = $sql->fetch_row()) {
//          $rows[] = $row;
//          $myArray[] = (object) ['catagories' => $result];
//      }


// foreach($rows as $result) {
//     $myArray[] = (object) ['catagories' => $result];
//     // $set['result'] = $data;

// }
die();
