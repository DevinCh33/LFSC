<?php include 'connect.php'; ?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="style.css">
    <!-- Boxiocns CDN Link -->
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
      <span class="text">Dashboard</span>
    </div>
	  <div class="setting-Dash">
		  <div class="panel">
				<form action="php_action/changeUsername.php" method="post" class="form-horizontal" id="changeUsernameForm">
					
					<fieldset class="fieldset">
                            <h3 class="fieldset-title">Contact Info</h3>
                            <div class="form-group">
                                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Email</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="email" class="form-control" value="Rebecca@website.com">
                                    <p class="help-block">This is the email </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Twitter</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" value="SpeedyBecky">
                                    <p class="help-block">Your twitter username</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2  col-sm-3 col-xs-12 control-label">Linkedin</label>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <input type="url" class="form-control" value="https://www.linkedin.com/in/lorem">
                                    <p class="help-block">eg. https://www.linkedin.com/in/yourname</p>
                                </div>
                            </div>
                        </fieldset>
				</form>

				<form action="php_action/changePassword.php" method="post" class="form-horizontal" id="changePasswordForm">
					<fieldset>
						<legend>Change Password</legend>

						<div class="changePasswordMessages"></div>

						<div class="form-group">
							<div class="label">
								<label for="npassword" class="control-label">Current Password</label>
							  </div>
							  <div class="textfield">
								<input type="password" class="form-control" id="password" name="password" placeholder="Current Password">
							  </div>
					  	</div>

					  <div class="form-group">
						  <div class="label">
						  	<label for="npassword" class="control-label">New password</label>
						  </div>
						  <div class="textfield">
						  	<input type="password" class="form-control" id="npassword" name="npassword" placeholder="New Password">
						  </div>
					  </div>

					  <div class="form-group">
						  <div class="label">
						  	<label for="npassword" class="control-label">Confirm Password</label>
						  </div>
						  <div class="textfield">
						  	<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
						  </div>		  
					  </div>

					  	<div class="form-group" >
					    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['adm_id'] ?>" /> 
					      <button type="submit" class="save-button"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
					 	</div>


					</fieldset>
				</form>

			</div> <!-- /panel-body -->	
	  	</div>
	  
  </section>
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
   arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
	  let logoImage = document.getElementById("logo");
	  let logoName = document.getElementById("logo_name");
  	logoName.hidden = true;
	  let initialSize = { width: 80, height: 80 };
	  logoImage.width = initialSize.width;
	  logoImage.height = initialSize.height;
	  // Hide the logo name initially
  logoName.style.opacity = 0;

  // Function to show the logo name with a delay
  function showLogoName() {
    logoName.style.opacity = 1;
  }
	  
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
	  if (sidebar.classList.contains("close")) {
      // Sidebar is closed
      logoImage.width = initialSize.width;
      logoImage.height = initialSize.height;
      logoName.hidden = true;
    } else {
      // Sidebar is open
      // Adjust the logo size as needed
      logoImage.width = 120; // Increase the width to 120 when the sidebar is open
      logoImage.height = 120; // Increase the height to 120 when the sidebar is open
      logoName.hidden = false;
		setTimeout(showLogoName, 200);
    }
  });
  </script>
  
</body>
</html>