<?php
include("./../connection/connect.php");

$userId = $_GET['userId'];

$sql = "SELECT fullName, email, phone, address FROM users WHERE u_id = '".$userId."'";
$result = mysqli_query($db, $sql);

if (!$result) {
    // Log or handle the MySQL error
    die('MySQL Error: ' . mysqli_error($db));
}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Return data as JSON
echo json_encode($data);
?>
