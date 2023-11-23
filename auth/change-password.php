<?php
$ROOT_DIR="../";
include $ROOT_DIR . "templates/header-blank.php";

?>

  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                  <div class="card-header"><h3 class="text-center font-weight-light my-4">Change Password for <?=$_SESSION["user_session"]["username"]?></h3></div>
                  <div class="card-body">
                    <span style="color:red;"><?=$error;?></span>
                      <form method="post" action="process.php?action=change-password">
                          <div class="form-floating mb-3">
                              <input class="form-control" id="inputUsername" name="password1" type="password" placeholder="New Password" />
                              <label for="inputUsername">New Password</label>
                          </div>
                          <div class="form-floating mb-3">
                              <input class="form-control" id="inputPassword" name="password2" type="password" placeholder="Retype Password" />
                              <label for="inputPassword">Retype Password</label>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                              <button type="submit" class="btn btn-primary">Activate</button>
                          </div>
                      </form>
                  </div>
                  <div class="card-footer text-center py-3">
                  </div>
              </div>
          </div>
      </div>
  </div>
