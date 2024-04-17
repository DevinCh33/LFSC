document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
        // Fetch and display recent comments
        fetchComments();

        // Submit comment form
        $("#commentForm").submit(function(event) {
            event.preventDefault();
            var comment = $("#comment").val().trim();
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
                    try {
                        // Parse JSON response
                        var data = JSON.parse(response);
                        // Clear comment textarea
                        $("#comment").val("");
                        // Append the new comment to the recent comments list
                        appendComment(data.comment);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        });

        // Fetch and display recent comments
        function fetchComments() {
            $.ajax({
                type: "GET",
                url: "comment.php", // Assuming the PHP script is named comment.php
                data: { res_id: $("#res_id").val() }, // Send restaurant ID as a parameter
                success: function(response) {
                    try {
                        var comments = JSON.parse(response);
                        comments.forEach(function(comment) {
                            appendComment(comment.comment);
                        });
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        }

        // Append comment to the recent comments list
        function appendComment(comment) {
            var commentsList = $("#recentComments");
            var truncatedComment = comment.length > 150 ? comment.substring(0, 145) + "....." : comment; // Truncate long comments
            commentsList.append("<li>" + truncatedComment + "</li>");
        }
    });
});
