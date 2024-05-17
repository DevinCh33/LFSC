<?php
include("../../../config/connect.php"); // connection to database

if(!$_SESSION['adm_id']) {
	header('location:'.$inv_url);
}
