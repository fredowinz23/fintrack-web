<?php
  $ROOT_DIR="../";
  include $ROOT_DIR . "templates/header.php";

  $userId = $_SESSION["user_session"]["Id"];
  $expense_category_list = category()->list("type='Expense' and (createdById=$userId or createdById=0)");

  $date = get_query_string("date", "");
  if ($date) {
    $record_list = record()->list("dateAdded='$date'");
  }
  else{
    $record_list = record()->list();
  }



  function get_total_amount($categoryId){
    $result = 0;
    foreach (record()->list("categoryId=$categoryId") as $row) {
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
    Expense Overview
  </div>
  <div class="card-body">
    <table class="table">
      <tr>
        <th>#</th>
        <th>Expense Type</th>
        <th>Amount</th>
      </tr>

      <?php
        $count = 0;
        $totalAmount = 0;
       foreach ($expense_category_list as $row):
         $count += 1;
         ?>
        <tr>
          <td><?=$count;?>.</td>
          <td><?=$row->name;?></td>
          <td>Php <?=format_money(get_total_amount($row->Id));?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<?php include $ROOT_DIR . "templates/footer.php"; ?>
