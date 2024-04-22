document.addEventListener("DOMContentLoaded", function() {
    // Fetch and display comments
    fetchComments();

    // Function to fetch comments from the server
    function fetchComments() {
        // Send an AJAX request to fetch the seller's information
        $.ajax({
            type: "GET",
            url: "fetch_seller_info.php", // Change this to the endpoint that fetches seller info
            success: function(response) {
                var sellerInfo = JSON.parse(response); // Parse the response JSON
                if (sellerInfo && sellerInfo.store) {
                    // Use the 'store' field value as the res_id
                    var resId = sellerInfo.store;

                    // Send another AJAX request to fetch comments using the res_id
                    $.ajax({
                        type: "GET",
                        url: "fetch_sellercomments.php",
                        data: { res_id: resId },
                        success: function(commentsResponse) {
                            // Display comments on the page
                            $("#recentComments").html(commentsResponse);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching comments:", error);
                        }
                    });
                } else {
                    console.error("Error: 'store' field not found in seller info.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching seller info:", error);
            }
        });
    }
});
