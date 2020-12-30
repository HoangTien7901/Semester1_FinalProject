<?php
require_once '../../connect.php';

$reviews = mysqli_query($con,
'select rv.id as id, rv.content as content, rv.date as date
from review rv');

$reviews_array = array();
while ($review = mysqli_fetch_array($reviews)) {
    array_push($reviews_array, $review);
}
echo json_encode($reviews_array);
