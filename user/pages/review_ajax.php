<?php
require_once '../../connect.php';
session_start();

// get review id
$target_row = mysqli_query($con, '
select review_id from organized_events where user_id = ' . $_SESSION['user_id']);
$target_array = array();
while ($result = mysqli_fetch_array($target_row)) {
	array_push($target_array, $result);
}
$review_id = $target_array[0]['review_id'];

// get review details
$reviews = mysqli_query(
	$con,
	'select id, content, date
    from review
    where id = ' . $review_id
);
$reviews_array = array();
while ($review = mysqli_fetch_array($reviews)) {
	array_push($reviews_array, $review);
}
echo json_encode($reviews_array);
