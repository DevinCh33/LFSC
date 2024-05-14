<?php 
require_once 'core.php';
include("../email/sellerAccManagement.php");

	$act = $_GET['act'];
	$shopID = $_GET['shopID'];
	$email = $_GET['email'];
	$message = "";

	if($act == 'blk'){
		$sql = "UPDATE admin SET storeStatus = 10 WHERE store = '".$shopID."'";
		if($db->query($sql) === TRUE) {
			$message = "SHOP BANNED!";
			sendBan($email);
		} else {
			$message = "SOMETHINGS PROBLEM!";
		}
	}
	else{
		$sql = "UPDATE admin SET storeStatus = 1 WHERE store = '".$shopID."'";
		if($db->query($sql) === TRUE) {
			$message = "SHOP RECOVERY!";
			sendRecovery($email);
		} else {
			$message = "SOMETHINGS PROBLEM!";
		}
	}

	echo json_encode($message);
?>