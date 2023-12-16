<?php
  $ROOT_DIR="../";
  include $ROOT_DIR . "templates/header.php";

  $userId = $_SESSION["user_session"]["Id"];
  $expense_category_list = category()->list("type='Expense' and (createdById=$userId or createdById=0)");
  $income_category_list = category()->list("type='Income' and (createdById=$userId or createdById=0)");
  $account_list = account()->list();

  $date = get_query_string("date", "");

  if ($date) {
    $record_list = record()->list("dateAdded='$date' and userId=$userId");
  }
  else{
    $record_list = record()->list("userId=$userId");
  }


  function get_total_amount($accountId, $type){
    $result = 0;
    foreach (record()->list("accountId=$accountId and type='$type'") as $row) {
      $result += $row->amount;
    }
    return $result;
  }
?>


<form action="transactions.php" method="get" style="width:400px;">
  <div class="input-group">
    <input  type="date" name="date" value="<?=$date;?>" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
    <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Filter</button>
    <a href="transactions.php" class="btn btn-primary ml-3" data-mdb-ripple-init>All</a>
  </div>
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
        <th>Notes</th>
      </tr>

      <?php
        $count = 0;
        $totalAmount = 0;
       foreach ($record_list as $row):
         $count += 1;
         $account = category()->get("Id=$row->accountId");
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
          <td><?=$row->notes;?></td>
        </tr>
      <?php endforeach; ?>

     <tr>
       <th>Total</th>
       <th colspan="6">
             Php <?=format_money($totalAmount);?>
       </th>
     </tr>
    </table>
  </div>
</div>

<?php include $ROOT_DIR . "templates/footer.php"; ?>
