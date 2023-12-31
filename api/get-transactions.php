<?php
include "../templates/api-header.php";
include "interface.php";

$json = array();
$success = false;
if (isset($_POST["username"])) {
  $username = $_POST["username"];
  $filterDate = $_POST["filterDate"];
  $user = user()->get("username='$username'");
  $success = true;

  $record_list = array();
  if ($filterDate) {
    $dateParams = "and dateAdded='$filterDate'";
  }
  else{
    $dateParams = "";
  }

  foreach (record()->list("userId=$user->Id $dateParams") as $row) {
    $item = record_interface($row);
    array_push($record_list, $item);
  }
}

$json["username"] = $_POST["username"];
$json["record_list"] = $record_list;
$json["success"] = $success;

echo json_encode($json);
?>
