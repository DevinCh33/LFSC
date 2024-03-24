<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['submit'])) {
    if(empty($_POST['proName']) || empty($_POST['proPrice']) || empty($_POST['proDesc']) || empty($_POST['proPrice']) || empty($_POST['proWeight']) || empty($_POST['proQuan'])) {   
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>All fields Must be Filled Up!</strong></div>';
    } else {
        $imageUpdate = "";
        if(!empty($_FILES['proImg']['name'])) {
            $fname = $_FILES['proImg']['name'];
            $temp = $_FILES['proImg']['tmp_name'];
            $fsize = $_FILES['proImg']['size'];
            $extension = explode('.', $fname);
            $extension = strtolower(end($extension));  
            $fnew = uniqid() . '.' . $extension;
            $store = "../inventory/assets/images/stock/" . basename($fnew); // The path to store the upload image

            if(in_array($extension, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
                if($fsize < 1000000) {
                    move_uploaded_file($temp, $store);
                    $store = "http://localhost/lfsc/inventory/assets/images/stock/" . $fnew;
                    $imageUpdate = ", product_image='" . $store . "'";
                } else {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Max Image Size is 1024kb!</strong> Try a different Image.
                                </div>';
                }
            } else {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Invalid file type!</strong> Only JPG, PNG, and GIF are allowed.
                            </div>';
            }
        }

        // Check if the checkbox is checked
        $activeStatus = isset($_POST['proActive']) ? 1 : 0;

        // Continue with the update if there was no error
        if(empty($error)) {
            $sql = "UPDATE product SET 
                    product_name='" . $_POST['proName'] . "', 
                    categories_id='" . $_POST['proCat'] . "',
                    descr='" . $_POST['proDesc'] . "', 
                    price='" . $_POST['proPrice'] . "', 
                    weight='" . $_POST['proWeight'] . "',
                    quantity='" . $_POST['proQuan'] . "'"
                    . $imageUpdate .
                    ", active='" . $activeStatus . "' 
                    WHERE product_id='" . $_GET['menu_upd'] . "'";

            $result = mysqli_query($db, $sql);

            if($result) {
                $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Record</strong> Updated.
                            </div>';

                header('Location: all_menu.php');
                exit();
            } else {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error updating record.</strong>
                            </div>';
            }
        }
    }
}


?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Update Product</title>
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

<body class="fix-header">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <?php
        include("sidebar.php");
        ?>
        <!-- Page wrapper  -->
        <div class="page-wrapper" style="height:1200px;">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->

                <?php 
                    echo $error;
                    echo $success; ?>
										
					    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Menu to Store</h4>
                            </div>
                            <div class="card-body">
                                <form action='' method='post'  enctype="multipart/form-data">
                                    <div class="form-body">
                                        <?php $qml ="select * from product where product_id='$_GET[menu_upd]'";
													$rest=mysqli_query($db, $qml); 
													$roww=mysqli_fetch_array($rest);
														?>
                                        <hr>
										<div class="row p-t-20" style="height: 200px;">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <center><img src="<?php echo $roww['product_image'] ?>" class="img-responsive  radius" style="max-height:150px;max-width:150px;" /></center>
                                                   </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger"> 
                                                    <label class="switch">
													<input type="checkbox" id="proActive" name="proActive" <?php if($roww['active'] == 1 ) echo 'checked'; ?>>
													  <span class="slider round"></span>
													</label>
                                               	</div>
												<script>
													function statusChange(){
														if($("#proActive").prop("checked"))
															$("#proStatus").val("Active");
														else
															$("#proStatus").val("Inactive");
													}
												</script>
                                            </div>
											<input type="hidden" id="proStatus" name="proStatus">
                                            <!--/span-->
                                        </div>
										
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Product Name</label>
                                                    <input type="text" id="proName" name="proName" value="<?php echo $roww['product_name'];?>" class="form-control" placeholder="Morzirella">
                                                   </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger"> 
                                                  <label class="control-label">Categories</label>
                                                    <select name="proCat" class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="proCat">
														 <?php $ssql ="select * from categories";
														
															$res=mysqli_query($db, $ssql); 
															while($row=mysqli_fetch_array($res))  
															{
															   	echo'<option value="'.$row['categories_id'].'"';
																if($roww['categories_id'] == $row['categories_id'])
																	echo ' selected';
																echo '>'.$row['categories_name'].'</option>';;
															}  

															?> 
													 </select>
                                              </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
										
										<div class="row">
											 <div class="col-md-12">
                                                <div class="form-group" >
                                                    <label class="control-label">Description (MAX 50 Words)</label>
													<textarea style="height: 100px;"  type="text" rows="4" cols="100" name="proDesc" class="form-control" placeholder="Product Description (MAX 50 Words)" id="proDesc"><?php echo $roww['descr'];?></textarea>
                                                </div>
                                            </div>
                                        </div>
										
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Price </label>
                                                    <input name="proPrice" type="text"  class="form-control" id="proPrice" placeholder="$" value="<?php echo $roww['price'];?>">
                                                   </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Image</label>
                                                    <input type="file" name="proImg"  id="proImg" class="form-control form-control-danger" placeholder="12n">
                                                    </div>
                                            </div>
                                        </div>
                                        <!--/row-->
										
										<div class="row p-t-20">
                                            <div class="col-md-6">
                                              <!-- Weight Input Field -->
                                                <div class="form-group">
                                                    <label class="control-label">Weight</label>
                                                    <input type="text" name="proWeight" class="form-control" id="proWeight" placeholder="Enter weight" value="<?php echo $roww['weight']; ?>">
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                              <div class="form-group has-danger">
                                                <label class="control-label">Quantity</label>
                                                  <input type="text" name="proQuan"  id="proQuan" value="<?php echo $roww['quantity'];?>" class="form-control form-control-danger" placeholder="Quantity">
                                                  </div>
                                            </div>
                                        </div>
                                     
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-success" value="Save"> 
                                        <a href="all_menu.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
        
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
