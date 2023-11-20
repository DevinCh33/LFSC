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
    <link rel="icon" type="image/png" sizes="16x16" href="./../landing/logo.png">
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

<body class="fix-header fix-sidebar">
<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("./../connection/connect.php"); // connection to database


if (isset($_SESSION['adm_id']))
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
                                <h4 class="card-title">All Registered Users</h4>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>First-Name</th>
                                                <th>Last-Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
												<th>Address</th>
											<?php
												if($_SESSION['adm_co'] == "SUPA"){	
											?>
												<th>Reg-Date</th>
												<th>Action</th>
											<?php
												}
											?>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											if($_SESSION['adm_co'] == "SUPA")
												$sql = "SELECT * FROM users WHERE status < 3 ORDER BY status";
											else
												$sql = "SELECT DISTINCT user_id FROM orders WHERE status < 3 AND order_status != 4 AND order_belong = '".$_SESSION['store']."' ORDER BY order_status DESC";
											
												$query = $db->query($sql);
												
                                                if(!$query->num_rows > 0 )
                                                {
													if($_SESSION['adm_co'] == "SUPA")
                                                    	echo '<td colspan="8"><center>No User-Data!</center></td>';
													else
														echo '<td colspan="6"><center>No User-Data!</center></td>';
                                                }
													
                                                else
                                                {				
                                                    while($rows=mysqli_fetch_array($query))
                                                    {
														if($_SESSION['adm_co'] == "SUPA"){
															echo ' <tr><td>'.$rows['username'].'</td>
																		<td>'.$rows['f_name'].'</td>
																		<td>'.$rows['l_name'].'</td>
																		<td>'.$rows['email'].'</td>
																		<td>'.$rows['phone'].'</td>
																		<td>'.$rows['address'].'</td>	
																		<td>'.$rows['date'].'</td>
																		<td><a href="delete_users.php?user_del='.$rows['u_id'].'" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
																		<a href="update_users.php?user_upd='.$rows['u_id'].'" " class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="ti-settings"></i></a>
																		</td></tr>';
														}
														else{
															$fetchUser = "SELECT * FROM users WHERE u_id = '".$rows['user_id']."'";
															$fetchRec = $db->query($fetchUser);
															$rec = $fetchRec->fetch_array();
															echo ' <tr><td>'.$rec['username'].'</td>
																		<td>'.$rec['f_name'].'</td>
																		<td>'.$rec['l_name'].'</td>
																		<td>'.$rec['email'].'</td>
																		<td>'.$rec['phone'].'</td>
																		<td>'.$rec['address'].'</td></tr>';
														}
														
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
            </div>
        </div>
    </div>
    <!-- End Page Content -->
    <!-- End Container fluid  -->
    <!-- End footer -->

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
