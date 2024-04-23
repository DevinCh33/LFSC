<?php 

session_start();

require_once '../config/connect.php';

// echo $_SESSION['userId'];

if(!$_SESSION['adm_id']) {
	header('location:'.$store_url);	
} 



?>