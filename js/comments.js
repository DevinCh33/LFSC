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

        if (comment.split(' ').length > 100) {
            commentError.textContent = 'Comment must be less than 100 words';
            return;
        }

        // AJAX request to save the comment
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_comment.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Clear the form and display success message
                document.getElementById('comment').value = '';
                commentError.textContent = '';
                alert('Comment submitted successfully');
            } else {
                alert('Error saving comment. Please try again later.');
            }
        };
        xhr.send('comment=' + encodeURIComponent(comment));
    });


});
