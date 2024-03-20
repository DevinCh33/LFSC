<!DOCTYPE html>
<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./../landing/logo.png">
    <title>Order Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>


        .popup-container {
			display: none;
			position: fixed;
			top: 30%;
			left: 50%;
			transform: translate(-50%, -50%);
			padding: 20px;
			background-color: #fff;
			border: 1px solid #ccc;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			z-index: 1000;
			width: 70%;
			margin-top: 10%;
		}

		.popup-container button {
			background-color: transparent;
			border: none;
			padding: 8px 12px;
			color: #333;
			font-size: 14px;
			cursor: pointer;
		}

		.overlay {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.5);
			z-index: 999;
		}

    </style>
</head>

<body class="fix-header fix-sidebar">
<?php

include("../connection/connect.php"); // connection to database

if(isset($_SESSION["adm_co"]))
{
	echo "hai";
?>
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
        <div class="page-wrapper">
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All User Orders</h4>
                             
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
												<th>Order ID#</th>
                                                <th>Username</th>
												<?php if($_SESSION['adm_co'] == "SUPA"){ ?>
                                                	<th>Title</th>
												<?php } ?>
                                                <th>Quantity</th>
                                                <th>Total Amount</th>
                                                <th>Address</th>
                                                <th>Status</th>												
                                                <th>Order Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
												if($_SESSION['adm_co'] == "SUPP")
													$sql = "SELECT orders.order_id,orders.order_status,orders.order_date,orders.user_id, SUM(order_item.quantity) AS totalQ, orders.total_amount, product.product_name, restaurant.title, users.username, users.address
														FROM orders
														JOIN order_item ON orders.order_id = order_item.order_id
														JOIN tblprice ON order_item.priceID = tblprice.priceNo
														JOIN users ON orders.user_id = users.u_id
														JOIN product ON tblprice.productID = product.product_id
														JOIN restaurant ON product.owner = restaurant.rs_id
														WHERE orders.order_belong = '".$_SESSION['store']."' AND orders.order_status <= 2
														Group BY orders.order_id
														ORDER BY orders.order_status";
												else
													$sql = "SELECT orders.order_id,orders.order_status, orders.order_date,orders.user_id, order_item.quantity, order_item.price, product.product_name, restaurant.title, users.username, users.address
														FROM orders
														JOIN order_item ON orders.order_id = order_item.order_id
														JOIN users ON orders.user_id = users.u_id
														JOIN product ON order_item.product_id = product.product_id
														JOIN restaurant ON product.owner = restaurant.rs_id
														WHERE orders.order_status <= 2
														ORDER BY orders.order_status";
												$query = mysqli_query($db,$sql);
												
                                                if(!mysqli_num_rows($query) > 0 )
                                                {
													if($_SESSION['adm_id'] == "SUPA")
                                                    	echo '<td colspan="8"><center>No orders data!</center></td>';
													else
														echo '<td colspan="8"><center>No orders data!</center></td>';
                                                }

                                                else
                                                {				
                                                    while($rows=mysqli_fetch_array($query))
                                                    {                                                                            
                                                        ?>
                                                        <?php
                                                        echo ' <tr>
																<td style="text-decoration: underline;font-weight: bold;"><a onclick="openPopup(\''.$rows['order_id'].'\')">'.$rows['order_id'].'</a></td>
                                                                <td  style="text-decoration: underline;font-weight: bold;"><a onclick="userPopup(\''.$rows['user_id'].'\')">'.$rows['username'].'</a></td>';
																if($_SESSION['adm_co'] == "SUPA")
                                                            		echo '<td>'.$rows['title'].'</td>';
                                                                echo '<td>'.$rows['totalQ'].'</td>
                                                                <td>$'.$rows['total_amount'].'</td>
                                                                <td>'.$rows['address'].'</td>';
                                                        ?>
                                                        <?php
                                                            $status=$rows['order_status'];
                                                            if($status=="1" )
                                                            {
                                                        ?>
                                                        <td> <button type="button" class="btn btn-info" style="font-weight:bold;"><span class="fa fa-bars"  aria-hidden="true">Processing</button></td>
                                                        <?php 
                                                            }
                                                            if($status=="2")
                                                            { 
                                                        ?>
                                                        <td> <button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"  aria-hidden="true"></span>On the Way!</button></td> 
                                                        <?php
                                                            }
                                                            if($status=="3")
                                                            {
                                                        ?>
                                                        <td> <button type="button" class="btn btn-success" ><span  class="fa fa-check-circle" aria-hidden="true">Delivered</button></td> 
                                                        <?php 
                                                            } 
                                                        ?>
                                                        <?php
                                                            if($status=="4")
                                                            {
                                                        ?>
                                                        <td> <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i>Cancelled</button></td> 
                                                        <?php 
                                                            } 																									
                                                        echo '	<td>'.$rows['order_date'].'</td>';
                                                        ?>
                                                            <td>
                                                                <a href="delete_orders.php?order_del=<?php echo $rows['order_id'];?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
                                                            <?php
                                                                echo '<a href="view_order.php?order_upd='.$rows['order_id'].'" " class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="ti-settings"></i></a>
                                                            </td>
                                                         </tr>';
                                                    }	
                                                }
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                </div>
				<div id="popup" class="popup-container">
					<div style="display: flex; justify-content: space-between; align-items: center; text-align: right; font-size: 30px;">
						<div><a style="color: black; text-align: center">Order Details</a></div>
						<button onclick="closePopup()" style="font-size: 20px;">X</button>
					</div>



					<table style="width: 100%;" border="1">
						<thead style="text-align: center;">
							<tr style="background-color: red;">
								<th style="text-align: center; color: white;">Image</th>
								<th style="text-align: center; color: white;">Product Name</th>
								<th style="text-align: center; color: white;">Quantity</th>
								
							</tr>
						</thead>
						<tbody id="orderBody">
							
						</tbody>
					</table>
				</div>
				
				<div id="userPopup" class="popup-container">
					<div style="display: flex; justify-content: space-between; align-items: center; text-align: right; font-size: 30px;">
						<div><a style="color: black; text-align: center">Client Details</a></div>
						<button onclick="closePopup()" style="font-size: 20px;">X</button>
					</div>



					<table style="width: 100%;" border="1">
						<thead style="text-align: center;">
							<tr style="background-color: red;">
								<th style="text-align: center; color: white;">Name</th>
								<th style="text-align: center; color: white;">Phone</th>
								<th style="text-align: center; color: white;">Email</th>
								<th style="text-align: center; color: white;">Address</th>
							</tr>
						</thead>
						<tbody id="userBody">
							
						</tbody>
					</table>
				</div>

				<div id="overlay" class="overlay" onclick="closePopup()"></div>
				
                <!-- End Page Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- End footer -->
        </div>
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

    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
<?php
}
?>
</body>
</html>

<script>
function openPopup(orderId) {
	 document.getElementById('popup').style.display = 'block';
     document.getElementById('overlay').style.display = 'block';
	
	 $.ajax({
        url: 'getOrderProduct.php', // Path to your PHP script
        type: 'GET',
		data: { orderId: orderId },
        dataType: 'json',
        success: function(data) {
            var tbody = document.getElementById('orderBody');
    
			// Clear existing rows
			tbody.innerHTML = '';

			// Iterate through the data and append rows to the table
			for (var i = 0; i < data.length; i++) {
				console.log()
				var row = '<tr  width="200" height="200">' +
						  '<td><center><img src="' + data[i].product_image + '" alt="Product Image" width="200" height="200"></center></td>' +
						  '<td width="50%"style="text-align: center; color: black;">' + data[i].product_name + '</td>' +
						  '<td width="20%" style="text-align: center; color: black;">' + data[i].quantity + '</td>' +
						  '</tr>';
				tbody.innerHTML += row;
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error:', textStatus, errorThrown);
		}
    });
}
	
function userPopup(userId) {
	 document.getElementById('userPopup').style.display = 'block';
     document.getElementById('overlay').style.display = 'block';
		
	 $.ajax({
        url: 'fetchOrderUser.php', // Path to your PHP script
        type: 'GET',
		data: { userId: userId },
        dataType: 'json',
        success: function(data) {
            var tbody = document.getElementById('userBody');
    
			// Clear existing rows
			tbody.innerHTML = '';

			// Iterate through the data and append rows to the table
			for (var i = 0; i < data.length; i++) {
				
				var row = '<tr  width="100" height="200">' +
						  '<td width="30%" style="text-align: center; color: black;">'+data[i].fullName+'</td>' +
						  '<td width="30%" style="text-align: center; color: black;">' + data[i].phone + '</td>' +
						  '<td width="20%" style="text-align: center; color: black;">' + data[i].email + '</td>' +
						  '<td width="20%" style="text-align: center; color: black;">' + data[i].address + '</td>' +
						  '</tr>';
				tbody.innerHTML += row;
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error:', textStatus, errorThrown);
		}
    });
}


function closePopup() {
    document.getElementById('popup').style.display = 'none';
	document.getElementById('userPopup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}


</script>
