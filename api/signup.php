<?php
include "../templates/api-header.php";
include "interface.php";

$json = array();
$success = false;
$profile = null;
$error = "";
$response = "";
if (isset($_POST["username"])) {
  $username = $_POST["username"];
  $checkUserExist = user()->count("username='$username'");
  if ($checkUserExist > 0) {
    $error = 'usernameAlreadyExists';
  }
  else{
    $model = user();
    $model->obj["username"] = $_POST["username"];
    $model->obj["firstName"] = $_POST["firstName"];
    $model->obj["lastName"] = $_POST["lastName"];
    $model->obj["phone"] = $_POST["phone"];
    $model->obj["password"] = $_POST["password"];
    $model->obj["dateAdded"] = "NOW()";
    $model->create();

    $success = true;

    $json["username"] = $_POST["username"];
    $json["firstName"] = $_POST["firstName"];
    $json["lastName"] = $_POST["lastName"];
    $json["phone"] = $_POST["phone"];
    $json["password"] = $_POST["password"];
  }
}

$json["success"] = $success;
$json["error"] = $error;


header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);
?>
