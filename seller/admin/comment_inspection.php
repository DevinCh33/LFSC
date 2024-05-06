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
    <style>
        .comments-per-page {
            float: left;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            color: #007bff;
            padding: 8px 12px;
            text-decoration: none;
            border: 1px solid #007bff;
            margin-right: 5px;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
        }

        .pagination a:hover {
            background-color: #f0f0f0;
        }

        .pagination .next-last {
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar close">
        <?php include "sidebar.php"; ?>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Comment Inspection</span>
        </div>

        <div class="empMainCon">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by seller..." onkeyup="filterComments()">
                <i class="fa fa-search search-icon" onclick="filterComments()"></i>
                <i class="fa fa-eye show-all-icon" onclick="showAllComments()"></i>
            </div>

            <div class="comments-per-page">
    <label for="commentsPerPage">Comments Per Page:</label>
    <select id="commentsPerPage" onchange="updateCommentsPerPage()">
        <option value="5" <?php if(isset($_GET['commentsPerPage']) && $_GET['commentsPerPage'] == '5') echo 'selected'; ?>>5</option>
        <option value="10" <?php if(isset($_GET['commentsPerPage']) && $_GET['commentsPerPage'] == '10') echo 'selected'; ?>>10</option>
        <option value="15" <?php if(isset($_GET['commentsPerPage']) && $_GET['commentsPerPage'] == '15') echo 'selected'; ?>>15</option>
        <option value="50" <?php if(isset($_GET['commentsPerPage']) && $_GET['commentsPerPage'] == '50') echo 'selected'; ?>>50</option>
        <option value="100" <?php if(!isset($_GET['commentsPerPage']) || $_GET['commentsPerPage'] == '100') echo 'selected'; ?>>100</option>
    </select>
</div>

            <?php
            session_start();
            // Include the database connection
            include("config/connect.php");

            // Pagination configuration
            $commentsPerPage = isset($_GET['commentsPerPage']) && in_array((int)$_GET['commentsPerPage'], [5, 10, 15, 50]) ? (int)$_GET['commentsPerPage'] : 10;
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number, default is 1
            $start = ($page - 1) * $commentsPerPage; // Starting index for fetching comments

            // Query to fetch total number of comments
            $totalCommentsQuery = "SELECT COUNT(*) AS total FROM user_comments";
            $totalCommentsResult = mysqli_query($db, $totalCommentsQuery);
            $totalCommentsRow = mysqli_fetch_assoc($totalCommentsResult);
            $totalComments = $totalCommentsRow['total'];

            // Calculate total number of pages
            $totalPages = ceil($totalComments / $commentsPerPage);

            // Query to fetch comments for the current page
            $query = "SELECT c.id, c.user_id, r.title, c.comment, c.created_at 
                      FROM user_comments c
                      INNER JOIN restaurant r ON c.res_id = r.rs_id
                      LIMIT $start, $commentsPerPage";
            $result = mysqli_query($db, $query);

            // Check if there are any comments
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>User ID</th>';
                echo '<th>Title</th>';
                echo '<th>Comment</th>';
                echo '<th>Posted on</th>';
                echo '<th>Delete</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody id="commentTableBody">'; // Added id to tbody
                // Fetch and display each comment
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['user_id'] . '</td>';
                    echo '<td>' . $row['title'] . '</td>';
                    echo '<td>' . $row['comment'] . '</td>';
                    echo '<td>' . $row['created_at'] . '</td>';
                    echo '<td><a href="delete_comment.php?id=' . $row['id'] . '" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10" onclick="return confirm(\'Are you sure you want to delete this comment?\');"><i class="fa fa-trash-o" style="font-size:16px"></i></a></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';

                // Pagination links
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo '<a href="?page=1&commentsPerPage=' . $commentsPerPage . '">First</a>,';
                    echo '<a href="?page=' . ($page - 1) . '&commentsPerPage=' . $commentsPerPage . '">Previous</a>,';
                }
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '&commentsPerPage=' . $commentsPerPage . '" ';
                    if ($page === $i) {
                        echo 'class="active"';
                    }
                    echo '>' . $i . '</a>';
                    if ($i < $totalPages) {
                        echo ',';
                    }
                }
                if ($page < $totalPages) {
                    echo '</div><div class="pagination next-last">';
                    echo '<a href="?page=' . ($page + 1) . '&commentsPerPage=' . $commentsPerPage . '">Next</a>,';
                    echo '<a href="?page=' . $totalPages . '&commentsPerPage=' . $commentsPerPage . '">Last</a>';
                }
                echo '</div>';
            } else {
                echo '<p>No comments found.</p>';
            }

            // Close the database connection
            mysqli_close($db);
            ?>
        </div>
    </section>
</body>

</html>
<script src="scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/comment.js"></script>
<script src="js/allcomments_admin.js"></script>
<script>
    // Function to filter comments based on search input
    function filterComments() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("commentTableBody");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2]; // index 2 for Title column
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Function to show all comments
    function showAllComments() {
        var rows = document.querySelectorAll('.empMainCon table tbody tr');
        for (var i = 0; i < rows.length; i++) {
            rows[i].style.display = "";
        }
    }

// Function to update comments per page
function updateCommentsPerPage() {
    var commentsPerPage = document.getElementById("commentsPerPage").value;
    var currentUrl = window.location.href;
    var newUrl = currentUrl.split('?')[0] + '?commentsPerPage=' + commentsPerPage;
    window.location.href = newUrl;
}


</script>
