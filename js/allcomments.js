document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
        function changeCommentsPerPage() {
            var selectedValue = document.getElementById("commentsPerPage").value;
            var resId = "<?php echo isset($_GET['res_id']) ? $_GET['res_id'] : 'null'; ?>";
            if (resId !== 'null') {
                window.location.href = "all_comments.php?res_id=" + resId + "&per_page=" + selectedValue;
            }
        }
    });
});
