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
	  
	  <link rel="stylesheet" href="style.css">
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
		
	
		<?php if($_SESSION['adm_co'] != "VSUPP"){ ?>
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
		<?php } ?>
		
	<?php if($_SESSION['adm_co'] != "VSUPP"){ ?>
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
	<?php } ?> 
		
	
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
      
      <?php if($_SESSION['adm_co'] != "VSUPP"){ ?>
      <li>
        <a href="#">
          <i class='bx bx-history'></i>
          <span class="link_name">Report</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Report</a></li>
        </ul>
      </li>
		<?php } ?>
		
		
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
        <div class="profile_name"><span id="userName" /></div>
        <div class="job"><span id="userRole" /></div>
      </div>
		<a href="logout.php"><i class='bx bx-log-out' ></i></a>
    </div>
  </li>
</ul>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
	fetchData();
});

function fetchData() {
	var userid = <?php echo $_SESSION['adm_id']; ?>;
    $.ajax({
        url: 'action/fetchAdminData.php',
        type: 'GET',
		data:{userId: userid},
        dataType: 'json',
        success: function(response) {
			$('#userName').text(response[0][0]);
			$('#userRole').text(response[0][5]);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
</script>
