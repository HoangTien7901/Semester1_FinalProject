<?php
require_once "../../connect.php";
session_start();
$target = mysqli_query($con, '
select id from user where user_name = "' . $_SESSION['user_login'] . '"
');
$user_array = array();
while ($user = mysqli_fetch_array($target)) {
    array_push($user_array, $user);
}
$user_id = $user_array[0]['id'];

$organized_evs = mysqli_query($con, '
select ev.event_name as event_name, ce.name as category_name, oe.image as image, rv.content as review, oe.date as date, oe.id as id, staff.name as staff
from user, review rv, event ev, category_event ce, organized_events oe, staff
where oe.event_id = ev.id and oe.event_id_category = ce.event_id and oe.user_id = user.id and user.id = ' . $user_id . ' and staff.id = oe.staff_id and oe.review_id = rv.id 
');
$organized_evs_array = array();
while ($organized_ev = mysqli_fetch_array($organized_evs)) {
    array_push($organized_evs_array, $organized_ev);
}
echo json_encode($organized_evs_array);
