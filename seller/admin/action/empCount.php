<?php 	

require_once 'core.php';

$sql = "SELECT COUNT(empNo) AS totalEmp, COUNT(CASE WHEN empstatus = 1 THEN 1 END) AS activeEmp FROM tblemployee WHERE empstore =  '".$_SESSION['store']."'";
$result = $db->query($sql);



if($result->num_rows > 0) { 
	$row = $result->fetch_assoc();
	$output = array(
		'totalEmp' => $row['totalEmp'],
		'activeEmp' => $row['activeEmp']
	);
 

} // if num_rows

$db->close();

echo json_encode($output);