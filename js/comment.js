document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
        // Submit comment form
        $("#commentForm").submit(function(event) {
            event.preventDefault();
            var comment = $("#comment").val();
            var user_id = $("#user_id").val(); // Assuming you have a hidden input field for user_id
            var res_id = $("#res_id").val(); // Assuming you have a hidden input field for res_id
    
            $.ajax({
                type: "POST",
                url: "comment.php",
                data: {
                    comment: comment,
                    user_id: user_id,
                    res_id: res_id
                },
                success: function(response) {
                    // Parse JSON response
                    var data = JSON.parse(response);
                    // Clear comment textarea
                    $("#comment").val("");
                    // Append the new comment to the recent comments list
                    $("#recentComments").append("<li>" + data.comment + "</li>");
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
    
        // Fetch and display recent comments
        function fetchComments() {
            $.ajax({
                type: "GET",
                url: "fetch_comments.php", // Assuming a separate PHP file for fetching comments
                success: function(response) {
                    var comments = JSON.parse(response);
                    var commentsList = $("#recentComments");
                    commentsList.empty();
                    for (var i = 0; i < comments.length; i++) {
                        commentsList.append("<li>" + comments[i].comment + "</li>");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }
    
        // Initial fetch of comments on page load
        fetchComments();
    });
});
