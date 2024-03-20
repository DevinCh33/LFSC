document.addEventListener("DOMContentLoaded", function() {
$(document).ready(function() {
    $('.rating-block').each(function() {
        var rating = parseFloat($(this).data('rating'));
        var resid = $(this).data('resid');
        var stars = $(this).find('i');

        stars.each(function(index) {
            if (index < rating) {
                $(this).removeClass('star-inactive').addClass('star-active');
            } else {
                $(this).removeClass('star-active').addClass('star-inactive');
            }
        });
    });
});
});