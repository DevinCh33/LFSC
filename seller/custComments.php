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
      <span class="text">Customer Comments</span>
    </div>

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

    <!-- Section to display comments -->
    <div class="comments-section">
      <h2>All Comments</h2>
      <hr class="mb-1">
      <?php
      // Include the PHP file for fetching and displaying comments
      include("fetch_sellercomments.php");

      // Fetch the 'store' value associated with the seller from the admin table
      include("connection/connect.php");
      $seller_id = $_SESSION['user_id']; // Assuming the seller's user_id is stored in session
      $query = "SELECT store FROM admin WHERE id = $seller_id";
      $result = mysqli_query($db, $query);
      if ($row = mysqli_fetch_assoc($result)) {
        $res_id = $row['store'];
        // Include the PHP file for fetching and displaying comments with the 'res_id' set
        include("fetch_sellercomments.php");
      } else {
        echo "Error fetching 'store' value for the seller.";
      }
      ?>
    </div>
  </section>
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
  <script src="js/seller_comment.js"></script>
</body>
</html>
