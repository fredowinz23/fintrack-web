<?php
include "../templates/api-header.php";
include "interface.php";

$json = array();
$success = false;
if (isset($_POST["username"])) {
  $username = $_POST["username"];
  $user = user()->get("username='$username'");
  $success = true;

  $account_list = array();

  foreach (account()->list("createdById=$user->Id or createdById=0") as $row) {
    $item = wallet_interface($row, $user->Id);
    array_push($account_list, $item);
  }
}

$json["username"] = $_POST["username"];
$json["account_list"] = $account_list;
$json["success"] = $success;
$json["budget"] = 200;

echo json_encode($json);
?>
