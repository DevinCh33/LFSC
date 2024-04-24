<?php 	
require_once 'core.php';


$sql = "SELECT a.username, a.adm_Name, a.email, a.contact_num
		FROM admin a
		WHERE a.store = '".$_SESSION['store']."'";

$result = $db->query($sql);


if ($result->num_rows > 0) { 
	$row = $result->fetch_assoc();
	$output = array(
        'title' => "SYSTEM ADMIN",
        'u_role' => "ADMIN",
        'email' => $row['email'], // Provide default value for email
        'phone' => $row['contact_num'], // Provide default value for phone
        'adm_name' => $row['adm_Name'], // Provide default value for description
        'username' => $row['username'] // Provide default value for username
    );

}

echo json_encode($output);