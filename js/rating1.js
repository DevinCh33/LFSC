document.addEventListener("DOMContentLoaded", function() {
    let ratingBlocks = document.querySelectorAll(".rating-block");

    ratingBlocks.forEach(function(ratingBlock) {
        let stars = ratingBlock.querySelectorAll("i");
        let restaurantId = ratingBlock.dataset.resid;

        stars.forEach(function(star, index) {
            star.addEventListener("click", function() {
                // Update the rating value in the database
                let rating = index + 1; // Rating is 1-based

                // AJAX call to update_rating.php with the selected rating and restaurant ID
                $.ajax({
                    url: "update_rating.php",
                    method: "POST",
                    data: { rating: rating, res_id: restaurantId },
                    success: function() {
                        console.log("Rating updated successfully");
                    },
                    error: function(xhr, status, error) {
                        console.error("Failed to update rating:", error);
                    }
                });

                // Update the data-rating attribute to reflect the selected rating
                ratingBlock.dataset.rating = rating;

                // Toggle the class to fill or empty stars based on the clicked index
                for (let i = 0; i < stars.length; i++) {
                    if (i <= index) {
                        stars[i].classList.add("star-active");
                        stars[i].classList.remove("star-inactive");
                    } else {
                        stars[i].classList.remove("star-active");
                        stars[i].classList.add("star-inactive");
                    }
                }
            });
        });
    });
});
