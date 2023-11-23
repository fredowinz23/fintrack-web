<?php
  $ROOT_DIR="../";
  include $ROOT_DIR . "templates/header.php";

  $userId = $_SESSION["user_session"]["Id"];
  $expense_category_list = category()->list("type='Expense' and (createdById=$userId or createdById=0)");
  $income_category_list = category()->list("type='Income' and (createdById=$userId or createdById=0)");
  $account_list = account()->list();

  $date = get_query_string("date", date("Y-m-d"));
  $record_list = record()->list("dateAdded='$date'");
  

  function get_total_amount($accountId, $type){
    $result = 0;
    foreach (record()->list("accountId=$accountId and type='$type'") as $row) {
      $result += $row->amount;
    }
    return $result;
  }
?>

<form action="transactions.php" method="get">
  <input type="date" name="date" value="<?=$date;?>" required class="form-control mb-2" style="width:500px;">
  <button type="submit" class="btn btn-primary">Filter Date</button>
</form>

<div class="card mt-3">
  <div class="card-header">
    Transactions
  </div>
  <div class="card-body">
    <table class="table">
      <tr>
        <th>#</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Account</th>
        <th>Category</th>
        <th>Date</th>
      </tr>

      <?php
        $count = 0;
        $totalAmount = 0;
       foreach ($record_list as $row):
         $count += 1;
         $account = account()->get("Id=$row->accountId");
         $category = category()->get("Id=$row->categoryId");
         if ($row->type=="Income") {
           $totalAmount += $row->amount;
         }
         else {
           $totalAmount -= $row->amount;
         }
         ?>
        <tr>
          <td><?=$count;?>.</td>
          <td>
            <?php if ($row->type=="Income"): ?>
                Php <?=format_money($row->amount);?>
            <?php else: ?>
              <i style="color:red;">(Php <?=format_money($row->amount);?>)</i>
            <?php endif; ?>

          </td>
          <td><?=$row->type;?></td>
          <td><?=$account->name;?></td>
          <td><?=$category->name;?></td>
          <td><?=$row->dateAdded;?></td>
        </tr>
      <?php endforeach; ?>

     <tr>
       <th>Total</th>
       <th colspan="5">
             Php <?=format_money($totalAmount);?>
       </th>
     </tr>
    </table>
  </div>
</div>

<?php include $ROOT_DIR . "templates/footer.php"; ?>
