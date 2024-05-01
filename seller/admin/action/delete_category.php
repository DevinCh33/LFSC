<?php
// Include the connection file
include("../connection/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = $_POST['categoryId'];

    // Check if $conn is defined and is a valid connection
    if (isset($conn) && $conn instanceof mysqli) {
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
        // Error: Database connection not established
        echo json_encode(array('success' => false, 'message' => 'Database connection not established.'));
    }
} else {
    // Error: Invalid request method
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}

// Close the database connection
if (isset($conn)) {
    $conn->close();
}
