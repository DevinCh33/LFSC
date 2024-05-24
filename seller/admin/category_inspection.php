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

                <?php
                            session_start(); // temp session
                            error_reporting(1); // hide undefined index errors
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
                $check_cat = mysqli_query($db, "SELECT categories_name FROM categories where categories_name = '".$_POST['c_name']."' ");

                if(mysqli_num_rows($check_cat) > 0)
                {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Category already exists!</strong>
                                </div>';
                }

                else
                {
                    $mql = "INSERT INTO categories(categories_name) VALUES('".$_POST['c_name']."')";
                    mysqli_query($db, $mql);

                }
            }
        }
        ?>

            <!-- Preloader - style you can find in spinners.css -->

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
                    <h4 class="m-b-0 text-white">Add Food Category</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-body">
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="c_name" class="form-control" placeholder="Category Name">
                                        <input type="submit" name="submit" class="btn btn-success" value="Save"> 
                                    </div>
                                </div>
                                <!--/span-->
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
												<th>Action</th>				 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
$sql = "SELECT * FROM categories ORDER BY categories_name DESC";
$query = mysqli_query($db, $sql);


// Loop through categories and display options
if (!mysqli_num_rows($query) > 0) {
    echo '<td colspan="7"><center>No Categories-Data!</center></td>';
} else {				
    while ($rows = mysqli_fetch_array($query)) {   
        echo '<tr>';
        echo '<td>' . $rows['categories_id'] . '</td>';
        echo '<td>' . $rows['categories_name'] . '</td>';
        echo '<td>
                  <a href="#" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10 delete-category" data-category-id="' . $rows['categories_id'] . '">
                      <i class="fa fa-trash-o" style="font-size:16px"></i>
                  </a>
              </td>';
       
        echo '</tr>';  
    }	
}
?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>


                                            

                <!-- End Page Content -->
            </div>
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

<script>
    // JavaScript code to close the error alert when clicking on the close button (X)
    document.addEventListener('DOMContentLoaded', function () {
        const closeButton = document.querySelector('.alert .close');
        if (closeButton) {
            closeButton.addEventListener('click', function () {
                const alertBox = this.parentElement;
                alertBox.style.display = 'none';
            });
        }
    });



    // JavaScript code to handle category deletion
    $(document).ready(function() {
        // Listen for click events on the delete category button
        $('.delete-category').click(function(e) {
            e.preventDefault(); // Prevent default link behavior

            // Get the category ID from the data attribute
            var categoryId = $(this).data('category-id');

            // Confirm the deletion action
            var confirmDelete = confirm("Are you sure you want to delete this category?");

            // If confirmed, redirect to delete_category.php with the category ID
            if (confirmDelete) {
                window.location.href = "action/delete_category.php?cat_del=" + categoryId;
            }
        });
    });

</script>

<?php
// Your PHP code to retrieve categories and display dropdown lists
?>


<script>
    $(document).ready(function() {
        // Event listener for Save button click
        $('.save-category').click(function(e) {
            e.preventDefault(); // Prevent default form submission

            // Get the selected category ID and values
            var categoryId = $(this).data('category-id');
            var activeValue = $(this).closest('tr').find('select[name="categories_active"]').val();
            var statusValue = $(this).closest('tr').find('select[name="categories_status"]').val();

            // Make AJAX request to save the selected options
            $.ajax({
                url: 'action/categories_active.php',
                type: 'POST',
                data: { categoryId: categoryId, activeValue: activeValue, statusValue: statusValue },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>


