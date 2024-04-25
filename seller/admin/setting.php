<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
      <span class="text">Dashboard</span>
    </div>
	<div class="setting-Dash">
		<div class="setting">
  <div class="container">
    <div class="view-account">
        <section class="module">
            <div class="module-inner">
                <div class="content-panel">
                    <form class="form-horizontal" action="action/updateAdminProfile.php" method="POST">
                        <fieldset class="fieldset">
                            <h3 class="fieldset-title">Personal Info</h3> 
							
                            <div class="form-group">
                                <label class="label">User Name</label>
                                <div class="textfield">
                                    <input type="text" class="form-control" id="ownerUser" name="ownerUser">
									<span id="alertUsername" class="alertCSS"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Name</label>
                                <div class="textfield">
                                    <input type="text" class="form-control" id="ownerName" name="ownerName">
									<span id="alertname" class="alertCSS"></span>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">Email</label>
                                <div class="textfield">
                                    <input type="email" class="form-control" id="ownerEmail" name="ownerEmail">
									<span id="alertEmail" class="alertCSS"></span>                               
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">Phone Number</label>
                                <div class="textfield">
                                    <input type="text" class="form-control" id="ownerNumber" name="ownerNumber">
									<span id="alertNumber" class="alertCSS"></span>                               
                                </div>
                            </div>
                        </fieldset>
						
                        <div class="form-group">
                            <div class="updateButtonBox">
                                <input class="updateButton" type="button" value="Update Profile" onClick="updateProfile(this)">
                            </div>
                        </div>
						</form>
						<hr>
					
						<form class="form-horizontal" action="action/updatePass.php" method="GET">
						<fieldset class="fieldset">
							
                            <h3 class="fieldset-title">Security</h3>
                            <div class="form-group">
                                <label class="label">Old Password</label>
                                <div class="textfield">
                                    <input type="password" class="form-control" id="oldPass">
                               		<div id="passAlert0" class="alertCSS"></div>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">New Password</label>
                                <div class="textfield">
                                    <input type="password" class="form-control" id="newPass" name="newPass" onKeyUp="checkPass()">
                               		<div id="passAlert1" class="alertCSS"></div>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">Confirm Password</label>
                                <div class="textfield">
                                    <input type="password" class="form-control" onKeyUp="checkPass()" id="conPass">
                               		<div id="passAlert2" class="alertCSS"></div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <div class="updateButtonBox">
                                <input class="updateButton" type="button" value="Update Password" onClick="updatePass(this)">
                            </div>
                        </div>
                    </form>
					
                </div>
            </div>
        </section>
    </div>
</div>
	</div>
	</div>
	  
  </section>
  
</body>
</html>
<script src="scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
	fetchData();
});
	
function updateProfile(button){
	var username = $('#ownerUser').val();
	var admname = $('#ownerName').val();
	var email = $('#ownerEmail').val();
	var contact = $('#ownerNumber').val();
	var form = $(button).closest('form');
	
	var error = 0;
	
	if(username == ""){
		$('#alertUsername').text("Text field must not be empty")
		error += 1;
	}
	else if(username.length < 5 && username != ""){
		$('#alertUsername').text("Username must at least 5 characters")
		error += 1;
	}
	else
		$('#alertUsername').text("");
	
	if(admname == "" ){
		$('#alertname').text("Text field must not be empty")
		error += 1;
	}
	else
		$('#alertname').text("");
	if(email == ""){
		$('#alertEmail').text("Text field must not be empty")
		error += 1;
	}
	else{
		var malaysiaEmailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
		if(!malaysiaEmailRegex.test(email)) {
			$('#alertEmail').text("Email format error. Example: example123@example.com");
			error += 1;
		} else {
			$('#alertEmail').text(""); // Clear error message
		}
	}
		
	
	if(contact == ""){
		$('#alertNumber').text("Text field must not be empty")
		error += 1;
	}else {
		var malaysiaNumberRegex = /^0\d{9,10}$/;
    
		if (!malaysiaNumberRegex.test(contact)) {
			$('#alertNumber').text("Contact number must start with 0 and have 10 or 11 digits");
			error += 1;
		} else {
			$('#alertNumber').text(""); // Clear error message
		}
	}
	console.log(error);
	if(error == 0){
		console.log(form.serialize());
		$.ajax({
        url: form.attr("action"), // The script to call to add data
        type: form.attr("method"),
        data: form.serialize(),
        success: function(response) {
            alert(response);
        },
        error: function(xhr, status, error) {
            
        }
    });
	}
}

function checkOldPass(pass, callback) {
    $.ajax({
        url: "action/checkOldPass.php",
        type: "GET",
        data: { pass: pass },
        success: function(response) {
            callback(response); // Pass the response to the callback function
        },
        error: function(xhr, status, error) {
            console.error("Error checking old password:", error);
            callback(null); // Pass null to indicate error to the callback function
        }
    });
}
	
function updatePass(button) {
    var pass0 = $("#oldPass").val();
    var pass1 = $("#newPass").val();
    var pass2 = $("#conPass").val();
    var error = 0;
    var form = $(button).closest('form');
	var validate = "";
	
	if (pass0 == "") {
		$("#passAlert0").text("Password field must not be empty");
		error += 1;
	}  else {
		$("#passAlert0").text("");
		checkOldPass(pass0, function(result) {
			if (result !== null) {
				if (result == 1) {
					if (error == 0) {
						$.ajax({
							url: form.attr("action"), // The script to call to add data
							type: form.attr("method"),
							data: form.serialize(),
							success: function(response) {
								alert(response);
								form[0].reset();
							},
							error: function(xhr, status, error) {
								// Handle any errors that occur during the AJAX request
							}
						});
					}
				} else {
					$("#passAlert0").text("Old Password Not Match");
					error += 1;
				}
			} else {
				console.log("Error occurred while checking old password.");
			}
		});  
	}
	
    if (pass1 == "") {
		$("#passAlert1").text("Password field must not be empty");
		error += 1;
	} else if (pass1.length < 6) {
		$("#passAlert1").text("Password must be at least 6 characters long");
		error += 1;
	} else {
		$("#passAlert1").text("");
	}
	
	if (pass2 == "") {
		$("#passAlert2").text("Password field must not be empty");
		error += 1;
	} else if (pass2.length < 6) {
		$("#passAlert2").text("Password must be at least 6 characters long");
		error += 1;
	} else {
		$("#passAlert2").text("");
	}
}
	

function checkPass(){
	if($("#conPass").val() !== $("#newPass").val()){
		$("#passAlert2").show();
		$("#passAlert2").text("Password Not Match with New Password");
	}
	else{
		$("#passAlert2").text("");
		
	}
}

function fetchData() {
	var userid = <?php echo $_SESSION['adm_id']; ?>;
    $.ajax({
        url: 'action/fetchAdminData.php',
        type: 'GET',
		data:{userId: userid},
        dataType: 'json',
        success: function(response) {
			$('#ownerUser').val(response.username);
			$('#ownerName').val(response.adm_name);
			$('#ownerNumber').val(response.phone);
			$('#ownerEmail').val(response.email);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
	
function openPopup() {
    document.getElementById("popupWindow").style.display = "block";
	$('#cardVerify').show();
	
}
	

	  
 
  </script>