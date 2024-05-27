<?php
// Include the database connection file (connect.php)
include('../connect.php');
include("../email/send_verification_email.php");
	$valid = false;

	$act = $_POST['act']; // 'act' is a parameter passed in the AJAX request
	$data = $_POST['data']; // 'data' contains the serialized form data
	$custpass = password_hash($_POST['custpass'], PASSWORD_DEFAULT);
	$tempname = $_POST['tempname'];
	parse_str($data, $formDataArray);

	// Now you can access the form fields using keys in the $formDataArray
	$empID = $formDataArray['emp'];
	$icno = $formDataArray['icNo'];
	$empName = $formDataArray['empName'];
	$empGender = $formDataArray['empGender'];
	$empNum = $formDataArray['empNum'];
	$empEmail = $formDataArray['empEmail'];
	$empJob = $formDataArray['empJob'];
	$empStatus = $formDataArray['empStatus'];
	$store = $formDataArray['storeid'];
	$token = bin2hex(random_bytes(50));
    // You should perform data validation and sanitization here

    // SQL query to insert data into the database
	if($act == "add"){
		$sql = "INSERT INTO tblemployee (empID, icNo, empname, empcontact,empgender, empemail, empjob, empstatus, empstore, username, password,code , u_role, email_token)VALUES ('$empID','$icno', '$empName', '$empNum','$empGender', '$empEmail', '$empJob', '10', '$store', '$tempname', '$custpass', 'VSUPA','VADMIN', '$token')";
		
		sendVerificationEmail($empEmail, $tempname, $_POST['custpass'], 'employee', $token);
		
		if ($db->query($sql) == true) {
			$valid = true;
		} else {
			$valid = false;
		}
	}
    else if($_POST['act'] == "edit"){
		echo $sql = "UPDATE tblemployee SET icNo = '$icno', empname = '$empName', empcontact = '$empNum', empgender = '$empGender', empemail = '$empEmail', empjob = '$empJob', empstatus = '$empStatus' WHERE empID = '$empID'";
		if ($db->query($sql) === true) {
			$valid = true;
		} else {
			$valid = false;
		}
	}
	else if($_POST['act'] == "del"){
		$sql = "UPDATE tblemployee SET empstatus = 2 WHERE empID = '$empID'";
		if ($db->query($sql) === true) {
			$valid = true;
		} else {
			$valid = false;
		}
	}



// Return a JSON response
echo json_encode($valid);
?>
