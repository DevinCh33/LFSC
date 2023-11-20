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
    <title>Seller Montly Report</title>
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

include("./../connection/connect.php"); // connection to database
	
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
                                <h4 class="card-title">All Seller Details</h4>
                                <div class="table-responsive m-t-40">
									
                                    <table id="example23" class="table table-bordered table-striped">
                                        <thead>
											<tr>
												<th colspan="6" style="border: none">
													<center>
														<select class="select" name="month" id="month" onChange="retakeData()">
															<?php
														
																for ($i = 1; $i <= 12; $i++) {
																	$monthName = strtolower(date("M", mktime(0, 0, 0, $i, 1, date("Y"))));
																	$isSelected = ($i == date("n")) ? 'selected' : '';
																	echo '<option value="' . $i . '" ' . $isSelected . '>' . strtoupper($monthName) . '</option>';
																}
															?>
														</select>
														<select name="year" class="select" id="year" onChange="retakeData()">
															<?php
																for ($i = 2023; $i <= 2060; $i++) {
																	$isSelected = ($i == $currentYear) ? 'selected' : '';
																	echo '<option value="' . $i . '" ' . $isSelected . '>' . $i . '</option>';
																}
															?>
														</select>
													</center>

												</th>
											</tr>
                                            <tr>
											<?php
												if($_SESSION['adm_co'] == 'SUPA'){
											?>
                                                <th>Username</th>
                                                <th>Shop Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
												<th>Address</th>												
												<th>Income (RM)</th>
											<?php
												}
												else if($_SESSION['adm_co'] == 'SUPP'){
											?>
												<th>No</th>
                                                <th>Order Date</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
												<th>Price</th>		
											<?php
												}
											?>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
											<?php
												if($_SESSION['adm_co'] == 'SUPA'){
													$sql = "SELECT admin.*, restaurant.*, SUM(orders.total_amount) AS total 
															FROM admin 
															INNER JOIN restaurant ON admin.store = rs_id 
															LEFT JOIN orders ON admin.store = orders.order_belong 
																AND orders.order_date LIKE '$selectedDate%'
															WHERE admin.code = 'SUPP'
															GROUP BY admin.store
															ORDER BY total DESC";
													$query = $db->query($sql);

													if (!$query->num_rows > 0) {
														echo '<td colspan="7"><center>No Seller-Data!</center></td>';
													} else {
														while ($rows = mysqli_fetch_array($query)) {
															if ($rows['total'] == 0) {
																$rows['total'] = 0;
															}
															echo '<tr>
																	<td>' . $rows['username'] . '</td>
																	<td>' . $rows['title'] . '</td>
																	<td>' . $rows['email'] . '</td>
																	<td>' . $rows['phone'] . '</td>
																	<td>' . $rows['address'] . '</td>
																	<td>' . $rows['total'] . '</td>
																  </tr>';
														}
													}
												}
												else{
													$sql = "SELECT 
																o.order_id, 
																o.order_date, 
																oi.quantity, 
																oi.price, 
																p.product_name 
															FROM orders o
															INNER JOIN order_item oi ON o.order_id = oi.order_id
															INNER JOIN product p ON oi.product_id = p.product_id
															WHERE o.order_date LIKE '$selectedDate%' 
																	AND o.order_status = '3'";
													$query = $db->query($sql);
													$no =1;
													if (!$query->num_rows > 0) {
														echo '<tr><td colspan="5"><center>No Order Record</center></td></tr>';
													} else {
														while ($rows = mysqli_fetch_array($query)) {
															if ($rows['total'] == 0) {
																$rows['total'] = 0;
															}
															echo '<tr>
																	<td>' . $no . '</td>
																	<td>' . $rows['order_date'] . '</td>
																	<td>' . $rows['product_name'] . '</td>
																	<td>' . $rows['quantity'] . '</td>
																	<td>' . $rows['price'] . '</td>
																  </tr>';
															++$no;
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

</body>
</html>

<script>
    function retakeData() {
        var month = ($('#month').val() < 10) ? '0' + $('#month').val() : $('#month').val();
        var date = $('#year').val() + '-' + month;

        // AJAX request to fetch data based on selected date
        $.ajax({
            type: 'POST',
            url: 'fetchReportRec.php', // Replace with the actual URL handling the server-side logic
            data: { date: date },
            success: function(response) {
				console.log(response);
                $('#tableBody').html(response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX error: ' + status, error);
            }
        });
    }

    // Initial load
    $(document).ready(function() {
        retakeData();
    });
</script>
