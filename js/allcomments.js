document.addEventListener("DOMContentLoaded", function() {
    // Function to handle changing comments per page
    function changeCommentsPerPage() {
        var selectedValue = document.getElementById("commentsPerPage").value;
        var resId = "<?php echo isset($_GET['res_id']) ? $_GET['res_id'] : 'null'; ?>";
        if (resId !== 'null') {
            // Redirect to all_comments.php with updated per_page parameter
            window.location.href = "all_comments.php?res_id=" + resId + "&per_page=" + selectedValue;
        }
    }

    // Call changeCommentsPerPage() when the comments per page selection changes
    document.getElementById("commentsPerPage").addEventListener("change", changeCommentsPerPage);
});
