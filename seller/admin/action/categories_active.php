<?php
// Include the connection file
include("./../connect.php");

// Check if the category ID and new active value are provided
if(isset($_POST['categoryId']) && isset($_POST['statusValue']) && isset($_POST['activeValue'])) {
    // Retrieve category ID and new active value from POST data
    $categoryId = $_POST['categoryId'];
    $activeValue = $_POST['activeValue'];
    $statusValue = $_POST['statusValue'];

    // Update the categories_active and categories_status fields in the database
    $sql = "UPDATE categories SET categories_active = '$activeValue', categories_status = '$statusValue' WHERE categories_id = $categoryId";
    $result = mysqli_query($db, $sql);

    // Check if the query was successful
    if($result) {
        echo "Success: Category active status updated successfully.";
    } else {
        echo "Error: Unable to update category active status.";
    }
} else {
    echo "Error: Category ID or active value not provided.";
}



