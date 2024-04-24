<?php
// Include the database connection file (connect.php)
include('../connect.php');

	$valid = false;

	$act = $_POST['act']; // 'act' is a parameter passed in the AJAX request
	$data = $_POST['data']; // 'data' contains the serialized form data

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
    // You should perform data validation and sanitization here

    // SQL query to insert data into the database
	if($act == "add"){
		
		$sql = "INSERT INTO tblemployee (empID, icNo, empname, empcontact,empgender, empemail, empjob, empstatus, empstore)VALUES ('$empID','$icno', '$empName', '$empNum','$empGender', '$empEmail', '$empJob', '$empStatus', '$store')";
		
		
		//$tempPass = generatePassword(10);
		
		//$loginSQL = "INSERT INTO admin (username, password, email, code, u_role, store, date) VALUES ('".$tempUsername."', '".$tempPassword."','".$empEmail."', 'VSUPP', 'VSELLER', '".date("Y-m-d H:i:s")."')";
		
		
	}
    else if($_POST['act'] == "edit"){
		echo $sql = "UPDATE tblemployee SET icNo = '$icno', empname = '$empName', empcontact = '$empNum', empgender = '$empGender', empemail = '$empEmail', empjob = '$empJob', empstatus = '$empStatus' WHERE empID = '$empID'";
	}
	else if($_POST['act'] == "del"){
		$sql = "UPDATE tblemployee SET empstatus = 2 WHERE empID = '$empID'";
	}

    if ($db->query($sql) === true) {
        $valid = true;
    } else {
        $valid = false;
    }

// Return a JSON response
echo json_encode($sql);
?>
