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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript">
var popUpWin=0;

function popUpWindow(URLStr, left, top, width, height)
{
    if(popUpWin)
    {
        if(!popUpWin.closed) popUpWin.close();
    }

    popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+800+',height='+800+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

function handleMessage(event) 
{
    if (event.data === 'formSubmitted') 
    {
        location.reload(); // Refresh page
    }
}

window.addEventListener('message', handleMessage);
</script>
</head>

<body class="fix-header fix-sidebar">
<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("./../connection/connect.php"); // connection to database

if(isset($_SESSION["adm_id"]))
{
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
                                <h4 class="card-title">View User Orders</h4>
                             
                                <div class="table-responsive m-t-20">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <tbody>
                                           <?php
												$sql = "SELECT orders.*, order_item.*, product.product_name, restaurant.*, users.*
														FROM orders
														JOIN order_item ON orders.order_id = order_item.order_id
														JOIN users ON orders.user_id = users.u_id
														JOIN product ON order_item.product_id = product.product_id
														JOIN restaurant ON product.owner = restaurant.rs_id 
														WHERE orders.order_id = '".$_GET['order_upd']."'";
	
												$query = mysqli_query($db,$sql);
												$rows = mysqli_fetch_array($query);						
											?>
											
											<tr>
                                                <td><strong>Username:</strong></td>
                                                <td><center><?php echo $rows['username']; ?></center></td>
                                                <td><center>
                                                    <a href="javascript:void(0);" onClick="popUpWindow('order_update.php?form_id=<?php echo htmlentities($rows['order_id']);?>');" title="Update order">
                                                    <button type="button" class="btn btn-primary">Take Action</button></a>
                                                    </center></td>																									
											</tr>	
											<tr>
												<td><strong>Name:</strong></td>
                                                <td><center><?php echo $rows['fullName']; ?></center></td>
                                                <td><center>
                                                    <a href="javascript:void(0);" onClick="popUpWindow('userprofile.php?newform_id=<?php echo htmlentities($rows['order_id']);?>');" title="Update order">
                                                    <button type="button" class="btn btn-primary">View User Detials</button></a>
                                                </center></td>   																								
											</tr>	
											<tr>
												<td><strong>Quantity:</strong></td>
												<td><center><?php echo $rows['quantity']; ?></center></td>     																							
											</tr>
											<tr>
                                                <td><strong>Price:</strong></td>
                                                <td><center>RM <?php echo $rows['price']; ?></center></td>																							
											</tr>
											<tr>
                                                <td><strong>Address:</strong></td>
                                                <td><center><?php echo $rows['address']; ?></center></td>																						
											</tr>
											<tr>
                                                <td><strong>Date:</strong></td>
                                                <td><center><?php echo $rows['date']; ?></center></td>  																							
											</tr>
											<tr>
                                                <td><strong>Status:</strong></td>
                                                <?php 
                                                    $status=$rows['order_status'];
                                                    if($status=="1" )
                                                    {
                                                ?>
                                                <td><center><button type="button" class="btn btn-info" style="font-weight:bold;"><span class="fa fa-bars"  aria-hidden="true">Processing</button></center></td>
                                                <?php 
                                                    }
                                                    if($status=="2")
                                                    { 
                                                ?>
                                                <td><center><button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"  aria-hidden="true"></span>On the Way!</button></center></td> 
                                                <?php
                                                    }
                                                    if($status=="3")
                                                    {
                                                ?>
                                                <td><center><button type="button" class="btn btn-success" ><span  class="fa fa-check-circle" aria-hidden="true">Delivered</button></center></td> 
                                                <?php 
                                                    } 
                                                ?>
                                                <?php
                                                    if($status=="4")
                                                    {
                                                ?>
                                                <td><center><button type="button" class="btn btn-danger"> <i class="fa fa-close"></i>Cancelled</button> </center></td> 
                                                <?php 
                                                    } 
                                                ?>                                                                                    
											</tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Page Content -->
            </div>
            <!-- End Container fluid  -->

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
