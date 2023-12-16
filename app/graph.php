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

<form action="graph.php" method="get" style="width:400px;">
  <div class="input-group">
    <input type="hidden" name="type" value="<?=$type;?>">
    <input  type="date" name="date" value="<?=$date;?>" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
    <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Filter</button>
    <a href="?type=<?=$type;?>" class="btn btn-primary ml-3" data-mdb-ripple-init>All</a>
  </div>
</form>


<h3><?=$type?> Graph</h3>

<canvas id="recordGraph"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

const recordGraph = document.getElementById('recordGraph');

new Chart(recordGraph, {
  type: 'bar',
  data: {
    labels: [
      <?php
        $count = 0;
        $totalAmount = 0;
       foreach ($category_list as $row):
         $count += 1;
         ?>
        '<?=$row->name;?>',
      <?php endforeach; ?>

    ],
    datasets: [{
      label: 'Graph',
      data: [

          <?php
            $count = 0;
            $totalAmount = 0;
           foreach ($category_list as $row):
             $count += 1;
             ?>
             <?php if ($type=="Account"): ?>
                   <?=get_total_account_amount($row->Id, $date);?>,
               <?php else: ?>
                   <?=get_total_amount($row->Id, $date);?>,
             <?php endif; ?>
          <?php endforeach; ?>
      ],
     backgroundColor: ["#64B5F6", "#FFD54F", "#2196F3", "#FFC107", "#1976D2", "#FFA000", "#0D47A1"],
     hoverBackgroundColor: ["#B2EBF2", "#FFCCBC", "#4DD0E1", "#FF8A65", "#00BCD4", "#FF5722", "#0097A7"],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

</script>


<?php include $ROOT_DIR . "templates/footer.php"; ?>
