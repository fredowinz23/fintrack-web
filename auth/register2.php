<?php
$ROOT_DIR="../";
$pageName = "Register cont...";
include $ROOT_DIR . "templates/header-blank.php";

?>

<div class="container">
  <center>
  <div class="card">
    <div class="card-header">
      <b>Enter User Information</b>
    </div>
      <form method="post" action="process.php?action=register-step-2">
      <div class="card-body">
        <div class="row text-left">
          <div class="col-lg-6">
            <b>First Name:</b>
            <input type="text" class="form-control" name="firstName" required>
          </div>
          <div class="col-lg-6">
            <b>Last Name:</b>
            <input type="text" class="form-control" name="lastName" required>
          </div>
        </div>
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary">Register</button>
      </div>
    </form>
  </div>
</center>
</div>


<?php include $ROOT_DIR . "templates/footer.php"; ?>
