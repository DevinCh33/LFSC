// JavaScript function to handle star rating interaction
document.addEventListener("DOMContentLoaded", function() {
    let ratingBlock = document.querySelector(".rating-block");
    let stars = ratingBlock.querySelectorAll("i");

    $.ajax({
        url: "update_rating.php",
        method: "POST",
        data: { rating: rating, res_id: restaurantId },
        success: function(response) {
            console.log("Rating updated successfully");
        },
        error: function(xhr, status, error) {
            console.error("Failed to update rating:", error);
        }
    });


    stars.forEach(function(star, index) {
        star.addEventListener("mouseover", function() {
            // Set all stars up to this index as active
            for (let i = 0; i <= index; i++) {
                stars[i].classList.add("star-active");
            }
            // Set all stars after this index as inactive
            for (let i = index + 1; i < stars.length; i++) {
                stars[i].classList.remove("star-active");
            }
        });

        star.addEventListener("click", function() {
            // Update the rating value in the database (you'll need AJAX for this)
            // Here, you'll send the selected rating to the server to be stored in the database
            // You can use the data-resid attribute to identify the restaurant ID
            let rating = index + 1; // Rating is 1-based
            let restaurantId = ratingBlock.dataset.resid;

            // Example AJAX call to update_rating.php
            // Replace this with your actual AJAX implementation
            // Make sure to include proper error handling and validation
            // AJAX call to update_rating.php with the selected rating and restaurant ID
            /*
            $.ajax({
                url: "update_rating.php",
                method: "POST",
                data: { rating: rating, res_id: restaurantId },
                success: function(response) {
                    console.log("Rating updated successfully");
                },
                error: function(xhr, status, error) {
                    console.error("Failed to update rating:", error);
                }
            });
            */
        });
    });
});
