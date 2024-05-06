<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="style.css">
    <!-- Boxiocns CDN Link -->
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
      <i class='bx bx-menu' ></i>
      <span class="text">Employees</span>
    </div>
	  
	  <div class="empMainCon">

<?php
  session_start();
// Include the database connection
include("config/connect.php");

// Check if the res_id is set in the URL
if (isset($_SESSION['store'])) {
    $res_id = $_SESSION['store'];

    // Check if the sort order is specified in the URL
    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

    // Get the current page number from the URL or default to page 1
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

    // Define the number of comments per page
    $commentsPerPage = 5;

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
            echo '<div class="sorting-options" style="float: left;">';
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
    echo '<th>Customer Name</th>';
    echo '<th>Posted on</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
// Define a function to generate a random name
function generateRandomName() {
    // Define the characters allowed in the random name
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // Generate a random length between 5 and 8
    $length = rand(5, 8);
    // Initialize an empty name
    $name = '';
    // Generate the random name
    for ($i = 0; $i < $length; $i++) {
        $name .= $characters[rand(0, strlen($characters) - 1)];
    }
    // Replace the last 4 characters with "****"
    $name = substr_replace($name, '****', -4);
    return $name;
}

    // Initialize an array to store generated names for each unique user_id
    $generatedNames = array();

    foreach ($commentsForPage as $row) {
        // Check if the user_id already has a generated name
        if (!isset($generatedNames[$row['user_id']])) {
            // Generate a new random name for this user_id
            $generatedNames[$row['user_id']] = generateRandomName();
        }

        echo '<tr>';
        // Display the generated name instead of the user_id
        echo '<td>' . $generatedNames[$row['user_id']] . '</td>';
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
echo '<div class="pagination" style="float: right;">';
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i > 1) {
        echo ', '; // Add comma between page numbers
    }
    if ($i == $currentPage) {
        // If current page, don't make it a link
        echo '<span>' . $i . '</span>';
    } else {
        // If not current page, make it a link
        echo '<a href="custComments.php?res_id=' . $res_id . '&per_page=' . $commentsPerPage . '&page=' . $i . '">' . $i . '</a>';
    }
}
echo '</div>';


} else {
    echo '<p>Error: Seller ID not provided.</p>';
}

// Close the database connection
mysqli_close($db);
?>
  
</body>
</html>
<script src="scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/comment.js"></script>
<script src="js/allcomments_seller.js"></script>

    <script>
  // Function to change records per page
  function changeRecordsPerPage() {
    fetchData();
  }

  // Function to fetch data based on selected options
  function fetchData() {
    var recordsPerPage = document.getElementById("recordsPerPage").value;
    var searchInput = document.getElementById("searchInput").value;

    var url = "fetch_comments.php?res_id=<?php echo $_SESSION['store']; ?>&per_page=" + recordsPerPage;

    // Append sort order if available
    var sortOrder = getUrlParameter('sort');
    if (sortOrder) {
      url += "&sort=" + sortOrder;
    }

    // Append search input if available
    if (searchInput) {
      url += "&search=" + searchInput;
    }

    // Fetch data using AJAX
    $.ajax({
      url: url,
      success: function (data) {
        document.getElementById("commentsTable").innerHTML = data;
      }
    });
  }

  // Function to get URL parameter by name
  function getUrlParameter(name) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(window.location.href);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }

  // Initial data fetch on page load
  fetchData();
</script>




