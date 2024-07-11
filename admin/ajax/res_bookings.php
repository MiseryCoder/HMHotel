<?php

require('../include/conn.php');
require('../include/essentials.php');

mngmtLogin();

// $date = date("Y-m-d");
// $lastday = date("Y-m-t", strtotime($date));

//for res_bookings
if (isset($_POST['get_bookings'])) {


    $frm_data = filteration($_POST);


    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
    AND (bo.booking_status=? AND bo.arrival=?) ORDER BY bo.booking_id DESC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "Reserved", 0], 'sssss');
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

        $discounted = "";
        if ($data['discounted'] == 1) {
            $discounted = "
            <span class='badge bg-info text-dark text-center'>Discounted $data[discount_percent]% </span>
            <br>
            ";
        } else {
            $discounted = "";
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
                    <b>Sub Total: </b> ₱$data[trans_amt]
                    <br>
                    <b>Discount: </b> $data[discount_percent]%
                    <br>
                    <b>Paid: </b> ₱$data[discounted_amt]
                    <br>
                    $balance
                </td>

                <td>
                    <span class='badge $status_bg'>$data[booking_status]</span><br>
                    $discounted
                </td>

                <td>
                    <button onclick='assign_room($data[booking_id],$data[room_id],$data[price])' type='button' class='btn btn-success shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
                        Assign Room
                    </button>
                    <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-danger shadow-none'>
                        <i class='bi bi-x-circle'></i>
                    </button>
                </td>
            </tr>
        ";

        $i++;
    }

    echo $table_data;
}



//for checkedout_bookings
if (isset($_POST['get_bookings_checkout'])) {


    $frm_data = filteration($_POST);


    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
    AND (bo.booking_status=? AND bo.arrival=?) ORDER BY bo.booking_id DESC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "Checked-Out", 1], 'ssssi');
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found!</b>";
        exit;
    }


    while ($data = mysqli_fetch_assoc($res)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("M/d/Y l", strtotime($data['check_in']));
        $checkout = date("M/d/Y l", strtotime($data['check_out']));


        $balance = "";
        if ($data['payment_type'] == 'Online Booking' && $data['payment_method'] == 'Fifty-Fifty') {
            $balance = "
            <b>Balance: </b> ₱$data[trans_amt]
            <br>
            ";
        }



        if ($data['booking_status'] == 'Booked') {
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
                    <b>Room #: </b> $data[room_no]
                    <br>
                    <b>Price: </b> ₱$data[price]
                </td>
                <td>
                    <b>Payment Type: </b> $data[payment_type]
                    <br>
                    <b>Payment Method: </b> $data[payment_method]
                    <br>
                    <b>Amount Paid: </b> ₱$data[trans_amt]
                    <br>
                    <b>Check-In: </b> $data[check_in]
                    <br>
                    <b>Check-Out: </b> $data[check_out]
                </td>

                <td>
                    <span class='badge $status_bg'>$data[booking_status]</span>
                 
                </td>
            </tr>
        ";

        $i++;
    }

    echo $table_data;
}


//for checkedout_bookings
if (isset($_POST['get_bookings_cancelled'])) {


    $frm_data = filteration($_POST);


    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
    AND (bo.booking_status='No show' OR bo.booking_status='Cancelled') ORDER BY bo.booking_id DESC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%"], 'sss');
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found!</b>";
        exit;
    }


    while ($data = mysqli_fetch_assoc($res)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("M/d/Y l", strtotime($data['check_in']));
        $checkout = date("M/d/Y l", strtotime($data['check_out']));


        $balance = "";
        if ($data['payment_type'] == 'Online Booking' && $data['payment_method'] == 'Fifty-Fifty') {
            $balance = "
            <b>Balance: </b> ₱$data[trans_amt]
            <br>
            ";
        }

        if ($data['booking_status'] == 'Booked') {
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
                    <b>Room #: </b> $data[room_no]
                    <br>
                    <b>Price: </b> ₱$data[price]
                </td>
                <td>
                    <b>Payment Type: </b> $data[payment_type]
                    <br>
                    <b>Payment Method: </b> $data[payment_method]
                    <br>
                    <b>Total Amount: </b> ₱$data[trans_amt]
                    <br>
                    <b>Check-In: </b> $data[check_in]
                    <br>
                    <b>Check-Out: </b> $data[check_out]
                </td>

                <td>
                    <span class='badge $status_bg'>$data[booking_status]</span>
                </td>
            </tr>
        ";

        $i++;
    }

    echo $table_data;
}




//for checkin_bookings
if (isset($_POST['get_bookings_checkin'])) {


    $frm_data = filteration($_POST);


    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
    AND (bo.booking_status=? AND bo.arrival=?) ORDER BY bo.booking_id DESC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "Checked-In", 1], 'sssss');
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found!</b>";
        exit;
    }


    while ($data = mysqli_fetch_assoc($res)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("M/d/Y l", strtotime($data['check_in']));
        $checkout = date("M/d/Y l", strtotime($data['check_out']));

        $extension = "";
        $extension_payment = "";
        if ($data['num_of_extensions'] > 0) {
            $extension = "
            <span class='badge bg-info text-dark text-center'>Extended to $data[num_of_extensions] Days </span>
            <br>
            ";
            $extension_payment = "<b>Amount to be Paid: </b> ₱$data[extended_price]
            <br>";
        } else {
            $extension = "";
            $extension_payment = "";
        }

        $upgrade = "";
        $upgrade_payment = "";
        $new_room = "";
        if ($data['room_upgrade'] == 1) {
            $upgrade = "
            <span class='badge bg-warning text-dark text-center'>Room Change </span>
            <br>
            ";
            $upgrade_payment = "<b>Amount to be Paid: </b> ₱$data[upgrade_price]
            <br>";

            $new_room = "<b>Previous Room: </b> $data[room_name_prev]<br>
            <b>Previous Room #: </b> $data[room_no]<br>
            <b>New Room: </b> $data[room_name]<br>
            <b>New Room #: </b> $data[room_no_upgrade]<br>
            ";
        } else {
            $upgrade = "";
            $upgrade_payment = "";
            $new_room = "
            <b>Room: </b> $data[room_name]
            <br>
            <b>Room #: </b> $data[room_no]
            <br>
            ";
        }




        $balance = "";
        if ($data['payment_type'] == 'Online Booking' && $data['payment_method'] == 'Fifty-Fifty') {
            $balance = "
            <b>Balance: </b> ₱$data[trans_amt]
            <br>
            ";
        }


        if ($data['booking_status'] == 'Booked') {
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
                    $new_room
                    <b>Price: </b> ₱$data[price]
                </td>
                <td>
                    <b>Payment Type: </b> $data[payment_type]
                    <br>
                    <b>Payment Method: </b> $data[payment_method]
                    <br>
                    <b>Amount Paid: </b> ₱$data[discounted_amt]
                    <br>
                    $upgrade_payment
      
                    $extension_payment
                    <b>Check-In: </b> $checkin
                    <br>
                    <b>Check-Out: </b> $checkout
                </td>

                <td>
                    <span class='badge $status_bg'>$data[booking_status]</span> <br>
                    $extension
                    $upgrade
                </td>

                <td>
                    <a href='change_room.php?book_id=$data[booking_id]&room_id=$data[room_id]' type='button' class='btn btn-info shadow-none'>
                        <i class='fa-solid fa-pen-to-square'></i>
                    </a>
                    <a href='upgrade_room.php?book_id=$data[booking_id]&room_id=$data[room_id]&price=$data[price]' type='button' class='btn btn-warning shadow-none'>
                        <i class='bi bi-houses-fill'></i>
                    </a>
                    
                    <button type='button' onclick='checkout($data[booking_id],$data[price])' class='btn btn-success shadow-none' data-bs-toggle='modal' data-bs-target='#checkout-room'>
                        <i class='bi bi-clipboard-check'></i>
                    </button>
                    <button type='button' onclick='download($data[booking_id])' class='btn btn-primary shadow-none'>
                        <i class='bi bi-download'></i>
                    </button>
                </td>
            </tr>
        ";


        //baka kailanganin mo 
        // <button onclick='assign_room($data[booking_id],$data[room_id],$data[price])' type='button' class='btn btn-warning shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
        //                 <i class='bi bi-houses-fill'></i>
        //             </button>

        $i++;
    }

    echo $table_data;
}

//assign rooms
if (isset($_POST['assign_room'])) {
    $frm_data = filteration($_POST);
    $status = "Checked-In";

    //if reserved
    $sql = "SELECT * FROM `booking_order`
    Inner JOIN `rooms` ON `booking_order`.room_id = `rooms`.room_id
     WHERE `booking_id`='$frm_data[booking_id]'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['booking_status'] == 'Reserved' && $row['payment_method'] == 'Fifty-Fifty') {
                $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
                            ON bo.booking_id = bd.booking_id
                            SET bo.arrival = ?, bo.rate_review = ?, bd.room_no = ?, bo.trans_amt = ?, bo.booking_status=?
                            WHERE bo.booking_id = ?";

                $values = [1, 0, $frm_data['room_no'], $frm_data['amount_price'], $status, $frm_data['booking_id']];
                $res = update($query, $values, 'iisisi');

                echo ($res == 2) ? 1 : 0; // it will update 2 rows so it will return 2
            } else {
                if($row['room_ntype']=='Rooms'){
                    $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
                                ON bo.booking_id = bd.booking_id
                                SET bo.arrival = ?, bo.rate_review = ?, bd.room_no = ?, bo.booking_status=?
                                WHERE bo.booking_id = ?";
    
                    $values = [1, 0, $frm_data['room_no'], $status, $frm_data['booking_id']];
                    $res = update($query, $values, 'iissi');
    
                    echo ($res == 2) ? 1 : 0; // it will update 2 rows so it will return 2
                    
                } else{
                    $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
                                ON bo.booking_id = bd.booking_id
                                SET bo.arrival = ?, bo.rate_review = ?, bo.booking_status=?
                                WHERE bo.booking_id = ?";
    
                    $values = [1, 0, $status, $frm_data['booking_id']];
                    $res = update($query, $values, 'iisi');
    
                    echo ($res == 2) ? 1 : 0; // it will update 2 rows so it will return 2
                }
            }
        }
    }
}


//change of rooms
if (isset($_POST['change_room'])) {
    $frm_data = filteration($_POST);
    $status = "Checked-In";

    //if reserved
    $sql = "SELECT * FROM `booking_order` WHERE `booking_id`='$frm_data[booking_id]'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
                            ON bo.booking_id = bd.booking_id
                            SET bd.room_no = ?
                            WHERE bo.booking_id = ?";

            $values = [$frm_data['room_no'], $frm_data['booking_id']];
            $res = update($query, $values, 'si');

            echo ($res == 1) ? 1 : 0; // it will update 2 rows so it will return 2
        }
    }
}


//for checking out the bookings
if (isset($_POST['checkout_room'])) {
    $frm_data = filteration($_POST);
    $status = "Checked-Out";

    //if booked
    $sql = "SELECT * FROM `booking_order` WHERE `booking_id`='$frm_data[booking_id]'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['booking_status'] == 'Checked-In' && $row['payment_method'] == 'Fifty-Fifty') {
                $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
                            ON bo.booking_id = bd.booking_id
                            SET bo.rate_review = ?, bo.booking_status=?
                            WHERE bo.booking_id = ?";

                $values = [0, $status, $frm_data['booking_id']];
                $res = update($query, $values, 'isi');

                echo ($res == 1) ? 1 : 0; // it will update 2 rows so it will return 2
            } else {
                $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
                            ON bo.booking_id = bd.booking_id
                            SET bo.rate_review = ?, bo.booking_status=?
                            WHERE bo.booking_id = ?";

                $values = [0, $status, $frm_data['booking_id']];
                $res = update($query, $values, 'isi');

                echo ($res == 1) ? 1 : 0; // it will update 2 rows so it will return 2
            }
        }
    }
}


// get room and the id
if (isset($_POST['get_room'])) {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `rooms` WHERE `room_id`=?", [$frm_data['get_room']], 'i');
    $res4 = select("SELECT * FROM `room_no_data` WHERE `room_id`=?", [$frm_data['get_room']], 'i');

    $res2 = select("SELECT r.room_nos 
    FROM room_no r
    INNER JOIN room_no_data rnd ON r.id = rnd.room_no_id 
    INNER JOIN rooms ON rnd.room_id = rooms.room_id 
    WHERE rooms.room_id = ?", [$frm_data['get_room']], 'i');

    $roomdata = mysqli_fetch_assoc($res1);
    $room_id = $frm_data['get_room'];
    $room_nos = [];


    if (mysqli_num_rows($res2) > 0) {
        while ($row = mysqli_fetch_assoc($res2)) {
            array_push($room_nos, $row['room_nos']);
        }
    }

    $data = ["roomdata" => $roomdata, "room_nos" => $room_nos, "room_id" => $room_id];

    $data = json_encode($data);

    echo $data;
}



//for canceling the booking request
if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id` = ?";
    $values = ['Cancelled', 0, $frm_data['booking_id']];

    $res = update($query, $values, 'sii');
    echo ($res);
}
