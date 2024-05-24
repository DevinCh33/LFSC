<?php
require_once 'core.php';

// Retrieve and sanitize inputs
$adm_img = $_FILES['newShopPic']; // File object
$adm_username = addslashes($_POST['ownerUser']);
$adm_name = addslashes($_POST['ownerName']);
$adm_email = addslashes($_POST['ownerEmail']);
$adm_contact = addslashes($_POST['ownerNumber']);
$shopTitle = addslashes($_POST['shopTitle']);
$shopEmail = addslashes($_POST['shopEmail']);
$shopNum = addslashes($_POST['shopNumber']);
$shopDescr = addslashes($_POST['shopDescr']);

// Update admin table query
$sql = "UPDATE admin SET 
            adm_Name = '".$adm_name."', 
            username = '".$adm_username."', 
            email = '".$adm_email."', 
            contact_num = '".$adm_contact."'";

// Check if a new image is uploaded
if ($adm_img['error'] == 0 && $adm_img != "") {
    // Generate a unique filename
    $unique_code = uniqid(); // Generates a unique ID based on the current time in microseconds
    $file_extension = pathinfo($adm_img['name'], PATHINFO_EXTENSION);
    $image_path = 'Res_img/' . $unique_code . '.' . $file_extension;
    
    // Move uploaded file to the new path
    move_uploaded_file($adm_img['tmp_name'], '../'.$image_path);
    
    // Update $shopSQL with the new image path
    $shopSQL = "UPDATE restaurant SET 
                    email = '".$shopEmail."', 
                    phone = '".$shopNum."', 
                    title = '".$shopTitle."', 
                    description = '".$shopDescr."', 
                    image = '".$image_path."' 
                WHERE rs_id = '".$_SESSION['store']."'";
} else {
    // Update $shopSQL without the image path
    $shopSQL = "UPDATE restaurant SET 
                    email = '".$shopEmail."', 
                    phone = '".$shopNum."', 
                    title = '".$shopTitle."', 
                    description = '".$shopDescr."' 
                WHERE rs_id = '".$_SESSION['store']."'";
}

// Execute queries
$updateAdmin = $db->query($sql);
$updateRestaurant = $db->query($shopSQL);

// Check if both queries executed successfully
if ($updateAdmin && $updateRestaurant) {
    $output = "UPDATE SUCCESSFULLY";
} else {
    $output = "UPDATE FAILED";
}

// Return response
echo json_encode($output);
?>
