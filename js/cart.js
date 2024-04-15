var debug = true;

$(document).ready(function() {
    var cart = [];

    $.ajax({
        type: 'GET',
        url: './save_cart.php',
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

    $('.shiftOptions').on('click', function() {
        const options = $(this).closest('.product').data('options');
        const maxNumber = Number($(this).closest('.product').data('max'));
        const currentNumber = Number($(this).closest('.product').data('current'));
        const currentWeight = $(this).siblings('h6').children('span');
        const currentPrice = $(this).siblings('span');
        
        let nextNumber = currentNumber + 1; debug? console.log("Next number: " + nextNumber): 1;
        
        if (nextNumber < maxNumber) {
            let base = Number(options[nextNumber]['proPrice']);
            let custom = Number(options[nextNumber]['price']);
            let discount = Number(options[nextNumber]['proDisc']);
            
            if (custom != 0) {
                debug? console.log("Custom"): 1;
                $(this).siblings('.discount-cross').text("");
                $(this).siblings('.discount-value').text("");
                currentPrice.text("RM " + custom.toFixed(2));
            }

            else if (discount == 0) {
                debug? console.log("Base"): 1;
                $(this).siblings('.discount-cross').text("");
                $(this).siblings('.discount-value').text("");
                currentPrice.text("RM " + base.toFixed(2));
            }

            else {
                debug? console.log("Discount"): 1;
                $(this).siblings('.discount-cross').text("RM " + base.toFixed(2));
                $(this).siblings('.discount-value').text(discount + "% off");
                currentPrice.text("RM " + (base*(1-discount/100)).toFixed(2));
            }

            currentWeight.text(options[nextNumber]['proWeight']);
            
            $(this).closest('.product').data('current', nextNumber);
            $(this).closest('.product').data('price-id', options[nextNumber]['priceNo']);
        }

        else {
            let base = Number(options[0]['proPrice']);
            let custom = Number(options[0]['price']);
            let discount = Number(options[0]['proDisc']);
            
            if (custom != 0) {
                debug? console.log("Custom"): 1;
                $(this).siblings('.discount-cross').text("");
                $(this).siblings('.discount-value').text("");
                currentPrice.text("RM " + custom.toFixed(2));
            }

            else if (discount == 0) {
                debug? console.log("Base"): 1;
                $(this).siblings('.discount-cross').text("");
                $(this).siblings('.discount-value').text("");
                currentPrice.text("RM " + base.toFixed(2));
            }

            else {
                debug? console.log("Discount"): 1;
                $(this).siblings('.discount-cross').text("RM " + base.toFixed(2));
                $(this).siblings('.discount-value').text(discount + "% off");
                currentPrice.text("RM " + (base*(1-discount/100)).toFixed(2));
            }

            currentWeight.text(options[0]['proWeight']);
            
            $(this).closest('.product').data('current', 0);
            $(this).closest('.product').data('price-id', options[0]['priceNo']);
        }
    });

    // Event listener for "Order Now" buttons (Search)
    $('.addToCart').on('click', function() {
        const priceId = $(this).parents().data('price-id');
        const productOwner = $(this).parents().data('product-owner');
        const productName = $(this).siblings('a').children('h5').text();
        const productWeight = productName.split("(")[1].slice(0, -2);
        const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));
        const productImage = $(this).closest('.product').siblings('.search-product').data('image-src');
        
        addToCart(priceId, productName, productWeight, productPrice, productOwner, 1, productImage); 
        alert("Product added to cart!");
    });

    // Event listener for "Order Now" buttons (Recommendations)
    $('.addmToCart').on('click', function() {
        const priceId = $(this).parents().data('price-id');
        const productOwner = $(this).parents().data('product-owner');
        const productName = $(this).siblings('a').children('h5').text();
        const productWeight = productName.split("(")[1].slice(0, -2);
        const productPrice = parseFloat($(this).siblings('span').text().replace('Price: RM ', ''));
        const productImage = $(this).parents().siblings('img').attr('src');
        
        addToCart(priceId, productName, productWeight, productPrice, productOwner, 1, productImage); 
        alert("Product added to cart!");
    });

    // Event listener for "Add to Cart" buttons
    $('.addsToCart').on('click', function() {
        const priceId = $(this).closest('.product').data('price-id');
        const productOwner = $(this).closest('.product').data('product-owner');
        const productName = $(this).siblings('h6').text();
        const productWeight = productName.split("(")[1].slice(0, -2);
        const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));
        const productAmount = Number($(this).siblings('input').val());
        const productImage = $(this).closest('.food-item').find('.rest-logo img').attr('src');
        
        addToCart(priceId, productName, productWeight, productPrice, productOwner, productAmount, productImage);
    });

    // Function to add a product to the cart
    function addToCart(price_id, name, weight, price, owner, quantity=1, image='') {
        if (debug) {
            console.log(price_id);
            console.log(name);
            console.log(weight);
            console.log(price);
            console.log(owner);
            console.log(quantity);
            console.log(image);
        }
        if (quantity <= 0) {
            alert("Please enter a number of at least 1!");
            return;
        }
        if (!Number.isInteger(quantity)) {
            alert("Please enter an integer!");
            return;
        }
        const existingProduct = cart.find(item => item.price_id === price_id);
        if (existingProduct) {
            existingProduct.quantity += quantity;
        } else {
            cart.push({
                price_id,
                name,
                weight,
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
    function removeProduct(priceId) {
        cart = cart.filter(item => item.price_id !== priceId);
        updateCartUI();
        saveCart();
    }

    // Function to update cart item quantity
    function updateCartItemQuantity(priceId, newQuantity) {
        const productToUpdate = cart.find(item => item.price_id === priceId);
        if (productToUpdate && Number.isInteger(newQuantity) && newQuantity > 0) {
            productToUpdate.quantity = newQuantity;
            updateCartUI();
            saveCart();
        }
        else {
            alert("Please enter a number of at least 1!");
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
            debug? console.log(JSON.stringify(item)): 1;
            $('#cartItems').append(`
                <li>
                    <img src="${item.image}" alt="${item.name}" style="width:50px; height:50px;"><br/>
                    <a href="dishes.php?res_id=${item.owner}">${item.name}</a> - 
                    RM ${parseFloat(item.price).toFixed(2)} x <br> <input type="number" class="product quantity" style="max-width: 4rem;" value="${item.quantity}" min="1" data-price-id="${item.price_id}"/>
                    <button class="btn theme-btn product removeProduct" data-price-id="${item.price_id}">
                        <i class="fa fa-trash pull-right">&nbsp;Remove</i>
                    </button>
                </li>
                <br/>`);

            $('.removeProduct').on('click', function() {
                const priceId = $(this).data('price-id');
                removeProduct(priceId);
            });

            $('.quantity').on('input', function() {
                const priceId = $(this).data('price-id');
                const newQuantity = parseInt($(this).val());
                debug? console.log("Current quantity in cart: " + newQuantity): 1;
                updateCartItemQuantity(priceId, newQuantity);
            });
        });

        const totalPrice = calculateTotalPrice();
        $('#cartTotal').text('RM ' + totalPrice);
    }

    // For persistence throughout the session
    function saveCart() {
        $.ajax({
            type: 'POST',
            url: './save_cart.php',
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
