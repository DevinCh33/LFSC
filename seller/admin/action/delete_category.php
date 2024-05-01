<?php

require_once 'connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = $_POST['categoryId'];

    // SQL query to delete category
    $sql = "DELETE FROM categories WHERE categories_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    if ($stmt->execute()) {
        // Category deleted successfully
        echo json_encode(array('success' => true));
    } else {
        // Error deleting category
        echo json_encode(array('success' => false));
    }
    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}

$conn->close();

