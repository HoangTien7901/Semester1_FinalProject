<?php
require_once '../../connect.php';

$admin = mysqli_query($con, 'select * from user');
$admin_array = mysqli_fetch_array($admin);
echo json_encode($admin_array);
