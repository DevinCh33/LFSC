<?php 

require_once 'core.php';

	$pass = $_GET['newPass'];

	$newPassword = password_hash($pass, PASSWORD_DEFAULT);
	$valid = "";
	if($_SESSION['adm_co'] == "SUPA")
		$updateSql = "UPDATE admin SET password = '$newPassword' WHERE adm_id = '".$_SESSION['adm_id']."'";
	else
		$updateSql = "UPDATE tblemployee SET password = '$newPassword' WHERE empID = '".$_SESSION['adm_id']."'";
	
	if($db->query($updateSql) === TRUE) {
		$valid = "PASSWORD UPDATED";		
	} else {
		$valid = "UPDATED FAILED";	
	}


	echo json_encode($valid);



?>