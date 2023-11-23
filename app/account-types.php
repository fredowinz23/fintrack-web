<?php
$ROOT_DIR="../";
include $ROOT_DIR . "templates/header.php";


$userId = $_SESSION["user_session"]["Id"];
$account_list = account()->list("createdById=$userId or createdById=0");

?>

<style media="screen">
  .card-category{
    cursor: pointer;
    min-height: 200px;
  }
  .card-category:hover{
    background: #f0f2f0;
  }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" href="javascript:void(0)" id="btn-add-category">
  Add New Account +
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="process.php?action=account-save" method="post">

        <div class="modal-body">
          <b>Name:</b>
          <input type="hidden" name="Id" id="c-id">
          <input type="text" name="name" id="c-name" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button name="form-type" value="add" id="btn-add" class="btn btn-primary">Add</button>
          <button name="form-type" value="edit" id="btn-edit" class="btn btn-warning">Save</button>
        </div>

      </form>
    </div>
  </div>
</div>

<div class="row mt-3">

  <?php foreach ($account_list as $row):
     ?>
    <div class="col-lg-3 mt-2 category-items">
        <div class="card card-category"  onmouseover="display_button('button_<?=$row->Id?>')"  onmouseout="hide_button('button_<?=$row->Id?>')" style="min-height:150px;">
          <div class="card-body category-data"
          data-id="<?=$row->Id;?>"
          data-name="<?=$row->name;?>"
          >
            <h3><?=$row->name;?></h3>
            <?php if ($row->createdById!=0): ?>
              <div id="button_<?=$row->Id?>" style="display:none;" class="row">
                <div class="col text-center">
                  <a href="process.php?action=account-delete&Id=<?=$row->Id?>" class="btn btn-danger">Delete</a>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
    </div>
<?php endforeach;?>

</div>


<script type="text/javascript">
  function display_button(x){
    document.getElementById(x).style = "display:";
  }
  function hide_button(x){
    document.getElementById(x).style = "display:none";
  }
</script>

<?php include $ROOT_DIR . "templates/footer.php"; ?>


<script type="text/javascript">
$(function () {

    $("#btn-add-category").on("click", function (event) {


      var getParentItem = $(this).parents(".category-items");
      var getModal = $("#exampleModal");

      // Get List Item Fields
      var $_name = getParentItem.find(".category-data");
      getModal.find("#c-name").val("");

      $("#exampleModal #btn-add").show();
      $("#exampleModal #btn-edit").hide();
      $("#exampleModal").modal("show");
    });


  });

</script>
