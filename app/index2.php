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

        <div class="text-center" style="margin-top:20px;">

          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addIncomeModal">
            + Add Income
          </button>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExpenseModal">
            + Add Expense
          </button>

          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transferFundModal">
            + Transfer fund
          </button>

        </div>


    </div>
    <div class="col-6">
      <?php foreach ($account_list as $row):
        $balance = get_total_amount($row->Id, $userId, "Income")-get_total_amount($row->Id, $userId, "Expense");
         ?>

            <li class="list-group-item" style="background:#e0e0e0;">
              <b><?=$row->name;?></b>
            </li>
             <li class="list-group-item">
               <div class="row">
                 <div class="col">
                   Income:
                 </div>
                 <div class="col text-right">
                    Php <?=format_money(get_total_amount($row->Id, $userId, "Income"));?>
                 </div>
               </div>
             </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col">
                    Expense:
                  </div>
                  <div class="col text-right">
                     Php <?=format_money(get_total_amount($row->Id, $userId, "Expense"));?>
                  </div>
                </div>
              </li>
               <li class="list-group-item mb-3">
                 <div class="row">
                   <div class="col">
                     Balance:
                   </div>
                   <div class="col text-right">
                      Php <?=format_money($balance);?>
                   </div>
                 </div>
               </li>

      <?php endforeach; ?>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Expense</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="process.php?action=record-add" method="post">

      <div class="modal-body">
        <div class="row">
          <div class="col-12 mb-3">
            <b>Amount</b>
            <input type="number" name="amount" class="form-control" required>
            <input type="hidden" name="type" value="Expense" required>
            <input type="hidden" name="forcastedAmount" value="<?=$fiftyPercent;?>" required>
          </div>

          <div class="col-12 mb-3">
            <b>Account</b>
            <select class="form-control" name="accountId" required>
              <option value="">--Select Account--</option>
              <?php foreach ($account_list as $row): ?>
                <option value="<?=$row->Id?>"><?=$row->name;?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12">
            <b>Category</b>
            <select class="form-control" name="categoryId" required>
              <option value="">--Select Category--</option>
              <?php foreach ($expense_category_list as $row): ?>
                <option value="<?=$row->Id?>"><?=$row->name;?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12 mb-3">
            <b>Notes</b>
            <textarea name="notes" class="form-control" required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>

      </form>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addIncomeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Income</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="process.php?action=record-add" method="post">

      <div class="modal-body">
        <div class="row">
          <div class="col-12 mb-3">
            <b>Amount</b>
            <input type="number" name="amount" class="form-control" required>
            <input type="hidden" name="type" value="Income" required>
          </div>

          <div class="col-12 mb-3">
            <b>Account</b>
            <select class="form-control" name="accountId" required>
              <option value="">--Select Account--</option>
              <?php foreach ($account_list as $row): ?>
                <option value="<?=$row->Id?>"><?=$row->name;?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12">
            <b>Category</b>
            <select class="form-control" name="categoryId" required>
              <option value="">--Select Category--</option>
              <?php foreach ($income_category_list as $row): ?>
                <option value="<?=$row->Id?>"><?=$row->name;?></option>
              <?php endforeach; ?>
            </select>
          </div>


          <div class="col-12 mb-3">
            <b>Notes</b>
            <textarea name="notes" class="form-control" required></textarea>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>

      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="transferFundModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Transfer Fund</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="process.php?action=transfer-fund" method="post">

      <div class="modal-body">
        <div class="row">
          <div class="col-12 mb-3">
            <b>Amount</b>
            <input type="number" name="amount" class="form-control" required>
          </div>

          <div class="col-12 mb-3">
            <b>Account From</b>
            <select class="form-control" name="accountFrom" required>
              <option value="">--Select Account--</option>
              <?php foreach ($account_list as $row): ?>
                <option value="<?=$row->Id?>"><?=$row->name;?></option>
              <?php endforeach; ?>
            </select>
          </div>



          <div class="col-12 mb-3">
            <b>Account To</b>
            <select class="form-control" name="accountTo" required>
              <option value="">--Select Account--</option>
              <?php foreach ($account_list as $row): ?>
                <option value="<?=$row->Id?>"><?=$row->name;?></option>
              <?php endforeach; ?>
            </select>
          </div>


          <div class="col-12">
            <b>Category</b>
            <select class="form-control" name="categoryId" required>
              <option value="">--Select Category--</option>
              <?php foreach ($income_category_list as $row): ?>
                <option value="<?=$row->Id?>"><?=$row->name;?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12 mb-3">
            <b>Notes</b>
            <textarea name="notes" class="form-control" required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Transfer</button>
      </div>

      </form>
    </div>
  </div>
</div>



<?php include $ROOT_DIR . "templates/footer.php"; ?>
