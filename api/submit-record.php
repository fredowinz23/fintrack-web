<?php
include "../templates/api-header.php";
include "interface.php";

$json = array();
$success = true;


$username = $_POST["username"];
$user = user()->get("username='$username'");

$model = record();
$model->obj["amount"] = $_POST["amount"];
$model->obj["notes"] = $_POST["notes"];
$model->obj["accountId"] = $_POST["accountId"];
$model->obj["categoryId"] = $_POST["categoryId"];
$model->obj["type"] = $_POST["type"];
$model->obj["dateAdded"] = "NOW()";
$model->obj["userId"] = $user->Id;
$model->create();


$budget = forcasted_amount($user->Id);
$budgetHalf = $budget/2;
$successMessage = "Successfully created a new record";
if ($_POST["type"]=="Expense") {
  if (floatval($_POST["amount"])>=floatval($budgetHalf)) {
    $successMessage = "Warning! Max budget today is " . $budget;
  }
}

$json["username"] = $_POST["username"];
$json["amount"] = $_POST["amount"];
$json["categoryId"] = $_POST["categoryId"];
$json["type"] = $_POST["type"];
$json["success"] = $success;
$json["successMessage"] = $successMessage;


header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);
?>
