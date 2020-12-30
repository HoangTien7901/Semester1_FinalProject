<?php
require_once "../../connect.php";
session_start();


if (isset($_GET['action'])) {
	// get themes base on category
	if ($_GET['action'] == 'changeCategory') {
		$categoryId = $_GET['categoryId'];
		$events = mysqli_query($con, '
		select id, event_name
		from event
		where event_id_category = ' . $categoryId);
		$events_array = array();
		while ($event = mysqli_fetch_array($events)) {
			array_push($events_array, $event);
		}
		echo json_encode($events_array);
	}
} else {
	// get default value
	$organized_evs = mysqli_query($con, '
		select ev.event_name as event_name, ce.name as category_name, oe.image as image,
		rv.content as review, oe.date as date, oe.id as id, staff.name as staff, user.user_name as user_name,
		oe.event_id as theme_id, oe.event_id_category as category_id,
		oe.user_id as user_id, oe.review_id as review_id, oe.staff_id as staff_id

		from user, review rv, event ev, category_event ce, organized_events oe, staff

		where oe.event_id = ev.id and oe.event_id_category = ce.event_id and oe.review_id = rv.id and
		user.id = oe.user_id and oe.staff_id = staff.id
    ');
	$organized_evs_array = array();
	while ($organized_ev = mysqli_fetch_array($organized_evs)) {
		array_push($organized_evs_array, $organized_ev);
	}
	echo json_encode($organized_evs_array);
}
