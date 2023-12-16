<?php
  $ROOT_DIR="../";
  include $ROOT_DIR . "templates/header.php";

  $dateNow = date("Y-m-d");

  $userId = $_SESSION["user_session"]["Id"];
  $expense_category_list = category()->list("type='Expense' and (createdById=$userId or createdById=0)");
  $income_category_list = category()->list("type='Income' and (createdById=$userId or createdById=0)");
  $account_list = category()->list("type='Account' and (createdById=$userId or createdById=0)");
  $record_list = record()->list("dateAdded='$dateNow'");

  function get_total_amount($accountId, $userId, $type){
    $result = 0;
    foreach (record()->list("accountId=$accountId and userId=$userId and type='$type'") as $row) {
      $result += $row->amount;
    }
    return $result;
  }

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

$totalBalance = $totalIncome-$totalExpense;


  $today = date("Y-m-d");
  $totalExpenseUntilYesterday = 0;
  foreach (record()->list("userId=$userId and type='Expense' and dateAdded<'$today'") as $row) {
    $totalExpenseUntilYesterday += $row->amount;
  }


  $expense_list_today = record()->list("userId=$userId and type='Expense' and dateAdded='$today'");
  $todayExpense = 0;
  foreach ($expense_list_today as $row) {
    $todayExpense += $row->amount;
  }

  $forcastedAmount = 0;

  if ($expense_list) {
    $startTimeStamp = strtotime($expense_list[0]->dateAdded);
    $endTimeStamp = strtotime(date('Y-m-d'));
    $timeDiff = abs($endTimeStamp - $startTimeStamp);
    if ($timeDiff>0) {
      $numberDays = $timeDiff/86400;  // 86400 seconds in one day
      // and you might want to convert to integer
      $numberDays = intval($numberDays);
      $forcastedAmount = $totalExpenseUntilYesterday/$numberDays;
      $fiftyPercent = $forcastedAmount/2;
    }
  }

  $get70Percent = $forcastedAmount*.7;

?>
<br>

<div class="card mb-2">
  <div class="card-body">
    <div class="row">
      <div class="col-6">
          <li class="list-group-item">
            <div class="row">
              <div class="col">
                Name:
              </div>
              <div class="col text-right">
                <?=$user['firstName']?> <?=$user['lastName']?>
              </div>
            </div>
          </li>

          <li class="list-group-item">
            <div class="row">
              <div class="col">
                Balance:
              </div>
              <div class="col text-right">
                Php <?=format_money($totalBalance);?>
              </div>
            </div>
          </li>

          <li class="list-group-item">
            <div class="row">
              <div class="col">
                Today's budget:
              </div>
              <div class="col text-right">
                 Php <?=format_money($forcastedAmount);?>
              </div>
            </div>
          </li>

          <li class="list-group-item">
            <div class="row">
              <div class="col">
                Today's Expenses
              </div>
              <div class="col text-right">
                 Php <?=format_money($todayExpense);?>
              </div>
            </div>
          </li>
      </div>
      <div class="col-6 text-center">
        <a href="index2.php" class="btn btn-primary" style="margin-top:70px">View Records</a>
      </div>
    </div>

    <!-- <?php if ($todayExpense>=$get70Percent): ?>
      <div class="alert alert-danger" role="alert">
        You have exceeded 70% of your daily budget! Please spend wisely!
      </div>
    <?php endif; ?> -->
  </div>
</div>


<?php include $ROOT_DIR . "templates/footer.php"; ?>
