<?php
// Include your database connection file
include("config/connect.php");

// Check if the seller ID is available in the session
if(isset($_SESSION['user_id'])) {
    // Retrieve the seller ID from the session
    $seller_id = $_SESSION['user_id'];

    // Query to fetch the store value associated with the seller from the admin table
    $query = "SELECT store FROM admin WHERE id = $seller_id";
    $result = mysqli_query($db, $query);

    // Check if the query was successful
    if($result) {
        // Fetch the 'store' value
        $row = mysqli_fetch_assoc($result);
        $res_id = intval($row['store']);

        // Check if the res_id is set in the URL
        if (isset($_GET['res_id'])) {
            $res_id = $_GET['res_id'];

            // Check if the sort order is specified in the URL
            $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

            // Get the current page number from the URL or default to page 1
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            // Define the number of comments per page
            $commentsPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 5;

            // Calculate the offset to fetch comments for the current page
            $offset = ($currentPage - 1) * $commentsPerPage;

            // Query to fetch total count of comments for the specified seller
            $totalCountQuery = "SELECT COUNT(*) AS total FROM user_comments WHERE res_id = $res_id";
            $totalCountResult = mysqli_query($db, $totalCountQuery);
            $totalCountRow = mysqli_fetch_assoc($totalCountResult);
            $totalComments = $totalCountRow['total'];

            // Calculate total pages
            $totalPages = ceil($totalComments / $commentsPerPage);

            // Query to fetch comments for the current page with pagination
            $query = "SELECT * FROM user_comments WHERE res_id = $res_id ORDER BY created_at $sortOrder LIMIT $offset, $commentsPerPage";
            $result = mysqli_query($db, $query);

            // Fetch comments for the current page
            $commentsForPage = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // Display sorting options
            echo '<div class="sorting-options">';
            echo '<form action="" method="GET">';
            echo '<input type="hidden" name="res_id" value="' . $res_id . '">'; 
            echo '<label for="sort">Sort By:</label>';
            echo '<select id="sort" name="sort" onchange="this.form.submit()">';
            echo '<option value="desc" ' . ($sortOrder == 'desc' ? 'selected' : '') . '>Newest First</option>';
            echo '<option value="asc" ' . ($sortOrder == 'asc' ? 'selected' : '') . '>Oldest First</option>';
            echo '</select>';
            echo '</form>';
            echo '</div>';

            // Display comments as a table
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>User ID</th>';
            echo '<th>Restaurant ID</th>';
            echo '<th>Posted on</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($commentsForPage as $row) {
                echo '<tr>';
                echo '<td>' . $row['user_id'] . '</td>';
                echo '<td>' . $row['res_id'] . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td colspan="3">' . $row['comment'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            // Display pagination links
            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i > 1) {
                    echo ', '; // Add comma between page numbers
                }
                echo '<a href="your_page.php?res_id=' . $res_id . '&per_page=' . $commentsPerPage . '&page=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';

            // Add JavaScript for changing the number of comments per page
            echo '<script src="js/allcomments.js"></script>';
        } else {
            echo '<p>Error: Seller ID not provided.</p>';
        }
    } else {
        echo 'Error: Unable to fetch store information for the seller.';
    }
} else {
    // Return an error message if the seller ID is not available in the session
    echo 'Error: Seller ID not provided in the session.';
}








// Close the database connection
mysqli_close($db);
