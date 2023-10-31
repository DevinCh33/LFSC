<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if (isset($_SESSION["adm_co"]) && ($_SESSION["adm_co"] == "SUPA"))
{
    // sending query
    mysqli_query($db,"DELETE FROM restaurant WHERE rs_id = '".$_GET['res_del']."'");
    header("location:allrestraunt.php");  
}
?>
