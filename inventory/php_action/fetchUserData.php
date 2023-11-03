<?php
    require_once 'core.php';

	$Search = trim($_REQUEST['searchText']);
	$UID = trim($_REQUEST['searchID']);

	if($Search != ""){
		$query = "SELECT * FROM users WHERE (f_name LIKE '%" . $Search . "%' OR l_name LIKE '%" . $Search . "%' OR username LIKE '%" . $Search . "%') ORDER BY f_name LIMIT 15";
	}
	else if ($UID != ""){
		$query = "SELECT * FROM users WHERE u_id ='".$UID."'";
	}

	$result = $db->query($query);

	$userArray = array(); // Initialize an array to store the results

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$userArray[] = $row; // Append each matching row to the array
			}
		}
	

	$db->close();

	echo json_encode($userArray);
    
?>

