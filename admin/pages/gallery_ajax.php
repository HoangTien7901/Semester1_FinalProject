<?php
require_once '../../connect.php';

$images = mysqli_query($con, 
'select ce.name as category_name, gl.image_name as image_name, gl.id as id, gl.category_id as category_id
from gallery gl, category_event ce
where ce.event_id = gl.category_id
');
$images_array = array();
while ($image = mysqli_fetch_array($images)) {
    array_push($images_array, $image);
}
echo json_encode($images_array);
