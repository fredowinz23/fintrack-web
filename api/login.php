<?php
include "../templates/api-header.php";

$json = array();
$success = false;
$response = "";
if (isset($_POST["username"])) {
  $username = $_POST["username"];
  $password = md5($_POST["password"]);
  $checkUserExist = user()->count("username='$username' and password='$password'");
  if ($checkUserExist > 0) {
    $user = user()->get("username='$username'");
    $success = true;
    $response = array();
    $response["id"] = $user->Id;
    $response["username"] = $user->username;
    $response["first_name"] = $user->firstName;
    $response["last_name"] = $user->lastName;
    $json["profile"] = $response;
  }
}

$json["username"] = $_POST["username"];
$json["password"] = $_POST["password"];
$json["success"] = $success;


header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);
?>
