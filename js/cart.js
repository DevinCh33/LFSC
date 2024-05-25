$(document).ready(function() {
    fetch('./config/cart.json').then((response) => {
        response.json().then((config) => {
            var debug = config.debug;
            var enableQuantityCheck = config.enableQuantityCheck;
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
                    debug? console.error('Error fetching cart:', error): 1;
                }
            });

            $('.shiftOptions').on('click', function() {
                const options = $(this).closest('.product').data('options');
                const maxNumber = Number($(this).closest('.product').data('max'));
                const currentNumber = Number($(this).closest('.product').data('current'));
                const currentStock = $(this).siblings('p').eq(1);
                const currentWeight = $(this).siblings('h6').children('span');
                const currentPrice = $(this).siblings('span');
                
                let nextNumber = currentNumber + 1; debug? console.log("Next number: " + nextNumber): 1;
                
                if (nextNumber >= maxNumber) {
                    nextNumber = 0;
                }

                let quantity = Number(options[nextNumber]['proQuant']);
                let base = Number(options[nextNumber]['proPrice']);
                let custom = Number(options[nextNumber]['price']);
                let discount = Number(options[nextNumber]['proDisc']);
                let weight = options[nextNumber]['proWeight'];
                
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

                currentStock.text("Number Left: " + quantity);
                currentWeight.text(weight);
                
                $(this).closest('.product').data('current', nextNumber);
                $(this).closest('.product').data('price-id', options[nextNumber]['priceNo']);
            });

            // Event listener for "Order Now" buttons (Search)
            $('.addToCart').on('click', function() {
                const priceId = $(this).parents().data('price-id');
                const productOwner = $(this).parents().data('product-owner');
                const productName = $(this).siblings('a').children('h5').text();
                const productStock = parseInt($(this).siblings('div').eq(1).text().split(" ")[2]);
                const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));
                const productImage = $(this).closest('.product').siblings('.search-product').data('image-src');
                
                addToCart(priceId, productName, productStock, productPrice, productOwner, 1, productImage);
            });

            // Event listener for "Order Now" buttons (Recommendations)
            $('.addmToCart').on('click', function() {
                const priceId = $(this).parents().data('price-id');
                const productOwner = $(this).parents().data('product-owner');
                const productName = $(this).siblings('a').children('h5').text();
                const productStock = parseInt($(this).siblings('p').eq(0).text().split(" ")[2]);
                const productPrice = parseFloat($(this).siblings('span').text().replace('Price: RM ', ''));
                const productImage = $(this).parents().siblings('img').attr('src');
                
                addToCart(priceId, productName, productStock, productPrice, productOwner, 1, productImage); 
            });

            // Event listener for "Add to Cart" buttons
            $('.addsToCart').on('click', function() {
                const priceId = $(this).closest('.product').data('price-id');
                const productOwner = $(this).closest('.product').data('product-owner');
                const productName = $(this).siblings('h6').text();
                const productStock = parseInt($(this).siblings('p').eq(1).text().split(" ")[2]);
                const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));
                const productAmount = Number($(this).siblings('input').val());
                const productImage = $(this).closest('.food-item').find('.rest-logo img').attr('src');
                
                addToCart(priceId, productName, productStock, productPrice, productOwner, productAmount, productImage);
            });

            function quantityCheck(quantity, stock) {
                var msg = null;

                if (quantity <= 0) {
                    var msg = "Please enter a number of at least 1!";
                    debug? console.log(msg): 1;
                }
                else if (!Number.isInteger(quantity)) {
                    var msg = "Please enter a whole number!";
                    debug? console.log(msg): 1;
                }
                else if (quantity > stock) {
                    var msg = "Not enough in stock!";
                    debug? console.log(msg): 1;
                }

                return msg;
            }

            // Function to add a product to the cart
            function addToCart(price_id, name, stock, price, owner, quantity=1, image='') {
                if (debug) {
                    console.log(price_id);
                    console.log(name);
                    console.log(stock);
                    console.log(price);
                    console.log(owner);
                    console.log(quantity);
                    console.log(image);
                }
                quantityCheckError = quantityCheck(quantity, stock);
                if ((quantityCheckError != null) && enableQuantityCheck) {
                    alert(quantityCheckError);
                    return;
                }
                const existingProduct = cart.find(item => item.price_id === price_id);
                if (existingProduct) {
                    quantityCheckError = quantityCheck(existingProduct.quantity + quantity, existingProduct.stock);
                    if ((quantityCheckError != null) && enableQuantityCheck) {
                        alert(quantityCheckError);
                        return;
                    }

                    existingProduct.quantity += quantity;
                } else {
                    cart.push({
                        price_id,
                        name,
                        stock,
                        price,
                        quantity,
                        owner,
                        image
                    });
                }
                updateCartUI();
                saveCart();
                alert("Product added to cart!");
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

                quantityCheckError = quantityCheck(newQuantity, productToUpdate.stock);
                if ((quantityCheckError != null) && enableQuantityCheck) {
                    alert(quantityCheckError);
                    return;
                }
                productToUpdate.quantity = newQuantity;
                updateCartUI();
                saveCart();
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
                            <a href="products.php?merchant=${item.owner}">${item.name}</a> - 
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
                $('.cartTotal').text('RM ' + totalPrice);
            }

            // For persistence throughout the session
            function saveCart() {
                $.ajax({
                    type: 'POST',
                    url: './save_cart.php',
                    data: { cart: cart },
                    success: function(response) {
                        debug? console.log('Cart saved on the server'): 1;
                    },
                    error: function(xhr, status, error) {
                        debug? console.error('Error:', error): 1;
                    }
                });
            }
        })
    })
});
