$(document).ready(function() {
    var ratingValue = 0; // Variable to store the selected rating value

    // Dynamic Rating Stars
    $('.rating-stars').find('i').mouseover(function() {
        // Remove 'fa-star-o' class from all stars
        $(this).parent().find('i').removeClass('fa-star-o');

        // Get the index of the current star
        var index = $(this).index();

        // Add 'fa-star' class to stars up to the current index
        $(this).parent().find('i:lt(' + (index + 1) + ')').addClass('fa-star');

        // Add 'fa-star-o' class to stars after the current index
        $(this).parent().find('i:gt(' + index + ')').addClass('fa-star-o');

        // Update rating value
        ratingValue = index + 1;
    });

    $('.rating-stars').mouseleave(function() {
        // Remove 'fa-star' class from all stars
        $(this).parent().find('i').removeClass('fa-star');

        // Add 'fa-star-o' class to all stars
        $(this).parent().find('i').addClass('fa-star-o');

        // Reset rating value
        ratingValue = 0;
    });

    $('.rating-stars').click(function() {
        var productId = $(this).data('product-id');

        // Send the actual rating value instead of counting stars
        $.ajax({
            url: 'update_rating_product.php',
            method: 'POST',
            data: { product_id: productId, rating: ratingValue },
            success: function(response) {
                // Handle success, e.g., show a success message
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle errors, e.g., show an error message
                console.error(xhr.responseText);
            }
        });
    });

    // Update Average Rating
    function updateAverageRating(productId) {
        $.ajax({
            url: 'get_average_rating.php',
            method: 'GET',
            data: { product_id: productId }, // Pass the product ID to calculate average rating
            success: function(response) {
                // Update the average rating for the specific product
                $('.avg-rating[data-product-id="' + productId + '"]').text(response);
            },
            error: function(xhr, status, error) {
                // Handle errors, e.g., show an error message
                console.error(xhr.responseText);
            }
        });
    }

    // Call updateAverageRating for each product on page load
    $('.rating-stars').each(function() {
        var productId = $(this).data('product-id');
        updateAverageRating(productId);
    });
});
