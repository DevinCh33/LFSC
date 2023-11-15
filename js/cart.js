$(document).ready(function() 
{	
	var cart = [];

	$.ajax({
		type: 'GET',
		url: './product-action.php',
		success: function(response) 
		{
			cart = response;
			
			if (!cart)
			{
				cart = [];
			}

			else
			{
				// Update the UI if cart contains items
				updateCartUI();
			}
		},
		error: function(xhr, status, error) 
		{
			console.error('Error fetching cart:', error);
		}
	});

	// Add event listener for "Add to Cart" buttons
	$('.addToCart').on('click', function()
	{
		// Get product information from the clicked element
		const productId = $(this).closest('.product').data('product-id');
		const productOwner = $(this).closest('.product').data('product-owner');
		const productName = $(this).siblings('h6').text();
		const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));

		// Add the product to the cart
		addToCart(productId, productName, productPrice, productOwner);
		alert("Product added to cart!");
	});

	// Add event listener for "Add to Cart" buttons
	$('.addsToCart').on('click', function()
	{
		// Get product information from the clicked element
		const productId = $(this).closest('.product').data('product-id');
		const productOwner = $(this).closest('.product').data('product-owner');
		const productName = $(this).siblings('h6').text();
		const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));
		const productAmount = Number($(this).siblings('input').val());

		// Add the product to the cart
		addToCart(productId, productName, productPrice, productOwner, productAmount);
	});

	$('.checkout').on('click', function()
	{
		// Get product information from the clicked element
		const productId = $(this).closest('.product').data('product-id');
		const productOwner = $(this).closest('.product').data('product-owner');
		const productName = $(this).siblings('h6').text();
		const productPrice = parseFloat($(this).siblings('span').text().replace('RM', ''));

		// Add the product to the cart
		addToCart(productId, productName, productPrice, productOwner);
		alert("Product added to cart!");
	});

	// Function to add a product to the cart
	function addToCart(id, name, price, owner, quantity=1) 
	{
		// Check if the product is already in the cart
		const existingProduct = cart.find(item => item.id === id);

		if (existingProduct) 
		{
			// If the product is in the cart, update the quantity
			existingProduct.quantity += quantity;
		} 

		else 
		{
			// If the product is not in the cart, add it
			cart.push({
			id,
			name,
			price,
			quantity,
			owner
		});
	}

		// Update the UI to reflect the changes
		updateCartUI();
		// Save cart
		saveCart();
	}

	// Function to remove a product from the cart
	function removeProduct(productId) 
	{
		// Exclude product from cart
		cart = cart.filter(item => item.id !== productId);

		// Update the UI to reflect the changes
		updateCartUI();
		// Save cart
		saveCart();
	}

	// Function to update cart item quantity
	function updateCartItemQuantity(productId, newQuantity)
	{
		const productToUpdate = cart.find(item => item.id === productId);

		// Check if quantity value is not null
		if (productToUpdate && Number.isInteger(newQuantity))
		{
		  productToUpdate.quantity = newQuantity;
		  updateCartUI();
		  saveCart();
		}
	}

	function calculateTotalPrice() 
	{
		let totalPrice = 0;

		cart.forEach(item => {
			totalPrice += item.price * item.quantity;
		});

		return totalPrice.toFixed(2); // Convert to 2 decimal places
	}

	// Function to update the UI with the current cart state
	function updateCartUI() 
	{
		console.log(JSON.stringify(cart))
		// Clear the cartItems list
		$('#cartItems').empty();

		// Populate the cartItems list with the current cart content
		cart.forEach(item => {
			$('#cartItems').append(`<li><a href="dishes.php?res_id=${item.owner}">${item.name}</a> - 
			RM ${item.price.toFixed(2)} x <input type="number" class="product quantity" value="${item.quantity}" data-product-id="${item.id}"/>
				<button class="product removeProduct" data-product-id="${item.id}">
					<i class="fa fa-trash pull-right">Remove</i>
				</button>
			</li>`);

			$('.removeProduct').on('click', function()
			{
				// Get product information from the clicked element
				const productId = $(this).data('product-id');
				
				// Add the product to the cart
				removeProduct(productId);
			});

			$('.quantity').on('input', function()
			{	
				// Get correct ID
				const productId = $(this).data('product-id');
				
				// Get new value
				const newQuantity = parseInt($(this).val());

				// Update product quantity
				updateCartItemQuantity(productId, newQuantity);
			});	
		});

		const totalPrice = calculateTotalPrice();

		// Display the total price in the UI
		$('#cartTotal').text('Total Price: RM ' + totalPrice);
	}

	// For persistence throughout the session
	function saveCart()
	{
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
