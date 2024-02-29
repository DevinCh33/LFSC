<?php include 'connect.php'; ?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
	 <?php
	  	session_start();
	  	$_SESSION["adm_id"] = 17;
		$_SESSION["adm_co"] = "SUPP";
		$_SESSION["u_role"] = "SELLER";
		$_SESSION['store'] = 51;

	  ?>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
	
	
	<div class="logo-details">
		<img src="img/logo.png" width="80" height="80" id="logo" name="logo"></img>
		<span id="logo_name" name="logo_name"  class="logo_name">Little Farmer</span>
    </div>
	<div style="logo_name">
		
	</div>
		
    <ul class="nav-links">
      <li>
        <a href="dashboard.php">
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="dashboard.php">Dashboard</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="employee.php">
            <i class='bx bx-collection' ></i>
            <span class="link_name">Employee</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Employee</a></li>
          <li><a href="#">HTML & CSS</a></li>
          <li><a href="#">JavaScript</a></li>
          <li><a href="#">PHP & MySQL</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="product.php">
            <i class='bx bx-book-alt' ></i>
            <span class="link_name">Products</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="product.php">Products</a></li>
          <li><a href="#">Web Design</a></li>
          <li><a href="#">Login Form</a></li>
          <li><a href="#">Card Design</a></li>
        </ul>
      </li>
      <li>
        <a href="customer.php">
          <i class='bx bx-pie-chart-alt-2' ></i>
          <span class="link_name">Customer</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="customer.php">Customer</a></li>
        </ul>
      </li>
      <li>
        <a href="order.php">
          <i class='bx bx-line-chart' ></i>
          <span class="link_name">Order</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="order.php">Order</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-plug' ></i>
            <span class="link_name">Plugins</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Plugins</a></li>
          <li><a href="#">UI Face</a></li>
          <li><a href="#">Pigments</a></li>
          <li><a href="#">Box Icons</a></li>
        </ul>
      </li>
      <li>
        <a href="inventory.php">
          <i class='bx bx-compass' ></i>
          <span class="link_name">Inventory</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="inventory.php">Inventory</a></li>
        </ul>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-history'></i>
          <span class="link_name">Report</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Report</a></li>
        </ul>
      </li>
      <li>
        <a href="setting.php">
          <i class='bx bx-cog' ></i>
          <span class="link_name">Setting</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Setting</a></li>
        </ul>
      </li>
      <li>
    <div class="profile-details">
      <div class="profile-content">
        <!--<img src="image/profile.jpg" alt="profileImg">-->
      </div>
      <div class="name-job">
        <div class="profile_name">Prem Shahi</div>
        <div class="job">Web Desginer</div>
      </div>
      <i class='bx bx-log-out' ></i>
    </div>
  </li>
</ul>