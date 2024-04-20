document.addEventListener("DOMContentLoaded", function() {
    // Fetch and display comments
    fetchComments();

    // Function to fetch comments from the server
    function fetchComments() {
        // Get the restaurant ID from the URL
        var resId = "<?php echo isset($_GET['res_id']) ? $_GET['res_id'] : 'null'; ?>";

        // Check if the restaurant ID is provided
        if (resId !== 'null') {
            // Send an AJAX request to fetch comments
            $.ajax({
                type: "GET",
                url: "fetch_sellercomments.php",
                data: { res_id: resId },
                success: function(response) {
                    // Display comments on the page
                    $("#recentComments").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching comments:", error);
                }
            });
        } else {
            console.error("Error: Restaurant ID not provided.");
        }
    }
});
