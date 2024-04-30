<?php 	
require_once 'core.php';

$adm_username = $_POST['ownerUser'];
$adm_name = $_POST['ownerName'];
$adm_email = $_POST['ownerEmail'];
$adm_contact = $_POST['ownerNumber'];
$shopTitle = $_POST['shopTitle'];
$shopEmail = $_POST['shopEmail'];
$shopNum = $_POST['shopNumber'];
$shopDescr = $_POST['shopDescr'];

$sql = "UPDATE admin SET adm_Name = '".$adm_name."', username = '".$adm_username."', email = '".$adm_email."', contact_num ='".$adm_contact."'
		WHERE adm_id = '".$_SESSION['adm_id']."'";

$shopSQL = "UPDATE restaurant SET email = '".$shopEmail."', phone ='".$shopNum."', title = '".$shopTitle."', description = '".$shopDescr."' WHERE rs_id 			= '".$_SESSION['store']."'";



if($db->query($sql) == true && $db->query($shopSQL)) { 
	$output = "UPDATE SUCCESSFULLY";
}
else
	$output = "UPDATE FAILED";

echo json_encode($output);