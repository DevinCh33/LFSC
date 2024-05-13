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
                            <h3 class="fieldset-title">Shop Info 
								<?php
								
								if($_SESSION['status'] == 0){
								?>
									<input type="button" class="btnVerify" onclick="openPopup()" value="* Verify Now">
								<?php
								}
								else{
									?>
									<i class="fa-solid fa-circle-check" onclick="openPopup()" style="margin-left: 10px;"></i>
								<?php
								}
								?>
							</h3>
                            <div class="form-group">
                                <label class="label">Shop Title</label>
                                <div class="textfield">
                                    <input type="text" class="form-control" id="shopTitle" name="shopTitle">
                               		<span id="alertTitle" class="alertCSS"></span>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">Email</label>
                                <div class="textfield">
                                    <input type="email" class="form-control" id="shopEmail" name="shopEmail">
                               		<span id="alertSEmail" class="alertCSS"></span>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">Phone Number</label>
                                <div class="textfield">
                                    <input type="text" class="form-control" id="shopNumber" name="shopNumber">
                               		<span id="alertSNum" class="alertCSS"></span>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">Description</label>
                                <div class="textfield">
                                    <textarea class="form-control" rows="5" id="shopDescr" name="shopDescr"></textarea>
                               		<span id="alertSDescr" class="alertCSS"></span>
                                </div>
                            </div>
                            
    





                        </fieldset>
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
                               		<div id="passAlert0" class="passAlert"></div>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">New Password</label>
                                <div class="textfield">
                                    <input type="password" class="form-control" id="newPass" onKeyUp="checkPass()">
                               		<div id="passAlert1" class="passAlert"></div>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="label">Confirm Password</label>
                                <div class="textfield">
                                    <input type="password" class="form-control" onKeyUp="checkPass()" id="conPass">
                               		<div id="passAlert2" class="passAlert"></div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <div class="updateButtonBox">
                                <input class="updateButton" type="button" value="Update Password" onClick="updatePass()">
                            </div>
                        </div>
                    </form>
					
					
					<div id="popupWindow" class="popup">
    					<div class="popup-content">
							<div class="xclose">
								<span class="close" onclick="closePopup()">&times;</span>
							</div>
							<div id="cardVerify">
								<form action="action/sellerVerify.php"  method="POST" class="myform" name="myForm" id="myForm" enctype="multipart/form-data">
									<div class="myform-row">
										<div id="divalert" class="divalert" name="divalert"></div>
									</div>
									<div class="myform-row">
										<div class="label">
											<label for="frontID" class="myform-label">Front ID Card</label>
										</div>
										<div class="input">
											<input type="file" onchange="validateImage()" id="frontID" name="frontID" class="myform-input" required>
											<div id="imageAlert0"></div>
										</div>
									</div>
									<div class="myform-row">
										<div class="label">
											<label for="backID" class="myform-label">Back ID Card</label>
										</div>
										<div class="input">
											<input type="file" id="backID" name="backID" class="myform-input" required>
											<div id="imageAlert1"></div>
										</div>
									</div>
									<div class="myform-row">
										<div class="label">
											<label for="IDwithFace" class="myform-label">ID Card with Face</label>
										</div>
										<div class="input">
											<input type="file" id="IDwithFace" name="IDwithFace" class="myform-input" required>
											<div id="imageAlert2"></div>
										</div>
									</div>
									<div style="text-align: center;">
										<input type="button" id="subDoc" class="button" value="Submit Document" onClick="submitDoc()">
									</div>
									
								</form>
								<div id="validationHistory" style="margin-top: 20px; width: 90%; margin-left: auto; margin-right: auto; text-align: center;">
									<h1>History Of Validating</h1>
									<table id="validationTable" style="width: 100%; border-collapse: collapse; border-top: 2px solid black;border-bottom: 2px solid black;">
										<thead>
											<tr>
												<th>No#</th>
												<th>Status</th>
												<th>Reason</th>
											</tr>
										</thead>
										<tbody style="border-collapse: collapse; border-bottom: 2px solid black;">
											<!-- Validation history rows will be displayed here -->
										</tbody>
									</table>
								</div>



							</div>
    					</div>
					</div>
					
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
	
function retrieveRec() {
    $.ajax({
        url: "action/retrieveValidate.php",
        type: "GET",
        data: { admID: "<?php echo $_SESSION['adm_id']; ?>" },
        success: function(response) {
            var data = JSON.parse(response);
			

            var tbody = $('#validationTable tbody');

			// Clear existing rows
			tbody.empty();

			// Populate tbody with data
			for (var i = 0; i < data.length; i++) {
				var statusColor;
				var statusText;
				if (data[i].imgStatus == 1) {
					statusText = "Under validation";
					statusColor = "blue";
				} else if (data[i].imgStatus == 2) {
					statusText = "Rejected";
					statusColor = "red";
				} else if (data[i].imgStatus == 3) {
					statusText = "Successfully validated";
					statusColor = "green";
				}

				// Append row to tbody with inline styles for background color
				tbody.append('<tr><td>' + (i + 1) + '</td><td style="color: ' + statusColor + ';">' + statusText + '</td><td>' + data[i].imgComment + '</td></tr>');
			}

			// Apply inline CSS to remove border from tbody
			tbody.css('border', 'none');

        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

	
function submitDoc() {
    // Get the input elements for the front ID, back ID, and ID with face images
    var frontIDInput = document.getElementById('frontID');
    var backIDInput = document.getElementById('backID');
    var IDwithFaceInput = document.getElementById('IDwithFace');

    // Create a FormData object to store the files
    var formData = new FormData();

    // Add the files to the FormData object
    formData.append('frontID', frontIDInput.files[0]);
    formData.append('backID', backIDInput.files[0]);
    formData.append('IDwithFace', IDwithFaceInput.files[0]);

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Set up the request
    xhr.open('POST', 'action/sellerVerify.php', true);

    // Set up a function to handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Request was successful, handle the response here if needed
            alert(xhr.responseText);
			
        } else {
            // Request failed
            console.error('Request failed with status:', xhr.status);
        }
    };

    // Set up a function to handle any errors
    xhr.onerror = function() {
        console.error('Request failed');
    };

    // Send the request with the FormData containing the images
    xhr.send(formData);
}

	
function updatePass() {
    var pass = $("#oldPass").val();

    $.ajax({
        url: "action/checkOldPass.php", // The script to call to add data
        type: "GET",
        data: { admID: "<?php echo $_SESSION['adm_id']; ?>", pass:pass },
        success: function(response) {
            if (response == 1) {
                $("#passAlert0").hide();
				if($("#conPass").val() === "" || $("#newPass").val() === "" ){
					if($("#newPass").val() === "")
						$("#passAlert1").text("This Text Field Must Not Empty");
					else
						$("#passAlert1").hide();
					if($("#conPass").val() === "")
						$("#passAlert2").text("This Text Field Must Not Empty");
					else
						$("#passAlert2").hide();
				}
				else{
					$("#passAlert1").hide();
					$("#passAlert2").hide();
					
					if($("#conPass").val() == $("#newPass").val()){
						$.ajax({
						url: "action/updatePass.php", // The script to call to add data
						type: "GET",
						data: { admID: "<?php echo $_SESSION['adm_id']; ?>", newpass:$("#newPass").val() },
						success: function(response) {
							console.log(response);
							if(response){
								alert("Password Changed Successfully!");
								$("#oldPass").text("");
								$("#newPass").text("");
								$("#conPass").text("");
							}
							else{
								alert("Password Changed Failed!");
							}
						},
						error: function(xhr, status, error) {
            
						}
						})
					}
						
				}
			
            } else {
                $("#passAlert0").text("Old Password Not Match");
				
            }
        },
        error: function(xhr, status, error) {
            
        }
    });
}
	

function checkPass(){
	if($("#conPass").val() !== $("#newPass").val()){
		$("#passAlert2").show();
		$("#passAlert2").text("Password Not Match with New Password");
	}
	else{
		$("#passAlert2").hide();
		
	}
}
	
function validateImage() {
    var fileInput = document.getElementById('frontID');
    var filePath = fileInput.value;
    // Get the file extension
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
	// Get the file size
    var fileSize = fileInput.files[0].size;
	
    if (!allowedExtensions.exec(filePath)) {
        fileInput.value = '';
		$("#imageAlert").text("Please upload file having extensions .jpeg/.jpg/.png/.gif only.");
        return false;
		
    }
	else{
		$("#imageAlert").hide();
		if (fileSize > 10 * 1024 * 1024) {
			fileInput.value = '';
			$("#imageAlert").text("File size should not exceed 5MB.");
			return false;
		}
		else{
			$("#imageAlert").hide();
			return true;
		}
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
			console.log(response);
			$('#shopTitle').val(response.r_title);
			$('#shopEmail').val(response.r_email);
			$('#shopNumber').val(response.r_phone);
			$('#shopDescr').text(response.r_desc);
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
	retrieveRec();
}
	
function updateProfile(button){
	var shopTitle = $('#shopTitle').val();
	var shopEmail = $('#shopEmail').val();
	var shopNumber = $('#shopNumber').val();
	var shopDescr = $('#shopDescr').val();
	var username = $('#ownerUser').val();
	var admname = $('#ownerName').val();
	var email = $('#ownerEmail').val();
	var contact = $('#ownerNumber').val();
	var form = $(button).closest('form');
	
	var error = 0;
	
	if(shopTitle == ""){
		$('#alertTitle').text("Text field must not be empty")
		error += 1;
	}
	else
		$('#alertTitle').text("");
	
	if(shopDescr == "" ){
		$('#alertSDescr').text("Text field must not be empty")
		error += 1;
	}
	else
		$('#alertSDescr').text("");
	
	if(shopEmail == ""){
		$('#alertSEmail').text("Text field must not be empty")
		error += 1;
	}
	else{
		var malaysiaEmailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
		if(!malaysiaEmailRegex.test(shopEmail)) {
			$('#alertSEmail').text("Email format error. Example: example123@example.com");
			error += 1;
		} else {
			$('#alertSEmail').text(""); // Clear error message
		}
	}
		
	
	if(shopNumber == ""){
		$('#alertSNum').text("Text field must not be empty")
		error += 1;
	}else {
		var malaysiaNumberRegex = /^0\d{9,10}$/;
    
		if (!malaysiaNumberRegex.test(shopNumber)) {
			$('#alertSNum').text("Contact number must start with 0 and have 10 or 11 digits");
			error += 1;
		} else {
			$('#alertSNum').text(""); // Clear error message
		}
	}
	
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


// JavaScript
function updateBoxes() {
    var select = document.getElementById("shopCategorySelect");
    var selectedOptions = document.getElementById("optionContainer");
    selectedOptions.innerHTML = '';

    var options = select.options;
    for (var i = 0; i < options.length; i++) {
        var option = options[i];
        if (option.selected) {
            var optionDiv = document.createElement("div");
            optionDiv.classList.add("option");
            optionDiv.textContent = option.value;
            optionDiv.setAttribute("data-value", option.value);
            optionDiv.onclick = function() {
                this.parentNode.removeChild(this);
                select.querySelector('option[value="' + this.getAttribute("data-value") + '"]').removeAttribute('disabled');
            };
            selectedOptions.appendChild(optionDiv);
            option.disabled = true;
        }
    }
}


/*
function updateTextBox() {
        var selectElement = document.getElementById("shopCategorySelect");
        var selectedOptions = document.getElementById("selectedCategories");
        
        var selectedCategory = selectElement.options[selectElement.selectedIndex].text;
        
        if (selectedOptions.value.trim() === "") {
            selectedOptions.value = selectedCategory;
        } else {
            selectedOptions.value += ", " + selectedCategory;
        }
        
        // Adjust the height of the textarea
        selectedOptions.style.height = selectedOptions.scrollHeight + "px";
    }
    
    function removeCategory(event) {
        var selectedOptions = document.getElementById("selectedCategories");
        var clickedCategory = event.target.value;
        var currentText = selectedOptions.value;
        
        // Remove clicked category from text box
        var updatedText = currentText.replace(clickedCategory, "").replace(", , ", ", ");
        selectedOptions.value = updatedText.trim();
        
        // Adjust the height of the textarea
        selectedOptions.style.height = selectedOptions.scrollHeight + "px";
    }
*/

function updateTextBox() {
        var selectElement = document.getElementById("shopCategorySelect");
        var selectedOptions = document.getElementById("selectedCategories");
        
        var selectedCategory = selectElement.options[selectElement.selectedIndex].text;
        
        if (selectedOptions.value.trim() === "") {
            selectedOptions.value = selectedCategory;
        } else {
            selectedOptions.value += ", " + selectedCategory;
        }
        
        // Adjust the height of the textarea
        selectedOptions.style.height = selectedOptions.scrollHeight + "px";
    }
    
    function removeCategory(event) {
        var selectedOptions = document.getElementById("selectedCategories");
        var clickedCategory = event.target.value;
        var currentText = selectedOptions.value;
        
        // Remove clicked category from text box
        var updatedText = currentText.replace(clickedCategory, "").replace(", , ", ", ");
        selectedOptions.value = updatedText.trim();
        
        // Adjust the height of the textarea
        selectedOptions.style.height = selectedOptions.scrollHeight + "px";
    }
    
    function updateCategory(button) {
        var selectedOptions = document.getElementById("selectedCategories").value;
        
        // Perform any necessary processing with the selected categories
        // For example, you could send them to a server-side script for further processing
        
        // Example using AJAX to send data to a server-side script
        // Replace 'your_update_category_script.php' with your actual server-side script
        // Replace 'your_data' with the data you want to send
        $.ajax({
            url: 'process_association.php',
            method: 'POST',
            data: { selectedCategories: selectedOptions },
            success: function(response) {
                console.log(response); // Handle success response
            },
            error: function(xhr, status, error) {
                console.error(xhr, status, error); // Handle error
            }
        });
    }

	

 
  </script>