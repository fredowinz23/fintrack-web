<?php
include "../templates/api-header.php";
include "interface.php";

$json = array();
$success = true;


$username = $_POST["username"];
$user = user()->get("username='$username'");

$model = record();
$model->obj["amount"] = $_POST["amount"];
$model->obj["accountId"] = $_POST["accountFromId"];
$model->obj["categoryId"] = $_POST["categoryId"];
$model->obj["notes"] = $_POST["notes"];
$model->obj["type"] = "Expense";
$model->obj["dateAdded"] = "NOW()";
$model->obj["userId"] = $user->Id;
$model->create();

$model = record();
$model->obj["amount"] = $_POST["amount"];
$model->obj["accountId"] = $_POST["accountToId"];
$model->obj["categoryId"] = $_POST["categoryId"];
$model->obj["notes"] = $_POST["notes"];
$model->obj["type"] = "Income";
$model->obj["dateAdded"] = "NOW()";
$model->obj["userId"] = $user->Id;
$model->create();


$budget = forcasted_amount($user->Id);
$budgetHalf = $budget/2;
$successMessage = "Successfully created a new record";

$json["username"] = $_POST["username"];
$json["amount"] = $_POST["amount"];
$json["categoryId"] = $_POST["categoryId"];
$json["success"] = $success;
$json["successMessage"] = $successMessage;


header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);
?>
