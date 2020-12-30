<?php
require_once '../../connect.php';

$categories = mysqli_query($con, 'select * from category_event');
$categories_array = array();
while ($category = mysqli_fetch_array($categories)) {
    array_push($categories_array, $category);
}
echo json_encode($categories_array);
