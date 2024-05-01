<?php

require_once 'connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = $_POST['categoryId'];
    $newCategoryName = $_POST['newCategoryName'];

    // SQL query to update category name
    $sql = "UPDATE categories SET categories_name = ? WHERE categories_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newCategoryName, $categoryId);
    if ($stmt->execute()) {
        // Category renamed successfully
        echo json_encode(array('success' => true));
    } else {
        // Error renaming category
        echo json_encode(array('success' => false));
    }
    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}

$conn->close();

