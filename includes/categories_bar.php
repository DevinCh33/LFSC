<div class="categories">
<?php
$query = "SELECT categories_id, categories_name FROM categories WHERE categories_status = 1";
$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<a href="search.php?category='.$row["categories_id"].'" class="btn btn-outline-info category" role="button">'.$row["categories_name"].'</a>';
}
?>
</div>
