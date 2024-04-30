<?php
// Include the connection file
include("./../connection/connect.php");

// Initialize error variable
$error = '';

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $categoryId = $_POST['categoryId'];
    $newName = $_POST['newName'];

    // Check if the "newName" field is not empty
    if(!empty($newName)) {
        // Update the category in the database
        $sql = "UPDATE res_category SET c_name = '$newName' WHERE c_id = $categoryId";
        $result = mysqli_query($db, $sql);

        if($result) {
            // Redirect to a success page or display a success message
            header("Location: update_success.php");
            exit;
        } else {
            // Handle error, display error message or redirect to error page
            $error = "Error: " . mysqli_error($db);
        }
    } else {
        // If the "newName" field is empty, set an error message
        $error = "All fields required!";
    }
}

// Retrieve category ID from query string
if(isset($_GET['cat_upd'])) {
    $categoryId = $_GET['cat_upd'];

    // Fetch the category details from the database
    $sql = "SELECT * FROM res_category WHERE c_id = $categoryId";
    $result = mysqli_query($db, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $categoryName = $row['c_name'];
    } else {
        // Handle error if category is not found
        $error = "Category not found.";
    }
}

