<?php
// Include the connection file
include("./../connect.php");

// Initialize error variable
$error = '';

// Check if the category ID is provided in the query string
if(isset($_GET['cat_del'])) {
    // Retrieve category ID from the query string
    $categoryId = $_GET['cat_del'];

    // SQL query to delete the categsory
    $sql = "DELETE FROM res_category WHERE c_id = $categoryId";

    // Execute the query
    $result = mysqli_query($db, $sql);

    if($result) {
        header("refresh:0;url=../store_category_inspection.php");
    }
} else {
    // If category ID is not provided, display an error message
    echo "Category ID not provided.";
}
