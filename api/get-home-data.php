<?php
include "../templates/api-header.php";
include "interface.php";

$json = array();
$success = false;
if (isset($_POST["username"])) {
  $username = $_POST["username"];
  $user = user()->get("username='$username'");
  $userId = $user->Id;
  $success = true;

  $account_list = array();

  foreach (category()->list("type='Account' and (createdById=$user->Id or createdById=0)") as $row) {
    $item = wallet_interface($row, $user->Id);
    array_push($account_list, $item);
  }


// Total expense yesterday
$today = date("Y-m-d");
$totalExpenseUntilYesterday = 0;
foreach (record()->list("userId=$userId and type='Expense' and dateAdded<'$today'") as $row) {
  $totalExpenseUntilYesterday += $row->amount;
}

  // balance
$balance = 0;
  // total Expense
$expense_list = record()->list("userId=$userId and type='Expense'");
$totalExpense = 0;
foreach ($expense_list as $row) {
  $totalExpense += $row->amount;
}

// total Expense
$income_list = record()->list("userId=$userId and type='Income'");
$totalIncome = 0;
foreach ($income_list as $row) {
  $totalIncome += $row->amount;
}

$balance = $totalIncome-$totalExpense;


  // Todaysbudget
  $budget = 0;

  if ($expense_list) {
    $startTimeStamp = strtotime($expense_list[0]->dateAdded);
    $endTimeStamp = strtotime(date('Y-m-d',strtotime("-1 days")));
    $timeDiff = abs($endTimeStamp - $startTimeStamp);
    if ($timeDiff>0) {
      $numberDays = $timeDiff/86400;  // 86400 seconds in one day
      // and you might want to convert to integer
      $numberDays = intval($numberDays);
      $budget = $totalExpenseUntilYesterday/$numberDays;
    }
  }


  // Todays expense
  $expense = 0;
  $expense_list_today = record()->list("userId=$userId and type='Expense' and dateAdded='$today'");
  foreach ($expense_list_today as $row) {
    $expense += $row->amount;
  }
}

$json["username"] = $_POST["username"];
$json["account_list"] = $account_list;
$json["success"] = $success;
$json["budget"] = $budget;
$json["expense"] = $expense;
$json["balance"] = $balance;
$json["user"] = $user->firstName." ".$user->lastName;

echo json_encode($json);
?>
