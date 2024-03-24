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

if(isset($_SESSION["adm_co"]))
{

if(isset($_POST['submit'])) //if upload btn was pressed
{
    if(empty($_POST['c_name'])||empty($_POST['res_name'])||$_POST['email']==''||$_POST['phone']=='' || $_POST['address']=='')
    {	
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>All <a style="color: red">*</a> fields are required!</strong>
                    </div>';           
    }

	else
	{
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = explode('.',$fname);
        $extension = strtolower(end($extension));  
        $fnew = uniqid().'.'.$extension;
        $store = "Res_img/".basename($fnew); // the path to store the upload image

        if($extension == 'jpg'||$extension == 'png'||$extension == 'gif' )
        {        
            if($fsize>=1000000)
            {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Max image size is 1024kb!</strong> Try different image!
                        </div>';
            }

            else
            {
                $res_name = $_POST['res_name'];
                $sql = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'store' AND TABLE_NAME = 'restaurant';";  // get next id
                $res = mysqli_query($db, $sql);
                $row = mysqli_fetch_array($res);
                $id = $row['AUTO_INCREMENT'];

                $sql1 = "INSERT INTO restaurant(rs_id,c_id,title,email,phone,url,o_hr,c_hr,o_days,description,address,image) VALUE('".$id."','".$_POST['c_name']."','".$res_name."','".$_POST['email']."','".$_POST['phone']."','".$_POST['url']."','".$_POST['o_hr']."','".$_POST['c_hr']."','".$_POST['o_days']."','".$_POST['description']."','".$_POST['address']."','".$fnew."')";  // store the submited data ino the database :images
                mysqli_query($db, $sql1);
                move_uploaded_file($temp, $store);

                $success = '<div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Congrats!</strong> New store added successfully!
                            </div>';

                $sql2 = "UPDATE admin SET store = ".$id." WHERE adm_id = ".$_SESSION['adm_id'];  // set store id
                mysqli_query($db, $sql2);

                $_SESSION['store'] = $id;
            }
        }

        elseif($extension == '')
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Select image!</strong>
                        </div>';
        }

        else
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Invalid extension!</strong> Only .png, .jpg, .gif are accepted.
                        </div>';
            }               
	   }
}
?>

<body class="fix-header">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
		</svg>
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
                <?php 
                    echo $error;
                    echo $success; ?>
									
				<div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Store</h4>
                            </div>
                            <div class="card-body">
                                <form action='' method='post'  enctype="multipart/form-data">
                                    <div class="form-body">
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Store Name <a style="color: red">*</a></label>
                                                    <input type="text" name="res_name" class="form-control" placeholder="New Store">
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Business Email <a style="color: red">*</a></label>
                                                    <input type="text" name="email" class="form-control form-control-danger" placeholder="example@gmail.com">
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Phone <a style="color: red">*</a></label>
                                                    <input type="text" name="phone" class="form-control" placeholder="1-(555)-555-5555">
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Website URL</label>
                                                    <input type="text" name="url" class="form-control form-control-danger" placeholder="http://example.com">
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Open Hours</label>
                                                    <select name="o_hr" class="form-control custom-select" data-placeholder="Choose a Category" >
                                                        <option>--Select your Hours--</option>
                                                        <option value="6am">6am</option>
                                                        <option value="7am">7am</option> 
                                                        <option value="8am">8am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="11am">11am</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Close Hours</label>
                                                    <select name="c_hr" class="form-control custom-select" data-placeholder="Choose a Category" >
                                                        <option>--Select your Hours--</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="4pm">4pm</option> 
                                                        <option value="5pm">5pm</option>
                                                        <option value="6pm">6pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="8pm">8pm</option>
                                                    </select>
                                                </div>
                                            </div>
											
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Open Days</label>
                                                    <select name="o_days" class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
                                                        <option>--Select your Days--</option>
                                                        <option value="mon-tue">mon-tue</option>
                                                        <option value="mon-wed">mon-wed</option> 
                                                        <option value="mon-thu">mon-thu</option>
                                                        <option value="mon-fri">mon-fri</option>
                                                        <option value="mon-sat">mon-sat</option>
                                                        <option value="24hr-x7">24hr-x7</option>
                                                    </select>
                                                </div>
                                            </div>
											
											<div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Image <a style="color: red">*</a></label>
                                                    <input type="file" name="file"  id="lastName" class="form-control form-control-danger" placeholder="12n">
                                                </div>
                                            </div>
                                            <!--/span-->

											<div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Category <a style="color: red">*</a></label>
													<select name="c_name" class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
                                                        <option>--Select Category--</option>
                                                        <?php $ssql ="select * from res_category";
                                                        $res=mysqli_query($db, $ssql); 
                                                        while($row=mysqli_fetch_array($res))  
                                                        {
                                                            echo' <option value="'.$row['c_id'].'">'.$row['c_name'].'</option>';;
                                                        }  
                                                        
                                                        ?> 
													</select>
                                                </div>
                                            </div>
                                        </div>

                                                                                <!--/row-->
                                        <h3 class="box-title m-t-40">Description</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="form-group">
                                                    <textarea name="description" type="text" style="height:100px;" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <!--/span-->

                                        <!--/row-->
                                        <h3 class="box-title m-t-40">Store Address <a style="color: red">*</a></h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="form-group">
                                                    <textarea name="address" type="text" style="height:100px;" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <!--/span-->
                                    </div>
                                    
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-success" value="Save"> 
                                        <a href="dashboard.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Page Content -->
            </div>                                     
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    
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
<?php
}

else
{
    header('location:index.php');
}
?>
</body>
</html>
