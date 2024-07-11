<?php
require('include/essentials.php');
require('include/conn.php');

session_start();

//for system logs
$sys_email = "";
$sys_name = "";
$sys_action = "Logged out";
$sys_user_type = "";

// gettingall the rooms for the select tag and input the room types
$room = $con->query("SELECT * FROM `management_users` WHERE `m_id`='$_SESSION[mngmtID]'");
foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
    $sys_email = $row['m_email'];
    $sys_name = $row['m_name'];
    $sys_user_type = $row['m_type'];
}
$query = "INSERT INTO `systemlog`(`email`,`name`,`action`,`User_type`) VALUES (?,?,?,?)";
$values = [$sys_email,$sys_name,$sys_action,$sys_user_type];
$res = insert($query, $values, 'ssss');

session_destroy();
redirect('index.php');
