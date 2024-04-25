<?php 	

require_once 'core.php';
include("../email/send_verification_email.php");
$valid = false;


		$userName 			= $_POST['username'];
		$upassword 			= password_hash($_POST['custPass'], PASSWORD_DEFAULT);
		$uemail 			= $_POST['custEmail'];
		$token = bin2hex(random_bytes(50));

		$sql = "INSERT INTO admin (username, password, email, code, u_role, storeStatus, email_token) VALUES ('$userName', '$upassword' , '$uemail', 'SUPP', 'SELLER',10, '$token')";
		if($db->query($sql) === TRUE) {
			$valid = "SELLER ADDED SUCCESSFULLY";
			sendVerificationEmail($uemail, $userName, $_POST['custPass'], 'seller', $token);
		} else {
			$valid = "ERROR!";
		}	

	echo json_encode($valid);
 
?>