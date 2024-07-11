<?php

require('../include/conn.php');
require('../include/essentials.php');
require('../include/mailer.php');

mngmtLogin();

// $date = date("Y-m-d");
// $lastday = date("Y-m-t", strtotime($date));
if (isset($_POST['get_bookings'])) {


    $frm_data = filteration($_POST);




    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
    AND (bo.booking_status=? AND bo.arrival=?) ORDER BY bo.booking_id DESC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "Booked", 0], 'sssss');
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found!</b>";
        exit;
    }


    while ($data = mysqli_fetch_assoc($res)) {
        $date = date("M/d/Y l", strtotime($data['datentime']));
        $checkin = date("M/d/Y l", strtotime($data['check_in']));
        $checkout = date("M/d/Y l", strtotime($data['check_out']));

        $balance = "";
        if ($data['payment_type'] == 'Online Booking' && $data['payment_method'] == 'Fifty-Fifty') {
            $balance = "
            <b>Balance: </b> ₱$data[trans_amt]
            <br>
            ";
        }

        if ($data['booking_status'] == 'Booked' || $data['booking_status'] == 'Reserved') {
            $status_bg = 'bg-success';
        } else if ($data['booking_status'] == 'Cancelled') {
            $status_bg = 'bg-danger';
        } else {
            $status_bg = 'bg-warning text-dark';
        }

        $table_data .= "
            <tr>
                <td>$i</td>
                <td>
                    <span class='badge bg-success'>
                        Order ID: $data[order_id]
                    </span>
                    <br>
                    <b>Name: </b> $data[user_name]
                    <br>
                    <b>Phone #: </b> $data[phonenum]
                </td>
                <td>
                    <b>Room: </b> $data[room_name]
                    <br>
                    <b>Price: </b> ₱$data[price]
                    <br>
                    <b>Payment Method: </b> $data[payment_method]
                    <br>
                    <b>Payment Type: </b> $data[payment_type]
                </td>
                <td>
                    <b>Check-in: </b> $checkin
                    <br>
                    <b>Check-out: </b> $checkout
                    <br>
                    <b>Date of Booking: </b> $date
                    <br>
                    <b>Amount to be Paid: </b> ₱$data[trans_amt]
                    <br>
                    $balance
                </td>

                <td>
                    <span class='badge $status_bg'>$data[booking_status]</span>
                </td>
                <td>
                    <button type='button' onclick=\"valid_id_proof($data[user_id])\" class='btn btn-success shadow-none' data-bs-toggle='modal' data-bs-target='#valid_id'>

                            <i class='bi bi-images'></i> 
                     
                    </button>
                </td>

                <div>
                    <td>
                        <button onclick='update_res($data[booking_id])' type='button' class='btn btn-success shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
                            Paid
                        </button>
                        <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-danger shadow-none'>
                            <i class='bi bi-x-circle'></i>
                        </button>
                    </td>
                </div>
            </tr>
        ";

        $i++;
    }

    echo $table_data;
}

//pang reserve to, kasama na ung apply discount
if (isset($_POST['assign_room'])) {
    $frm_data = filteration($_POST);

    $status = "Reserved";

    $sql = "SELECT *
            FROM `booking_order` AS bo
            INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
            WHERE bo.`booking_id` = '$frm_data[booking_id]'";
    $emailSender = "";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $emailSender = $row['email'];


            if ($row['booking_status'] == 'Booked' && $row['payment_method'] == 'Fifty-Fifty') {
                $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
                            ON bo.booking_id = bd.booking_id
                            SET bo.rate_review = ?, bo.booking_status=?
                            WHERE bo.booking_id = ?";

                $values = [0, $status, $frm_data['booking_id']];
                $res = update($query, $values, 'isi');

                echo ($res == 1) ? 1 : 0;
            } else {
                $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
          ON bo.booking_id = bd.booking_id
          SET bo.rate_review = ?, bo.booking_status=?, bo.discounted_amt=?, bo.discounted=?, bo.discount_percent=?
          WHERE bo.booking_id = ?";

                if ($frm_data['discount_percent'] == 0) {
                    $values = [0, $status, $frm_data['amount_discounted'], 0, $frm_data['discount_percent'], $frm_data['booking_id']];
                    $res = update($query, $values, 'isiiii');
                    $typeSend = "Completed_trans";
    
                    // Save the result of send_notif in a variable
                    send_notif($frm_data['booking_id'], $emailSender, $typeSend);
    
                    // var_dump($res);  // Add this line for debugging
                    echo ($res == 1) ? 1 : 0;
                } else {
                    $values = [0, $status, $frm_data['amount_discounted'], 1, $frm_data['discount_percent'], $frm_data['booking_id']];
                    $res = update($query, $values, 'isiiii');
                    $typeSend = "Completed_trans";
    
                    // Save the result of send_notif in a variable
                    send_notif($frm_data['booking_id'], $emailSender, $typeSend);
    
                    // var_dump($res);  // Add this line for debugging
                    echo ($res == 1) ? 1 : 0;
                }

            }
        }
    }
}


//proccess for cancellation
if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);
    $typeSend = "Cancelled_Room";

    // Make sure $frm_data['booking_id'] is set and has a value
    if (isset($frm_data['booking_id']) && $frm_data['booking_id'] != '') {
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id` = ?";
        $values = ['Cancelled', 1, $frm_data['booking_id']];

        $res = update($query, $values, 'sii');

        $user_res = select("SELECT *
            FROM `booking_order` AS bo
            INNER JOIN `booking_details` AS bd ON bo.booking_id = bd.booking_id
            WHERE bo.booking_id = ?", [$frm_data['booking_id']], 'i');

        $booking_data = mysqli_fetch_assoc($user_res);

        $emailSender = $booking_data['email'];

        send_notif($frm_data['booking_id'], $emailSender, $typeSend);
        echo ($res);
    } else {
        echo "Invalid or missing booking_id";
    }
}




//para makuha sa modal ung mga pictures
//pag ma display sa modal ung mga ininput mo na images sa database
if (isset($_POST['get_id_images'])) {
    $frm_data = filteration($_POST);
    $res = select("SELECT * FROM `guests_users` WHERE `id`=?", [$frm_data['get_id_images']], 'i');

    $path = SITE_URL . 'img/users/proof/';

    while ($row = mysqli_fetch_assoc($res)) {

        echo <<<data
            Name: $row[name]<br>
            <tr class='align-middle'>
                <td><img src='$path$row[idpic]' class='img-fluid text-center'></td>
            </tr>

        data;
    }
}
