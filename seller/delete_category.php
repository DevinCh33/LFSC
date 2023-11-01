<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("./../connection/connect.php"); // connection to database

if (isset($_SESSION["adm_co"]) && ($_SESSION["adm_co"] == "SUPA"))
{
    // sending query
    mysqli_query($db,"DELETE FROM res_category WHERE c_id = '".$_GET['cat_del']."'");
    header("location:add_category.php");  
}
?>
