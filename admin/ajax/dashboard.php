<?php

require('../include/conn.php');
require('../include/essentials.php');

mngmtLogin();

//for booking analytics
if (isset($_POST['booking_analytics'])) {

    
    $frm_data = filteration($_POST);
    $condition = "";

    if($frm_data['period']==1){
        $condition="WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
    } 
    else if($frm_data['period']==2){
        $condition="WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
    }
    else if($frm_data['period']==3){
        $condition="WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    $result = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
    COALESCE(COUNT(CASE WHEN booking_status='Checked-out' THEN 1 END), 0) AS `total_bookings`,
    COALESCE(SUM(CASE WHEN booking_status='Checked-out' THEN `trans_amt` END), 0) AS `total_amt`,
    
    COALESCE(COUNT(CASE WHEN booking_status='Booked' AND arrival=1 THEN 1 END), 0) AS `active_bookings`,
    COALESCE(SUM(CASE WHEN booking_status='Booked' AND arrival=1 THEN `trans_amt` END), 0) AS `active_amt`,
    
    COALESCE(COUNT(CASE WHEN booking_status='Cancelled' AND refund=1 THEN 1 END), 0) AS `cancelled_bookings`,
    COALESCE(SUM(CASE WHEN booking_status='Cancelled' AND refund=1 THEN `trans_amt` END), 0) AS `cancelled_amt`,

    COALESCE(COUNT(CASE WHEN booking_status='Cancelled' AND refund=0 THEN 1 END), 0) AS `req_refund`,
    COALESCE(SUM(CASE WHEN booking_status='Cancelled' AND refund=0 THEN `trans_amt` END), 0) AS `req_refund_amt`
    
    FROM `booking_order` $condition"));


    $output = json_encode($result);

    echo $output;
}


//for user analytics
if (isset($_POST['user_analytics'])) {

    
    $frm_data = filteration($_POST);
    $condition = "";

    if($frm_data['period']==1){
        $condition="WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
    } 
    else if($frm_data['period']==2){
        $condition="WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
    }
    else if($frm_data['period']==3){
        $condition="WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    $total_review = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(rating_id) AS `count` 
    FROM `rating_review` $condition"));
    
    $total_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(uqueries_id) AS `count` 
    FROM `user_queries` $condition"));

    $total_new_reg = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count` 
    FROM `guests_users` $condition"));

    $output = ['total_queries'=>$total_queries['count'],
                'total_new_reg'=>$total_new_reg['count'],
                'total_review'=>$total_review['count']
            ];

    $output = json_encode($output);

    echo $output;

}
