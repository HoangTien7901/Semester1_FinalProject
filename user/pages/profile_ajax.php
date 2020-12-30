<?php
require_once '../../connect.php';
session_start();

$user = mysqli_query($con, 'select * from user where id =' . $_SESSION['user_id']);
$user_array = mysqli_fetch_array($user);
echo json_encode($user_array);
