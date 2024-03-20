<?php
// Include your database connection file
include("connection/connect.php");

// Check if the rating and restaurant ID are sent via POST
if(isset($_POST['rating']) && isset($_POST['res_id'])) {
    // Sanitize and validate input
    $rating = intval($_POST['rating']);
    $res_id = intval($_POST['res_id']);

    // Perform the update query using prepared statements
    $updateQuery = "UPDATE restaurant SET rating = ? WHERE rs_id = ?";
    $stmt = mysqli_prepare($db, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ii", $rating, $res_id);
    $result = mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if($result) {
        // Return success response with HTTP status code 200
        http_response_code(200);
        echo json_encode(array("success" => true));
    } else {
        // Return error response with HTTP status code 500
        http_response_code(500);
        echo json_encode(array("error" => "Failed to update rating"));
    }
} else {
    // Return error response with HTTP status code 400 if data is not received
    http_response_code(400);
    echo json_encode(array("error" => "Invalid data received"));
}

