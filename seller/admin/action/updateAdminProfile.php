<?php 	
require_once 'core.php';

$adm_username = $_POST['ownerUser'];
$adm_name = $_POST['ownerName'];
$adm_email = $_POST['ownerEmail'];
$adm_contact = $_POST['ownerNumber'];

if($_SESSION['adm_co'] == "SUPA")
	$sql = "UPDATE admin SET adm_Name = '".$adm_name."', username = '".$adm_username."', email = '".$adm_email."', contact_num ='".$adm_contact."' 
		WHERE adm_id = '".$_SESSION['adm_id']."'";
else
	$sql = "UPDATE tblemployee SET empname = '".$adm_name."', username = '".$adm_username."', empemail = '".$adm_email."', empcontact ='".$adm_contact."' 
		WHERE empID = '".$_SESSION['adm_id']."'";



$result = $db->query($sql);

if($db->query($sql) == true) { 
	$output = "UPDATE SUCCESSFULLY";
}
else
	$output = "UPDATE FAILED";

echo json_encode($output);