<?php
include('../connect.php');
include("../email/storeValidated.php");

if ($_GET['act'] == "app") {
	
    $appSQL = "UPDATE admin SET storeStatus = 1 WHERE store = '".$_GET['sid']."'";
	if($db->query($appSQL))
		$message = 'Store Validated';
	$imgUpdate = "UPDATE tblValidation SET imgStatus = 3 WHERE storeID = '".$_GET['sid']."'";
	$db->query($imgUpdate);
	
	sendSuccess($_GET['email']);
} 
elseif ($_GET['act'] == "rej") {
	$delSQL = "UPDATE tblValidation SET imgStatus = 2, comment= '".$_GET['reason']."' WHERE storeID = '".$_GET['sid']."'";
	if($db->query($delSQL))
		$message = 'Notification Send to Seller';
	sendFail($_GET['email'], $_GET['reason']);
}

// Return a JSON response
echo json_encode($message);
?>
