<?php 	
require_once 'core.php';

$adm_username = $_POST['ownerUser'];
$adm_name = $_POST['ownerName'];
$adm_email = $_POST['ownerEmail'];
$adm_contact = $_POST['ownerNumber'];

$sql = "UPDATE admin SET adm_Name = '".$adm_name."', username = '".$adm_username."', email = '".$adm_email."', contact_num ='".$adm_contact."' 
		WHERE adm_id = '".$_SESSION['adm_id']."'";

$result = $db->query($sql);

if($db->query($sql) == true) { 
	$output = "UPDATE SUCCESSFULLY";
}
else
	$output = "UPDATE FAILED";

echo json_encode($output);