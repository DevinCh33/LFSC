<?php 	
require_once 'core.php';


$sql = "SELECT r.image as r_image, r.title as r_title, r.email as r_email, r.phone as r_phone, r. description as r_desc, a.username, a.adm_Name, a.email, a.contact_num
		FROM admin a
		JOIN restaurant r ON a.store = r.rs_id
		WHERE a.store = '".$_SESSION['store']."'";

$result = $db->query($sql);


if ($result->num_rows > 0) { 
	$row = $result->fetch_assoc();
	$img = $row['r_image'];
	$output = array(
		'r_img' => $img,
		'r_title' => $row['r_title'],
		'r_email' => $row['r_email'],
		'r_phone' => $row['r_phone'],
		'r_desc' => $row['r_desc'],
        'email' => $row['email'], // Provide default value for email
        'phone' => $row['contact_num'], // Provide default value for phone
        'adm_name' => $row['adm_Name'], // Provide default value for description
        'username' => $row['username'] // Provide default value for username
    );

}

echo json_encode($output);