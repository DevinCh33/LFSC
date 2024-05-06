<?php
session_start();
include("./../connect.php");

// Check if comment ID is provided
if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];

    // Delete the comment from the database
    $delete_query = "DELETE FROM user_comments WHERE id = $comment_id";
    $delete_result = mysqli_query($db, $delete_query);

    if ($delete_result) {
        // Comment successfully deleted
        $_SESSION['success_message'] = "Comment deleted successfully.";
    } else {
        // Failed to delete comment
        $_SESSION['error_message'] = "Failed to delete comment. Please try again.";
    }

    // Redirect back to the page where the comment was deleted from
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit(); // Terminate script execution after redirection
} else {
    // If comment ID is not provided
    $_SESSION['error_message'] = "Comment ID not provided.";
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit(); // Terminate script execution after redirection
}


