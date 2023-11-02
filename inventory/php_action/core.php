<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]); // get root directory
include("$root/lfsc/connection/connect.php"); // connection to database

session_start();

if(!$_SESSION['adm_id']) {
	header('location:'.$inv_url);	
} 
?>

