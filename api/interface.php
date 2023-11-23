<?php
function get_total_amount($accountId, $userId, $type){
  $result = 0;
  foreach (record()->list("accountId=$accountId and userId=$userId and type='$type'") as $row) {
    $result += $row->amount;
  }
  return $result;
}


function user_interface($row){
  $item = array();
  $item["id"] = $row->Id;
  $item["firstName"] = $row->firstName;
  $item["lastName"] = $row->lastName;
  return $item;
}

function category_interface($row){
  $item = array();
  $item["id"] = $row->Id;
  $item["name"] = $row->name;
  $item["type"] = $row->type;
  return $item;
}

function wallet_interface($row, $userId){
  $balance = get_total_amount($row->Id, $userId, "Income")-get_total_amount($row->Id, $userId, "Expense");
  $income = get_total_amount($row->Id, $userId, "Income");
  $expense = get_total_amount($row->Id, $userId, "Expense");
  $item = array();
  $item["id"] = $row->Id;
  $item["name"] = $row->name;
  $item["income"] = $income;
  $item["expense"] = $expense;
  $item["balance"] = $balance;
  return $item;
}

function account_interface($row){
  $item = array();
  $item["id"] = $row->Id;
  $item["name"] = $row->name;
  return $item;
}

function record_interface($row){

  $account = account()->get("Id=$row->accountId");
  $accountObj = account_interface($account);

  $category = category()->get("Id=$row->categoryId");
  $categoryObj = category_interface($category);

  $item = array();
  $item["id"] = $row->Id;
  $item["amount"] = $row->amount;
  $item["type"] = $row->type;
  $item["account"] = $accountObj;
  $item["category"] = $categoryObj;
  $item["dateAdded"] = $row->dateAdded;
  return $item;
}

?>
