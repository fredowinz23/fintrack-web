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

  $analysis_list = array();

  foreach (category()->list("type='$type' and (createdById=$user->Id or createdById=0)") as $row) {
    $item = array();
    $item["name"] = $row->name;
    if ($type=="Account") {
    $item["amount"] = get_analysis_by_account_amount($row->Id, $user->Id);
    }
    else{
    $item["amount"] = get_analysis_amount($row->Id, $user->Id);
    }
    array_push($analysis_list, $item);
  }

}

$json["username"] = $_POST["username"];
$json["type"] = $_POST["type"];
$json["analysis_list"] = $analysis_list;
$json["success"] = $success;

echo json_encode($json);
?>
