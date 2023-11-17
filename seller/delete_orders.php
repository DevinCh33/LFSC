<?php
include("../connection/connect.php");
error_reporting(0);
session_start();


// sending query
mysqli_query($db,"UPDATE orders SET order_status = '4' WHERE order_id = '".$_GET['order_del']."'");
header("location:all_orders.php");  

?>
