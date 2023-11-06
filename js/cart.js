document.addEventListener('DOMContentLoaded', function()
{
  const addOneToCartButtons = document.querySelectorAll('#addOneToCart');

  addOneToCartButtons.forEach(button => {
    button.addEventListener('click', function() {
      const productId = this.getAttribute('productId');
      addToCart(productId, 1);
    });
  });
  
  function addToCart(productId, quantity) 
  {
    // build FormData object
    let formData = new FormData();
    formData.append('productId', productId);
    formData.append('quantity', quantity);

    // make an AJAX request to the server to add the product to the cart
    // This might involve sending a POST request with the product ID to a PHP endpoint
    // using fetch API:
    fetch('./product-action.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      alert("Added to cart!");
    }) 
  }
});





// Add an event listener to the "Remove from Cart" button.
document.querySelectorAll('.remove-from-cart-button').forEach(button => {
    button.addEventListener('click', function () {
        // Get the product ID.
        const productId = this.getAttribute('productId');

        // Remove the item from the cart.
        removeFromCart(productId);
    });
});

// Remove the item from the cart.
function removeFromCart(productId) {
    // build FormData object
    let formData = new FormData();
    formData.append('productId', productId);

    // make an AJAX request to the server to remove the product from the cart
    // This might involve sending a DELETE request with the product ID to a PHP endpoint
    // using fetch API:
    fetch('./product-action.php?action=remove', {
        method: 'DELETE',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Reload the page to update the cart.
            location.reload();
        });
}