<?php
$ROOT_DIR="../";
include $ROOT_DIR . "templates/header-blank.php";
?>


<div class="container">
  <center>
  <div class="card" style="width:75%;">
    <div class="card-header">
      Sign Up
    </div>
      <form method="post" action="process.php?action=register-step-1">
      <div class="card-body">
        <p style="color:red"><?=$error;?></p>
        <b>Username:</b>
        <input type="text" class="form-control" name="username" required>
        <b>Password:</b>
        <input type="password" class="form-control" name="password1" id="reg_password1" required>
        <b>Retype password:</b>
        <input type="password" class="form-control" name="password2" id="reg_password2" required>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary">Next</button>
      </div>
    </form>
  </div>
</center>
</div>

<script>
var reg_password = document.getElementById("reg_password1")
  , reg_confirm_password = document.getElementById("reg_password2");

function validatePassword(){
  if(reg_password.value != reg_confirm_password.value) {
    reg_confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    reg_confirm_password.setCustomValidity('');
  }
}

reg_password.onchange = validatePassword;
reg_confirm_password.onkeyup = validatePassword;

</script>


<?php include $ROOT_DIR . "templates/footer.php"; ?>
