<?php 	
require_once 'core.php';

$adm_username = addslashes($_POST['ownerUser']);
$adm_name = addslashes($_POST['ownerName']);
$adm_email = addslashes($_POST['ownerEmail']);
$adm_contact = addslashes($_POST['ownerNumber']);
$shopTitle = addslashes($_POST['shopTitle']);
$shopEmail = addslashes($_POST['shopEmail']);
$shopNum = addslashes($_POST['shopNumber']);
$shopDescr = addslashes($_POST['shopDescr']);

$sql = "UPDATE admin SET adm_Name = '".$adm_name."', username = '".$adm_username."', email = '".$adm_email."', contact_num ='".$adm_contact."'
		WHERE adm_id = '".$_SESSION['adm_id']."'";

$shopSQL = "UPDATE restaurant SET email = '".$shopEmail."', phone ='".$shopNum."', title = '".$shopTitle."', description = '".$shopDescr."' WHERE rs_id = '".$_SESSION['store']."'";

if($db->query($sql) == true && $db->query($shopSQL)) { 
	$output = "UPDATE SUCCESSFULLY";
}
else
	$output = "UPDATE FAILED";

echo json_encode($output);
