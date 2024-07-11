<?php

require('../include/conn.php');
require('../include/essentials.php');

mngmtLogin();

// $date = date("Y-m-d");
// $lastday = date("Y-m-t", strtotime($date));
if (isset($_POST['get_bookings'])) {


    $frm_data = filteration($_POST);


    $query = "SELECT * FROM room_no";

    $res = mysqli_query($con, $query);
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found!</b>";
        exit;
    }


    while ($data = mysqli_fetch_assoc($res)) {

        $balance = "";

        $table_data .= "
            <tr>
                <td>
                    $data[room_nos]
                </td>
                <td>
                   $data[room_avail]
                </td>
                <td>
                    $data[room_status]

                </td>

                <div>
                    <td>
                        <button onclick='update_res($data[id])' type='button' class='btn btn-success shadow-none' data-bs-toggle='modal' data-bs-target='#house-edit'>
                            <i class='bi bi-pencil-square'></i>
                        </button>
                    </td>
                </div>
            </tr>
        ";
    }

    echo $table_data;
}


if (isset($_POST['house_room'])) {
    $frm_data = filteration($_POST);
    $status = "Reserved";

    //if booked
    $sql = "SELECT * FROM `room_no` WHERE `id`='$frm_data[room_id]'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if($frm_data['rstatus'] =='VC'){
                $avail_stats = "Checking";
            } else if($frm_data['rstatus'] =='VD'){
                $avail_stats = "CHecked-Out";
            } else if($frm_data['rstatus'] =='VR'){
                $avail_stats = "Avaliable";
            } else if($frm_data['rstatus'] =='OC'){
                $avail_stats = "Checked-In";
            } else if($frm_data['rstatus'] =='OD'){
                $avail_stats = "Checked-Out";
            } else if($frm_data['rstatus'] =='OOO'){
                $avail_stats = "Maintenance";
            }
            $query = "UPDATE `room_no` SET `room_status` = ?, `room_avail`= ? WHERE id = ?";

            $values = [$frm_data['rstatus'], $avail_stats, $frm_data['room_id']];
            $res = update($query, $values, 'ssi');

            echo ($res == 1) ? 1 : 0; // it will update 2 rows so it will return 2
        }
    }
}



// if (isset($_POST['cancel_booking'])) {
//     $frm_data = filteration($_POST);

//     $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id` = ?";
//     $values = ['Cancelled', 0, $frm_data['booking_id']];

//     $res = update($query, $values, 'sii');
//     echo ($res);
// }
