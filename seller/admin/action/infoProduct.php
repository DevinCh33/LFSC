<?php
include('../connect.php');
include '../email/delNotification.php';
$valid = false;
$check = false;

$formDataArray = array();
    foreach ($_POST as $key => $value) {
        $formDataArray[$key] = $value;
 }


$act = $formDataArray['act'];
$data = $formDataArray['data'];

$proID = $formDataArray['productCode'];
$proName = $formDataArray['proName'];
$email = $formDataArray['seller'];
$reason = $formDataArray['delReason'];


if($act == 'del'){
	$delSQL = "UPDATE product SET status = 3 WHERE product_id = '$proID'";
	if($db->query($delSQL))
		$valid = true;
	sendDelete($email, $proID, $proName, $reason);
}

// Return a JSON response
echo json_encode($reason);
?>
