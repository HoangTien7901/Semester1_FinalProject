<?php
require_once '../../connect.php';

$staffs = mysqli_query($con, 'select * from staff');
$staffs_array = array();
while ($staff = mysqli_fetch_array($staffs)) {
    array_push($staffs_array, $staff);
}
echo json_encode($staffs_array);
