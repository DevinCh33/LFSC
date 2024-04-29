<?php

require_once 'connect.php'; // Include your database connection file

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the values from the POST request
    $shopTitle = isset($_POST['shopTitle']) ? $_POST['shopTitle'] : null;
    $shopEmail = isset($_POST['shopEmail']) ? $_POST['shopEmail'] : null;
    $shopNumber = isset($_POST['shopNumber']) ? $_POST['shopNumber'] : null;
    $shopDescr = isset($_POST['shopDescr']) ? $_POST['shopDescr'] : null;

    // Assuming you have a session for the user's ID
    $userId = isset($_GET['admID']) ? $_GET['admID'] : null; // Adjust this according to your session setup

    if ($shopTitle !== null && $shopEmail !== null && $shopNumber !== null && $shopDescr !== null && $userId !== null) {
        // Prepare and execute the SQL update statement
        $updateSql = "UPDATE restaurant SET title = ?, email = ?, phone = ?, description = ? WHERE adm_id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($updateSql);

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ssssi", $shopTitle, $shopEmail, $shopNumber, $shopDescr, $userId);

            // Execute the statement
            if ($stmt->execute()) {
                // Update successful
                echo json_encode(array("status" => "success", "message" => "Shop information updated successfully."));
            } else {
                // Update failed
                echo json_encode(array("status" => "error", "message" => "Failed to update shop information."));
            }

            // Close the statement
            $stmt->close();
        } else {
            // Error in preparing the statement
            echo json_encode(array("status" => "error", "message" => "Error preparing SQL statement."));
        }
    } else {
        // Invalid or missing parameters
        echo json_encode(array("status" => "error", "message" => "Invalid or missing parameters."));
    }
} else {
    // If the request method is not POST
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}

// Close the database connection
$conn->close();

