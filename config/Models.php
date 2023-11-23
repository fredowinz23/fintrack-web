<?php
include "CRUD.php";
include "functions.php";

function user() {
	$crud = new CRUD;
	$crud->table = "user";
	return $crud;
}

function account() {
	$crud = new CRUD;
	$crud->table = "account";
	return $crud;
}

function record() {
	$crud = new CRUD;
	$crud->table = "record";
	return $crud;
}

function category() {
	$crud = new CRUD;
	$crud->table = "category";
	return $crud;
}


?>
