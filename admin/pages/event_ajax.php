<?php
require_once '../../connect.php';

$events = mysqli_query($con, '
select event.id as id, event.description as description, event.cost as cost, event.event_name as name, ce.name as event_name, ce.event_id as category_id, event.image as image
from event, category_event ce
where ce.event_id = event.event_id_category
order by event.id asc
');

$events_array = array();
while ($event = mysqli_fetch_array($events)) {
	array_push($events_array, $event);
}
echo json_encode($events_array);
