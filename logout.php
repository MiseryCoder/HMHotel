<?php
require('admin/include/essentials.php');
require('admin/include/conn.php');

session_start();

//for system logs
$sys_email = "";
$sys_name = "";
$sys_action = "Logged out";
$sys_user_type = "Guest User";

// gettingall the rooms for the select tag and input the room types
$room = $con->query("SELECT * FROM `guests_users` WHERE `id`='$_SESSION[uId]'");
foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
    $sys_email = $row['email'];
    $sys_name = $row['name'];
}
$query = "INSERT INTO `systemlog`(`email`,`name`,`action`,`User_type`) VALUES (?,?,?,?)";
$values = [$sys_email, $sys_name, $sys_action, $sys_user_type];
$res = insert($query, $values, 'ssss');
session_destroy();
redirect('index.php');
