<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';

$action = $_GET['action'];

switch ($action) {

	case 'record-add' :
		record_add();
		break;

	case 'transfer-fund' :
		transfer_fund();
		break;

	case 'category-save' :
		category_save();
		break;

	case 'category-delete' :
		category_delete();
		break;

	case 'account-save' :
		account_save();
		break;

	case 'account-delete' :
		account_delete();
		break;

	default :
}


function category_save(){
	#Process to save to the database

	$type = $_POST["type"];
	$createdById = $_SESSION["user_session"]["Id"];
	$model = category();
	$model->obj["createdById"] = $createdById;
	$model->obj["name"] = $_POST["name"];
	$model->obj["type"] = $_POST["type"];

	if ($_POST["form-type"] == "add") {
		$model->create();
		$successMessage = "New category has Successfully been added";
	}

	if ($_POST["form-type"] == "edit") {
		$Id = $_POST["Id"];
		$model->update("Id=$Id");
		$successMessage = "A category has Successfully been modified";
	}

	header('Location: category.php?type='.$type.'&success=' . $successMessage);
}

function category_delete(){
	$Id = $_GET["Id"];
	$type = $_GET["type"];

	category()->delete("Id=$Id");
	header('Location: category.php?type='.$type.'&success=Category has been deleted');
}


function account_save(){
	#Process to save to the database

	$createdById = $_SESSION["user_session"]["Id"];
	$model = account();
	$model->obj["createdById"] = $createdById;
	$model->obj["name"] = $_POST["name"];

	if ($_POST["form-type"] == "add") {
		$model->create();
		$successMessage = "New account has Successfully been added";
	}

	if ($_POST["form-type"] == "edit") {
		$Id = $_POST["Id"];
		$model->update("Id=$Id");
		$successMessage = "A account has Successfully been modified";
	}

	header('Location: account-types.php?success=' . $successMessage);
}

function account_delete(){
	$Id = $_GET["Id"];

	account()->delete("Id=$Id");
	header('Location: account-types.php?success=Account has been deleted');
}


function record_add(){

	$model = record();
	$model->obj["amount"] = $_POST["amount"];
	$model->obj["accountId"] = $_POST["accountId"];
	$model->obj["categoryId"] = $_POST["categoryId"];
	$model->obj["type"] = $_POST["type"];
	$model->obj["dateAdded"] = "NOW()";
	$model->obj["userId"] = $_SESSION["user_session"]["Id"];
	$model->create();


	$successMessage = "Successfully created a new record";
	if ($_POST["type"]=="Expense") {
		if (floatval($_POST["amount"])>=floatval($_POST["forcastedAmount"])) {
			$successMessage = "Warning! Max budget today is " . ($_POST["forcastedAmount"]*2);
		}
	}

	// print_r($_POST);
	header('Location: index.php?success=' . $successMessage);
}



function transfer_fund(){

	$model = record();
	$model->obj["amount"] = $_POST["amount"];
	$model->obj["accountId"] = $_POST["accountFrom"];
	$model->obj["categoryId"] = $_POST["categoryId"];
	$model->obj["type"] = "Expense";
	$model->obj["dateAdded"] = "NOW()";
	$model->obj["userId"] = $_SESSION["user_session"]["Id"];
	$model->create();

	$model = record();
	$model->obj["amount"] = $_POST["amount"];
	$model->obj["accountId"] = $_POST["accountTo"];
	$model->obj["categoryId"] = $_POST["categoryId"];
	$model->obj["type"] = "Income";
	$model->obj["dateAdded"] = "NOW()";
	$model->obj["userId"] = $_SESSION["user_session"]["Id"];
	$model->create();
	header('Location: index.php?success=Successfully created a new record');
}
