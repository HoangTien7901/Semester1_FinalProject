<?php
require_once '../../connect.php';

$users = mysqli_query($con, 'select * from user');
$users_array = array();
while ($user = mysqli_fetch_array($users)) {
    array_push($users_array, $user);
}
echo json_encode($users_array);
