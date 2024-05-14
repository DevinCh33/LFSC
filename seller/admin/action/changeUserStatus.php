<?php 

require_once 'core.php';
include("../email/userAccManagement.php");


	$act = $_GET['act'];
	$custID = $_GET['custID'];
	$email = $_GET['email'];
	$message = "";

	if($act == 'blk'){
		$sql = "UPDATE users SET status = 10 WHERE u_id = '".$custID."'";
		if($db->query($sql) == TRUE) {
			$message = "USER BANNED!";
			sendBan($email);
		} else {
			$message = "SOMETHINGS PROBLEM!";
		}
	}
	else{
		$sql = "UPDATE users SET status = 1 WHERE u_id = '".$custID."'";
		if($db->query($sql) == TRUE) {
			$message = "USER RECOVERY!";
			sendRecovery($email);
		} else {
			$message = "SOMETHINGS PROBLEM!";
		}
	}

	echo json_encode($message);
?>