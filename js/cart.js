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
  