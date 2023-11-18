$(document).ready(function() {
    var cart = [];

    $.ajax({
        type: 'GET',
        url: './product-action.php',
        success: function(response) {
            cart = response;
            if (!cart) {
                cart = [];
            } else {
                updateCartUI();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching cart:', error);
        }
    });

    // Event listener for "Add to Cart" buttons
    $('.addToCart').on('click', function() {
        const productId = $(this).closest('.product').data('product-id');
        const productOwner = $(this).closest('.product').data('product-owner');
        const productName = $(this).siblings('a').children('h5').text();
        const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));
        const productImage = $(this).closest('.food-item').find('.rest-logo img').attr('src'); // Updated selector for the image

        addToCart(productId, productName, productPrice, productOwner, 1, productImage); // Include image parameter
        alert("Product added to cart!");
    });

    // Event listener for ".addsToCart" buttons
    $('.addsToCart').on('click', function() {
        const productId = $(this).closest('.product').data('product-id');
        const productOwner = $(this).closest('.product').data('product-owner');
        const productName = $(this).siblings('h6').text();
        const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));
        const productAmount = Number($(this).siblings('input').val());
        const productImage = $(this).closest('.food-item').find('.rest-logo img').attr('src'); // Updated selector for the image

        addToCart(productId, productName, productPrice, productOwner, productAmount, productImage); // Include image parameter
    });

    $('.checkout').on('click', function() {
        const productId = $(this).closest('.product').data('product-id');
        const productOwner = $(this).closest('.product').data('product-owner');
        const productName = $(this).siblings('h6').text();
        const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));
        const productImage = $(this).closest('.food-item').find('.rest-logo img').attr('src'); // Updated selector for the image

        addToCart(productId, productName, productPrice, productOwner, 1, productImage); // Include image parameter
        alert("Product added to cart!");
    });

    // Function to add a product to the cart
    function addToCart(id, name, price, owner, quantity=1, image='') {
        const existingProduct = cart.find(item => item.id === id);
        if (existingProduct) {
            existingProduct.quantity += quantity;
        } else {
            cart.push({
                id,
                name,
                price,
                quantity,
                owner,
                image 
            });
        }
        updateCartUI();
        saveCart();
    }

    // Function to remove a product from the cart
    function removeProduct(productId) {
        cart = cart.filter(item => item.id !== productId);
        updateCartUI();
        saveCart();
    }

    // Function to update cart item quantity
    function updateCartItemQuantity(productId, newQuantity) {
        const productToUpdate = cart.find(item => item.id === productId);
        if (productToUpdate && Number.isInteger(newQuantity)) {
            productToUpdate.quantity = newQuantity;
            updateCartUI();
            saveCart();
        }
    }

    function calculateTotalPrice() {
        let totalPrice = 0;
        cart.forEach(item => {
            totalPrice += item.price * item.quantity;
        });
        return totalPrice.toFixed(2); // Convert to 2 decimal places
    }

    // Function to update the UI with the current cart state
    function updateCartUI() {
        $('#cartItems').empty();
        cart.forEach(item => {
            $('#cartItems').append(`
                <li>
                    <img src="${item.image}" alt="${item.name}" style="width:50px; height:50px;"> 
                    <a href="dishes.php?res_id=${item.owner}">${item.name}</a> - 
                    RM ${item.price.toFixed(2)} x <input type="number" class="product quantity" value="${item.quantity}" data-product-id="${item.id}"/>
                    <button class="product removeProduct" data-product-id="${item.id}">
                        <i class="fa fa-trash pull-right">Remove</i>
                    </button>
                </li>`);

            $('.removeProduct').on('click', function() {
                const productId = $(this).data('product-id');
                removeProduct(productId);
            });

            $('.quantity').on('input', function() {
                const productId = $(this).data('product-id');
                const newQuantity = parseInt($(this).val());
                updateCartItemQuantity(productId, newQuantity);
            });
        });

        const totalPrice = calculateTotalPrice();
        $('#cartTotal').text('RM ' + totalPrice);
    }

    // For persistence throughout the session
    function saveCart() {
        $.ajax({
            type: 'POST',
            url: './product-action.php',
            data: { cart: cart },
            success: function(response) {
              console.log('Cart saved on the server');
            },
            error: function(xhr, status, error) {
              console.error('Error:', error);
            }
        });
    }
});
