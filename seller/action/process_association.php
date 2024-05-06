<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include 'db_connection.php';

    // Check if selectedCategories is set in the POST data
    if (isset($_POST['selectedCategories']) && isset($_POST['rs_id'])) {
        // Get the selected categories and rs_id from the POST data
        $selectedCategories = $_POST['selectedCategories'];
        $rs_id = $_POST['rs_id'];

        // Explode the selectedCategories string into an array
        $categoryIds = explode(",", $selectedCategories);
        
        // Trim whitespace from each category ID
        $categoryIds = array_map('trim', $categoryIds);

        // Perform any necessary data validation here

        // Perform any necessary processing to update the restaurant_categories table
        // For example, you could insert the associations into the database table
        
        // Example: Update restaurant_categories table
        // Replace 'restaurant_categories' with your actual table name
        foreach ($categoryIds as $categoryId) {
            // Perform an INSERT operation for each category ID
            $query = "INSERT INTO restaurant_categories (rs_id, c_id) VALUES ('$rs_id', '$categoryId')";
            mysqli_query($db, $query);
        }
        
        // Send a success response back
        echo "Associations updated successfully!";
    } else {
        // Send an error response if selectedCategories or rs_id are not set
        http_response_code(400);
        echo "Error: selectedCategories or rs_id not set in the POST data.";
    }
} else {
    // Send an error response if the request method is not POST
    http_response_code(405);
    echo "Error: Only POST requests are allowed.";
}

