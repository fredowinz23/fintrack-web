<?php
include "../templates/api-header.php";
include "interface.php";

$json = array();
$success = true;


$username = $_POST["username"];
$user = user()->get("username='$username'");

$model = category();
$model->obj["name"] = $_POST["name"];
$model->obj["type"] = $_POST["type"];
$model->obj["createdById"] = $user->Id;
$model->create();


$json["username"] = $_POST["username"];
$json["name"] = $_POST["name"];
$json["type"] = $_POST["type"];
$json["success"] = $success;


header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);
?>
