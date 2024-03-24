<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

// sending query
mysqli_query($db,"UPDATE product SET active = '3' WHERE product_id = '".$_GET['menu_del']."'");
header("location:all_menu.php");
?>
