<!DOCTYPE html>
<html lang="en">

<head>
	<title>Little Farmer Website</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="landing/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php
session_start(); // temp session
error_reporting(1); // hide undefined index errors
include("connection/connect.php"); // connection to database
?>

	<header>
		<img src="landing/logo.png" alt="logo">

		<ul>
			<li><a href="index.php" class="active">Home</a></li>
			<li><a href="market.php">Market</a></li>
			<li><a href="#">About US</a></li>
			<li><a href="#">Order Now</a></li>
			<li><a href="buysell.php">Login</a></li>
			<li><a href="registration.php">Sign Up</a></li>
		</ul>
	</header>

	<!-- Slide -->
	<div class="slide-container">
		<div class="slides fade">
			<img src="landing/slide1.jpg" alt="slide1">
		</div>
		<div class="slides fade">
			<img src="landing/slide2.jpg" alt="slide2">
		</div>
		<div class="slides fade">
			<img src="landing/slide3.jpg" alt="slide3">
		</div>
		<div class="slides fade">
			<img src="landing/slide4.png" alt="slide4">
		</div>
		<div class="slide-content">
			<h1>Fresh Produce</h1>
			<h2>Delivery</h2>
			<p>From Our Farm to Your Doorstep</p>
			<a href="#" class="order-button">Order Online</a>
		</div>

		<div class="dots-container">
    		<span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span>
		</div>
	</div>

	<!-- Product -->
	<section class="showProduct">
		<div class="top-section">
			<div class="promo">
				<h1>Something Important</h1>
				<p>This is some random paragraph describing the product</p>
				<!-- Add promotional images or other elements here -->
			</div>
			<div class="mainProduct-card">
				<a href="#">
					<h2>Fruit</h2>
					<img src="landing/fruit.jpg" alt="fruit">
					<p>View range</p>
				</a>
			</div>
		</div>

		<!-- Product Categories Grid -->
		<div class="products-grid">
			<a href="#">
				<div class="product-card">
					<h2>Cresses</h2>
					<img src="landing/cress.jpg" alt="Cresses">
					<p>View range</p>
				</div>
			</a>
			<a href="#">
				<div class="product-card">
					<h2>Potato</h2>
					<img src="landing/potato.jpg" alt="Potato">
					<p>View range</p>
				</div>
			</a>
			<a href="#">                    
				<div class="product-card">
					<h2>Cresses</h2>
					<img src="landing/cress.jpg" alt="Cresses2">
					<p>View range</p>
				</div>
			</a>

			<a href="#">
				<div class="product-card">
					<h2>Potato</h2>
					<img src="landing/potato.jpg" alt="Potato2">
					<p>View range</p>
				</div>
			</a>
		</div>
	</section>

	<!-- About Little Farmer Section -->
	<section class="about-farmer">
		<div class="about-container">
			<img src="landing/logo.png" alt="About Little Farmer">
			<div class="about-content">
				<h2>About Little Farmer</h2>
				<p>Little Farmer has been cultivating organic produce for over two decades. Our commitment to fresh and sustainable farming has made us the choice of many households. Dive in to know more about our journey and values.</p>
				<div class="about-links">
					<a href="#">Our Story</a>
					<a href="#">Meet the Team</a>
					<a href="#">Something</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="footer">
		<div class="row-container">
			<div class="address">
				<p>Little Farmer</p>
				<p>Sarawak, Malaysia</p>
				<p>Email</p>
				<p>Tel: </p>
				<p>Fax: </p>
			</div>
			<div class="operating-hours">
				<h4>Operating Hours</h4>
				<p>Mon - Fri: 8am - 8pm</p>
				<p>Saturday: 9am - 7pm</p>
				<p>Sunday: 9am - 8pm</p>
			</div>
			<div class="delivery-hours">
				<h4>Delivery Hours</h4>
				<p>Mon - Fri: 8am - 8pm</p>
				<p>Saturday: 9am - 7pm</p>
				<p>Sunday: 9am - 8pm</p>
			</div>
		</div>
		<div class="social-links">
			<a href="#">Facebook</a>
			<a href="#">Twitter</a>
			<a href="#">Instagram</a>
		</div>
	</footer>

	<script>
    var slideIndex = 1; // Start with 1 to match your logic in displaySlide
    var slides = document.getElementsByClassName("slides");
    var dots = document.getElementsByClassName("dot");
    var slideInterval;

    function incrementSlide() {
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }
        displaySlide();
    }

	function displaySlide() {
    for (var i = 0; i < slides.length; i++) {
        slides[i].classList.remove("show"); // Remove the "show" class from all slides
    }
    
    for (var i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active-dot", "");
    }
    
    slides[slideIndex-1].classList.add("show"); // Add "show" class to the current slide
    dots[slideIndex-1].className += " active-dot";
	}

// Existing incrementSlide and other functions remain unchanged.


    function currentSlide(n) {
        clearInterval(slideInterval);  // Stop the auto slideshow
        slideIndex = n;
        displaySlide();
        slideInterval = setInterval(incrementSlide, 4000); // Restart the auto slideshow
    }

    for (var i = 0; i < dots.length; i++) {
        dots[i].addEventListener("click", function() {
            var index = Array.prototype.indexOf.call(dots, this);
            currentSlide(index + 1);
        });
    }

    displaySlide(); // Display the first slide immediately
    slideInterval = setInterval(incrementSlide, 4000);  // Start the auto slideshow
	</script>
</body>
</html>
