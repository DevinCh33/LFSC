<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Merchant Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("./../connection/connect.php"); // connection to database

if(empty($_SESSION["adm_id"]))
{
	header('location:index.php');
}
?>

<body class="fix-header">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <?php
        include("sidebar.php");
        ?>
        <!-- Page wrapper  -->
        <div class="page-wrapper" style="height:1200px;">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <?php
                    if (isset($_SESSION["adm_co"]) && ($_SESSION["adm_co"] == "SUPA"))
                    {
                    ?>
                    <div class="col-md-3">
                        <a href="allrestraunt.php">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-archive f-s-40 color-warning"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2><?php $sql="select * from restaurant";
                                                    $result=mysqli_query($db,$sql); 
                                                        $rws=mysqli_num_rows($result);
                                                        
                                                        echo $rws;?></h2>
                                        <p class="m-b-0">Stores</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                    }
                    ?>
                    
					<div class="col-md-3">
                        <a href="all_menu.php">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-cutlery f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2><?php $sql="select * from product";
                                                    $result=mysqli_query($db,$sql); 
                                                        $rws=mysqli_num_rows($result);
                                                        
                                                        echo $rws;?></h2>
                                        <p class="m-b-0">Products</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
					
                    <div class="col-md-3">
                        <a href="allusers.php">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2><?php $sql="select * from users";
                                                    $result=mysqli_query($db,$sql); 
                                                        $rws=mysqli_num_rows($result);
                                                        
                                                        echo $rws;?></h2>
                                        <p class="m-b-0">Customer</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <a href="all_orders.php">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle"> 
                                        <span><i class="fa fa-shopping-cart f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2><?php $sql="select * from users_orders";
                                                    $result=mysqli_query($db,$sql); 
                                                        $rws=mysqli_num_rows($result);
                                                        
                                                        echo $rws;?></h2>
                                        <p class="m-b-0">Orders</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="/lfsc/inventory/index.php">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle"> 
                                        <span><i class="fa fa-shopping-cart f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2><?php $sql="select * from users_orders";
                                                    $result=mysqli_query($db,$sql); 
                                                        $rws=mysqli_num_rows($result);
                                                        
                                                        echo $rws;?></h2>
                                        <p class="m-b-0">Inventory Management System</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. </footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
</body>
</html>
