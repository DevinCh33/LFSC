document.addEventListener("DOMContentLoaded", function() {

document.addEventListener('DOMContentLoaded', function () {
    const spayRadio = document.querySelector('.spay-radio');
    const spayImageContainer = document.querySelector('.spay-image-container');
    const closeButton = document.querySelector('.close-btn');

    spayRadio.addEventListener('change', function () {
        spayImageContainer.style.display = 'block';
    });

    closeButton.addEventListener('click', function () {
        spayImageContainer.style.display = 'none';
    });
});

});
