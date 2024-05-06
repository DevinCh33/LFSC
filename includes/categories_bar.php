<div class="categories">
    <?php
    $query = "SELECT categories_id, categories_name FROM categories WHERE categories_status = 1";
    $result = mysqli_query($db, $query);
    
    $count = 0; // Initialize counter
    
    while ($row = mysqli_fetch_assoc($result)) {
        if ($count < 6) {
            // Display categories as buttons
            echo '<a href="search.php?category='.$row["categories_id"].'" class="btn btn-outline-info category" role="button">'.$row["categories_name"].'</a>';
        } else {
            // Add remaining categories to dropdown menu
            if ($count == 6) {
                echo '<div class="dropdown">';
                echo '<button class="btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                echo 'More Categories';
                echo '</button>';
                echo '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            }
            echo '<a class="dropdown-item" href="search.php?category='.$row["categories_id"].'">'.$row["categories_name"].'</a>';
        }
        $count++; // Increment counter
    }
    
    // Close dropdown menu if there are more than 6 categories
    if ($count >= 6) {
        echo '</div>'; // Close dropdown-menu
        echo '</div>'; // Close dropdown
    }
    ?>
</div>
