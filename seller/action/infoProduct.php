<?php
include('../connect.php');

$valid = false;
$check = false;

$act = $_POST['act'];
$data = $_POST['data'];
parse_str($data, $formData);

$date = date("Y-m-d");
$proID = $_POST['proID'];
$productID = $formData['proID'];
$productCode = $formData['productCode'];
$productName = $formData['proName'];
$productDescription = $formData['proDescr'];
$productQuantity = $formData['proQuan'];
$productCategory = $formData['proCat'];
$productStatus = $_POST['proStatus'];
$store = $formData['storeID'];

// Extract weight and price values from the arrays
$weightValues = $formData['weight'];
$priceValues = $formData['price'];
$priceNo = $formData['priceNo'];

// Validation and sanitization should be performed here

if ($act == "add") {
    // Perform the INSERT operation for 'product' table
    $sql = "INSERT INTO product (productCode, product_name, descr, quantity,  owner, product_date, status)
            VALUES ('$productCode', '$productName', '$productDescription', '$productQuantity',  '$store', '$date', '$productStatus')";

    if ($db->query($sql) === true) {
        // Get the last inserted product_id
        $lastProductID = $db->insert_id;

        // Insert data into 'tblprice' table
        foreach ($weightValues as $key => $weight) {
            $price = $priceValues[$key];

            // Perform the INSERT operation for 'tblprice' table, linking it to the last inserted 'product_id'
            $priceInsertSQL = "INSERT INTO tblprice (productID, proWeight, proPrice)
                                VALUES ('$lastProductID', '$weight', '$price')";

            if ($db->query($priceInsertSQL) !== true) {
                // Handle error if the 'tblprice' insert fails
                $valid = false;
                break;
            }
        }

        $valid = true;
    }
} 
elseif ($act == "edit") {
	$existingPricesQuery = "SELECT priceNo FROM tblprice WHERE productID = ".$productID;
	$existingPricesResult = $db->query($existingPricesQuery);
	$existingPriceNos = [];
	while ($row = $existingPricesResult->fetch_assoc()) {
		$existingPriceNos[] = $row['priceNo'];
	}
	
	$updateSQL = "UPDATE product
					SET productCode = '$productCode', product_name = '$productName', descr = '$productDescription', categories_id = '$productCategory', quantity = '$productQuantity', status = '$productStatus'
					WHERE product_id = '$productID'";
	$db->query($updateSQL);
	
	// First, delete price records that exist but are not in $priceNo
	$deleteSQL = "DELETE FROM tblprice WHERE productID = '$productID' AND priceNo NOT IN (" . implode(",", $priceNo) . ")";
	$db->query($deleteSQL);

	// Then, update the existing prices in $priceNo
	foreach ($priceNo as $index => $price) {
		$proPrice = $priceValues[$index];
		$proWeight = $weightValues[$index];

		// Use the retrieved values to update the database
		$updatePrice = "UPDATE tblprice SET proWeight = '$proWeight', proPrice = '$proPrice' WHERE priceNo = '$price'";
		$db->query($updatePrice);
	}

	
	$valid = true;
	
}
else if($act == 'del'){
	$delSQL = "UPDATE product SET status = 3 WHERE product_id = '$proID'";
	if($db->query($delSQL))
		$valid = true;
	
}

// Return a JSON response
echo json_encode($valid);
?>
