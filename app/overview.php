<?php
  $ROOT_DIR="../";
  include $ROOT_DIR . "templates/header.php";

  $type = $_GET["type"];

  $userId = $_SESSION["user_session"]["Id"];
  $category_list = category()->list("type='$type' and (createdById=$userId or createdById=0)");

  $date = get_query_string("date", "");

  function get_total_amount($categoryId, $date){
    $result = 0;
    $userId = $_SESSION["user_session"]["Id"];
    if ($date) {
      $params = "categoryId=$categoryId and userId=$userId and dateAdded='$date'";
    }
    else{
      $params = "categoryId=$categoryId and userId=$userId";
    }
    foreach (record()->list($params) as $row) {
      $result += $row->amount;
    }
    return $result;
  }

  function get_total_account_amount($categoryId, $date){
  	$result = 0;
  	$userId = $_SESSION["user_session"]["Id"];
  	if ($date) {
  		$params = "accountId=$categoryId and userId=$userId and dateAdded='$date'";
  	}
  	else{
  		$params = "accountId=$categoryId and userId=$userId";
  	}
  	foreach (record()->list($params) as $row) {
  		$result += $row->amount;
  	}
  	return $result;
  }
?>

<form action="overview.php" method="get" style="width:400px;">
  <div class="input-group">
    <input type="hidden" name="type" value="<?=$type;?>">
    <input  type="date" name="date" value="<?=$date;?>" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
    <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Filter</button>
    <a href="?type=<?=$type;?>" class="btn btn-primary ml-3" data-mdb-ripple-init>All</a>
  </div>
</form>

<div class="card mt-3">
  <div class="card-header">
    <?=$type;?> Overview
  </div>
  <div class="card-body">
    <table class="table">
      <tr>
        <th>#</th>
        <th><?=$type;?> Type</th>
        <th>Amount</th>
      </tr>

      <?php
        $count = 0;
        $totalAmount = 0;
       foreach ($category_list as $row):
         $count += 1;
         ?>
        <tr>
          <td><?=$count;?>.</td>
          <td><?=$row->name;?></td>
          <?php if ($type=="Account"): ?>
          <td>Php <?=format_money(get_total_account_amount($row->Id, $date));?></td>
          <?php else: ?>
          <td>Php <?=format_money(get_total_amount($row->Id, $date));?></td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<?php include $ROOT_DIR . "templates/footer.php"; ?>
