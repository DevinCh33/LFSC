<?php
// Include your database connection file
include("connection/connect.php");

// Check if the restaurant ID is provided in the request
if(isset($_GET['res_id'])) {
    $res_id = intval($_GET['res_id']);

    // Query to fetch comments for the specified restaurant
    $query = "SELECT * FROM user_comments WHERE res_id = $res_id";
    $result = mysqli_query($db, $query);

    // Check if there are comments
    if(mysqli_num_rows($result) > 0) {
        // Display comments
        echo '<ul>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<li>' . $row['comment'] . '</li>';
            echo '<hr>'; // Add horizontal rule after each comment
        }
        echo '</ul>';
    } else {
        echo '<p>No comments yet.</p>';
    }

    // Close the database connection
    mysqli_close($db);
} else {
    // Return an error message if the restaurant ID is not provided
    echo 'Error: Restaurant ID not provided.';
}
