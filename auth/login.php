<?php
$ROOT_DIR="../";
include $ROOT_DIR . "templates/header-blank.php";

?>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                  <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                  <div class="card-body">
                    <span style="color:red;"><?=$error;?></span>
                      <form method="post" action="process.php?action=user-login">
                          <div class="form-floating mb-3">
                              <input class="form-control" id="inputUsername" name="username" type="text" placeholder="User Name" />
                              <label for="inputUsername">User Name</label>
                          </div>
                          <div class="form-floating mb-3">
                              <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                              <label for="inputPassword">Password</label>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                              <button type="submit" class="btn btn-primary">Login</button>
                          </div>
                          <br>
                          <a href="register.php">No Account yet? Click here to sign up</a>
                          <br>
                      </form>
                  </div>
                  <div class="card-footer text-center py-3">
                  </div>
              </div>
          </div>
      </div>
  </div>
