<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="sidebar close">
    <?php include "sidebar.php"; ?>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu'></i>
      <span class="text">Products</span>
    </div>

	<!-- test -->
	
	<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("connection/connect.php"); // connection to database


if (isset($_GET['res_id'])) {
    $res_id = $_GET['res_id'];

    // Query to fetch comments for the specified restaurant
    $query = "SELECT * FROM user_comments WHERE res_id = $res_id";
    $result = mysqli_query($db, $query);

    // Fetch comments and display them
    echo '<ul id="userComments">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li>';
        echo '<p>User ID: ' . $row['user_id'] . '</p>';
        echo '<p>Restaurant ID: ' . $row['res_id'] . '</p>';
        echo '<p>Posted On: ' . $row['created_at'] . '</p>';
        echo '<p>Comment: ' . nl2br($row['comment']) . '</p>'; // Convert new lines to <br> tags
        echo '</li>';
    }
    echo '</ul>';

    // Close the database connection
    mysqli_close($db);
} else {
    echo '<p>Error: Restaurant ID not provided.</p>';
}
?>



    <div class="empMainCon">

      <div class="controls-container">
        <div class="records-per-page">
          <span>Records per page:</span>
          <select id="recordsPerPage" onchange="changeRecordsPerPage()" class="custom-select">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="50">50</option>
          </select>
        </div>
        <div class="search-bar">
          <span>Search:</span>
          <input type="text" id="searchInput" onkeyup="fetchData()" placeholder="Search for names..">
        </div>
      </div>
      <div class="table-container">
        <table id="myTable">
          <thead>
            <tr>
              <th onclick="sortTable(0)">User ID <span class="sort-indicator" id="indicator0"></span></th>
              <th onclick="sortTable(1)">Restaurant ID <span class="sort-indicator" id="indicator1"></span></th>
              <th onclick="sortTable(2)">Posted On <span class="sort-indicator" id="indicator2"></span></th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <!-- Table content goes here -->
          </tbody>
        </table>
      </div>
      <div class="pagination-summary">
        <span id="tableSummary">Showing 1-10 of 100 Records</span>
        <div class="pagination"></div>
      </div>
    </div>



	
<?php
// Include the database connection
include("connection/connect.php");

// Check if the res_id is set in the URL
if (isset($_GET['res_id'])) {
    $res_id = $_GET['res_id'];

    // Check if the sort order is specified in the URL
    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

    // Get the current page number from the URL or default to page 1
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

    // Define the number of comments per page
    $commentsPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 5;

    // Query to fetch comments for the specified seller sorted by date with pagination
    $query = "SELECT * FROM user_comments WHERE res_id = $res_id ORDER BY created_at $sortOrder";
    $result = mysqli_query($db, $query);

    // Fetch all comments
    $allComments = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Calculate total comments and pages
    $totalComments = count($allComments);
    $totalPages = ceil($totalComments / $commentsPerPage);

    // Calculate the offset to fetch comments for the current page
    $offset = ($currentPage - 1) * $commentsPerPage;

    // Fetch comments for the current page
    $commentsForPage = array_slice($allComments, $offset, $commentsPerPage);
/*
    // Display the dropdown menu for selecting the number of comments per page
    echo '<label for="sort">Comments per page:</label>';
    echo '<select id="commentsPerPage" onchange="changeCommentsPerPage()">';
    echo '<option value="5" ' . ($commentsPerPage == 5 ? 'selected' : '') . '>5 per page</option>';
    echo '<option value="10" ' . ($commentsPerPage == 10 ? 'selected' : '') . '>10 per page</option>';
    echo '<option value="15" ' . ($commentsPerPage == 15 ? 'selected' : '') . '>15 per page</option>';
    echo '<option value="20" ' . ($commentsPerPage == 20 ? 'selected' : '') . '>20 per page</option>';
    echo '</select>';
*/
    // Display the sorting options
    echo '<div class="sorting-options">';
    echo '<form action="" method="GET">';
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
        echo '<a href="all_comments.php?res_id=' . $res_id . '&per_page=' . $commentsPerPage . '&page=' . $i . '">' . $i . '</a>';
    }
    echo '</div>';

    // Add JavaScript for changing the number of comments per page
    echo '<script src="js/allcomments.js"></script>';
} else {
    echo '<p>Error: Seller ID not provided.</p>';
}

// Close the database connection
mysqli_close($db);
?>
  </section>
  <script src="scripts.js"></script>
  <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/rating_product.js"></script>
    <script src="js/rating.js"></script>
    <script src="js/comment.js"></script>
    <script src="js/allcomments.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('#divalert').hide();
  fetchData();
});

function lowStockNumber() {
  var num = $("#stockAlert").val();
  console.log(num);
  // Your AJAX call here
}

// Other JavaScript functions and event handlers...

</script>


</body>
</html>



