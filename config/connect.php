<?php
session_start(); // Temp session
error_reporting(0); // Hide undefined index errors
date_default_timezone_set("Asia/Kuala_Lumpur");
					
// Main connection file for both admin & front end
$servername = "localhost"; // server
$username = "root"; // username
$password = ""; // password
$dbname = "store";  // database
$inv_url = "http://lfsc.shop/seller/";

// Create connection
$db = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}
