<?php
include('../action/core.php'); 

$message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
	$t = $_GET['t'];
	
	if($t == "s"){
		$table = "admin";
		$status = "storeStatus";
		$num = '0';
	}else if($t == "e"){
		$table = "tblemployee";
		$status = "empstatus";
		$num = '1';
	}else{
		$table = "users";
		$status = "status";
		$num = '1';
	}
		

    $query = "SELECT * FROM ".$table." WHERE email_token='$token' LIMIT 1";
    $result = $db->query($query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        $updateQuery = "UPDATE $table SET $status = $num, email_verified = 1, email_token = NULL WHERE email_token = '$token'";


        if (mysqli_query($db, $updateQuery)) {
            // Successfully updated the user's verification status
            // Redirect to the success verification page

            header('Location: success_verification.php');
            exit(); 
        } else {

            $message = "Failed to verify email. Please try the verification link again or contact support if the problem persists.";
        }
    } else {

        $message = "This verification link is invalid or expired. Please check your email for the correct link or register again.";
    }
} else {

    $message = "No verification token provided. Please check your email for the verification link.";
}

if ($message !== '') {
    echo "<div style='text-align: center; margin-top: 20px;'>$message</div>";
}
