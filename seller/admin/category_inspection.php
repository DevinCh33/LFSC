<?php include 'connect.php'; ?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="style.css">
    <!-- Boxiocns CDN Link -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
	
<body>
  <div class="sidebar close">
    <?php include "sidebar.php"; ?>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Products</span>
    </div>
	  
	<div class="empMainCon">

		   	<div class="controls-container">
		  		<div class="records-per-page">
					<span>Records per page:</span>
					<select id="recordsPerPage" onchange="changeRecordsPerPage()" class="custom-select">
					  <option value="5">5</option>
					  <option value="10">10</option>
					  <option value="50">50</option>
					</select>
				  </div>

				  <div class="search-bar">
				<span>Search:</span>
				<input type="text" id="searchInput" onkeyup="fetchData()" placeholder="Search for names..">
		  	</div>
		  </div>


          <?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("./../connection/connect.php"); // connection to database

if(isset($_SESSION["adm_co"]) && ($_SESSION["adm_co"] == "SUPA"))
{

if(isset($_POST['submit'] ))
{
    if(empty($_POST['c_name']))
    {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>All fields required!</strong>
                    </div>';
    }

	else
	{	
	    $check_cat = mysqli_query($db, "SELECT c_name FROM res_category where c_name = '".$_POST['c_name']."' ");

        if(mysqli_num_rows($check_cat) > 0)
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Category already exists!</strong>
                        </div>';
        }

        else
        {
            $mql = "INSERT INTO res_category(c_name) VALUES('".$_POST['c_name']."')";
            mysqli_query($db, $mql);
            $success = 	'<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Congrats!</strong> New category added successfully!</br>
                        </div>';
        }
	}
}
?>

    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">


            <!-- Bread crumb -->
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
				<div class="row">
                    <div class="container-fluid">
                    <!-- Start Page Content -->
                        <?php  
                            echo $error;
                            echo $success; ?>	

                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Add Store Category</h4>
                                </div>
                                <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="categoryId" value="<?php echo $categoryId; ?>">
    <div class="form-body">
        <hr>
        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Category</label>
                    <input type="text" name="newName" class="form-control" value="<?php echo $categoryName; ?>" placeholder="New Category Name">
                </div>
            </div>
            <!--/span-->
        </div>
        <div class="form-actions">
            <input type="submit" name="submit" class="btn btn-success" value="Update"> 
            <a href="dashboard.php" class="btn btn-inverse">Cancel</a>
        </div>
    </div>
</form>

                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Listed Categories</h4>
                             
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID#</th>
                                                <th>Category Name</th>
                                                <th>Date</th>
												<th>Action</th>		 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql = "SELECT * FROM res_category order by c_id desc";
                                        $query = mysqli_query($db,$sql);
                                        
                                        if(!mysqli_num_rows($query) > 0 )
                                        {
                                            echo '<td colspan="7"><center>No Categories-Data!</center></td>';
                                        }

                                        else
                                        {				
                                            while($rows=mysqli_fetch_array($query))
                                            {   
                                                echo ' <tr><td>'.$rows['c_id'].'</td>
                                                            <td>'.$rows['c_name'].'</td>
                                                            <td>'.$rows['date'].'</td>
                                                            <td><a href="action/delete_category.php?cat_del='.$rows['c_id'].'" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
                                                            <a href="action/update_category.php?cat_upd='.$rows['c_id'].'" " class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="ti-settings"></i></a>
                                                            </td></tr>';  
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
                <!-- End Page Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. </footer>
            <!-- End footer -->

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
    <script src="scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
}
?>
  






</body>
</html>
