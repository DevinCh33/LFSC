<?php
// For prices check
$refreshBeforeCheck = false; // Recommended to be false for less user frustration
$exactPriceCheck = true; // More accurate price check, but incompatible with custom prices
$roomForError = 0.00999; // If price is detected to be less than a cent different, product will not be added to cart
$divideMinPrice = 100; // Set to 999999 for no effect
$divideMaxStock = 1.5;
