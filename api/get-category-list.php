<?php
include "../templates/api-header.php";
include "interface.php";

$json = array();
$success = false;
if (isset($_POST["type"])) {
  $type = $_POST["type"];
  $username = $_POST["username"];
  $user = user()->get("username='$username'");
  $success = true;

  $category_list = array();

  foreach (category()->list("type='$type' and (createdById=$user->Id or createdById=0)") as $row) {
    $item = category_interface($row);
    array_push($category_list, $item);
  }
}

$json["username"] = $_POST["username"];
$json["type"] = $_POST["type"];
$json["category_list"] = $category_list;
$json["success"] = $success;

echo json_encode($json);
?>
