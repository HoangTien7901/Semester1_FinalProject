<?php
require_once '../connect.php';

if (isset($_GET['action'])) {
  if ($_GET['action'] == 'addReview') {
    $user_name = $_GET['user_name'];
    $event_id = $_GET['event_id'];
    $content = $_GET['content'];
    $date = date("Y/m/d");
    mysqli_query($con, 'insert into review(event_id,content,user_name,date) values("' . $event_id . '","' . $content . '","' . $user_name . '",STR_TO_DATE("' . $date . '", "%Y/%m/%d"))');
  }
}

$reviews = mysqli_query($con, '
select rv.content as content,rv.user_name as user_name,rv.date as date,ce.name as category_name
from review rv, category_event ce
where rv.event_id = ce.event_id
order by date DESC');

$reviews_array = array();
while ($review = mysqli_fetch_array($reviews)) {
  array_push($reviews_array, $review);
}
echo json_encode($reviews_array);
