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
			$sql = "UPDATE product SET status = 3 WHERE owner = '".$shopID."'";
			if($db->query($sql) === TRUE) {
				$message = "SHOP BANNED!";
			} else {
				$message = "SOMETHINGS PROBLEM!";
			}
		} else {
			$message = "SOMETHINGS PROBLEM!";
		}
	}
	else{
		$sql = "UPDATE admin SET storeStatus = 1 WHERE store = '".$shopID."'";
		if($db->query($sql) === TRUE) {
			$message = "SHOP RECOVERY!";
			sendRecovery($email);
			$message = "SHOP RECOVERED!";
		} else {
			$message = "SOMETHINGS PROBLEM!";
		}
	}

	echo json_encode($message);
?>