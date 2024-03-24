<?php
// Include your database connection file
include("connection/connect.php");

// Check if the comment, user ID, and restaurant ID are sent via POST
if(isset($_POST['comment']) && isset($_POST['user_id']) && isset($_POST['res_id'])) {
    // Sanitize and validate input
    $comment = mysqli_real_escape_string($db, $_POST['comment']);
    $user_id = intval($_POST['user_id']);
    $res_id = intval($_POST['res_id']);

    // Check if the user has already commented on this restaurant
    $checkQuery = "SELECT * FROM user_comments WHERE user_id = ? AND res_id = ?";
    $stmt = mysqli_prepare($db, $checkQuery);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $res_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0) {
        // If user has already commented, update the existing comment
        $updateQuery = "UPDATE user_comments SET comment = ? WHERE user_id = ? AND res_id = ?";
        $stmt = mysqli_prepare($db, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sii", $comment, $user_id, $res_id);
    } else {
        // If user has not commented, insert a new comment
        $insertQuery = "INSERT INTO user_comments (user_id, res_id, comment) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $insertQuery);
        mysqli_stmt_bind_param($stmt, "iis", $user_id, $res_id, $comment);
    }

    $result = mysqli_stmt_execute($stmt);

    // Check if the insert/update was successful
    if($result) {
        // Retrieve the ID of the last inserted comment
        $comment_id = mysqli_insert_id($db);
        // Return success response with HTTP status code 200
        http_response_code(200);
        echo json_encode(array("success" => true, "comment_id" => $comment_id, "comment" => $comment));
    } else {
        // Return error response with HTTP status code 500
        http_response_code(500);
        echo json_encode(array("error" => "Failed to update comment"));
    }
} else {
    // Return error response with HTTP status code 400 if data is not received
    http_response_code(400);
    echo json_encode(array("error" => "Invalid data received"));
}
