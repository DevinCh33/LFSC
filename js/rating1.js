function fillStars(num) {
    for (var i = 1; i <= num; i++) {
        document.getElementById('star_' + i).classList.remove('fa-star-o');
        document.getElementById('star_' + i).classList.add('fa-star');
        // Add custom style to fill the star with yellow color
        document.getElementById('star_' + i).style.color = 'rgba(255, 255, 0, 0.5)';
    }
    // Reset the rest of the stars to their default state
    for (var i = num + 1; i <= 5; i++) {
        document.getElementById('star_' + i).classList.remove('fa-star');
        document.getElementById('star_' + i).classList.add('fa-star-o');
        // Reset the color to default for the rest of the stars
        document.getElementById('star_' + i).style.color = '';
    }
}

function resetStars() {
    for (var i = 1; i <= 5; i++) {
        document.getElementById('star_' + i).classList.remove('fa-star');
        document.getElementById('star_' + i).classList.add('fa-star-o');
    }
}

// Pass the restaurant ID and rating to the function
function saveRating(resId, rating) {
    fetch('rate.php?res_id=' + resId + '&rating=' + rating)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            // You can handle the response as needed
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}
