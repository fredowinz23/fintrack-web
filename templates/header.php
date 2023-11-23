<?php
session_start();
require_once '../config/database.php';
require_once '../config/Models.php';
$ROOT_DIR = "../";

$userId = $_SESSION["user_session"]["Id"];
$user = $_SESSION["user_session"];

?>

<html lang="en">
  <head>
  	<title>Financial Tracking App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=$ROOT_DIR;?>templates/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>

		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(<?=$ROOT_DIR;?>templates/images/logo.jpg);"></a>
	        <ul class="list-unstyled components mb-5">
	          <li>
	              <a href="index.php">Records</a>
	          </li>
            <li>
	              <a href="transactions.php">Transactions</a>
	          </li>
            <li>
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Analysis</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="expense-overview.php">Expense overview</a>
                </li>
                <li>
                    <a href="income-overview.php">Income Overview</a>
                </li>
                <li>
                    <a href="#">Account Overview</a>
                </li>
	            </ul>
	          </li>
	          <li>
              <a href="account-types.php">Accounts</a>
	          </li>
            <li>
	            <a href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Category</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu2">
                <li>
                    <a href="category.php?type=Expense">Expense Category</a>
                </li>
                <li>
                    <a href="category.php?type=Income">Income Category</a>
                </li>
	            </ul>
	          </li>
	          <li>
              <a href="../auth/process.php?action=user-logout">Logout</a>
	          </li>
	        </ul>

	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | FinTrack</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><?=$user["firstName"]?> <?=$user["lastName"]?></a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
