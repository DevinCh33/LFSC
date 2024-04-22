document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
        // Fetch and display recent comments
        fetchComments();

        // Character limit for comment
        var commentMaxChars = 300;

        // Initialize word limit countdown
        updateWordLimitCountdown();

        // Update word limit countdown as user types
        $("#comment").on("input", function() {
            updateWordLimitCountdown(); // Call the function to update the countdown
        });

        // Submit comment form
        $("#commentForm").submit(function(event) {
            event.preventDefault();
            var comment = $("#comment").val().trim();
            var user_id = $("#user_id").val(); // Assuming you have a hidden input field for user_id
            var res_id = $("#res_id").val(); // Assuming you have a hidden input field for res_id
    
            if (comment.length > commentMaxChars) {
                alert("Comments must be limited to " + commentMaxChars + " characters.");
                return; // Prevent form submission
            }

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
                url: "comment.php", 
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
            commentsList.append("<hr>"); // Add horizontal rule after each comment
        }

// Update word limit countdown
function updateWordLimitCountdown() {
    var commentLength = $("#comment").val().length;
    var remainingChars = commentMaxChars - commentLength;
    var countdownElement = $("#wordLimitCountdown");
    
    // Highlight remaining characters based on threshold
    if (remainingChars <= 20) {
        countdownElement.css("color", "red"); // Change color to red when 20 or fewer characters are left
    } else if (remainingChars <= 150) {
        countdownElement.css("color", "orange"); // Change color to orange when 150 or fewer characters are left
    } else {
        countdownElement.css("color", "black"); // Change color to default when more than 150 characters are left
    }
    
    countdownElement.text("( " + remainingChars + " characters left)");
}


    });
});
