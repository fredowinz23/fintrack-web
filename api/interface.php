<?php
function get_analysis_amount($categoryId, $userId){
  $result = 0;
  foreach (record()->list("categoryId=$categoryId and userId=$userId") as $row) {
    $result += $row->amount;
  }
  return $result;
}

function get_analysis_by_account_amount($accountId, $userId){
  $result = 0;
  foreach (record()->list("accountId=$accountId and userId=$userId") as $row) {
    $result += $row->amount;
  }
  return $result;
}

function get_total_amount($accountId, $userId, $type){
  $result = 0;
  foreach (record()->list("accountId=$accountId and userId=$userId and type='$type'") as $row) {
    $result += $row->amount;
  }
  return $result;
}

function forcasted_amount($userId){
  $expense_list = record()->list("userId=$userId and type='Expense'");

  $totalExpense = 0;
  foreach ($expense_list as $row) {
    $totalExpense += $row->amount;
  }

  $forcastedAmount = 0;

  $today = date("Y-m-d");
  $totalExpenseUntilYesterday = 0;
  foreach (record()->list("userId=$userId and type='Expense' and dateAdded<'$today'") as $row) {
    $totalExpenseUntilYesterday += $row->amount;
  }


  if ($expense_list) {
    $startTimeStamp = strtotime($expense_list[0]->dateAdded);
    $endTimeStamp = strtotime(date('Y-m-d',strtotime("-1 days")));
    $timeDiff = abs($endTimeStamp - $startTimeStamp);
    if ($timeDiff>0) {
      $numberDays = $timeDiff/86400;  // 86400 seconds in one day
      // and you might want to convert to integer
      $numberDays = intval($numberDays);
      $forcastedAmount = $totalExpenseUntilYesterday/$numberDays;
      $fiftyPercent = $forcastedAmount/2;
    }
  }

  return $forcastedAmount;
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

  $account = category()->get("Id=$row->accountId");
  $accountObj = category_interface($account);

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
