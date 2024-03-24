document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('commentForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var comment = document.getElementById('comment').value.trim();
        var commentError = document.getElementById('commentError');

        // Input validation
        if (comment === '') {
            commentError.textContent = 'Comment cannot be empty';
            return;
        }

        if (!/^[a-zA-Z0-9\s.,!?]*$/.test(comment)) {
            commentError.textContent = 'Comment must contain only letters, numbers, and punctuation';
            return;
        }




        $.ajax({
            url: "comment.php",
            method: "POST",
            data: { comment: comment, res_id: restaurantId },
            success: function() {
                console.log("Comment posted successfully");
            },
            error: function(xhr, status, error) {
                console.error("Comment failed to post:", error);
            }
        });

    });
});
