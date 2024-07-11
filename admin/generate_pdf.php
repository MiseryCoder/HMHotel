<?php
require('include/conn.php');
require('include/essentials.php');
require('include/mpdf/vendor/autoload.php');

mngmtLogin();


//eto ung pangkuha nung data sa database sa table na contact_details
$contact_q = "SELECT * FROM `contact_details` WHERE `contact_ID`=?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));

// eto ung pangkuha nung data sa database sa table na about_details
$title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=?";
$values = [1];
$title_r = mysqli_fetch_assoc(select($title_q, $values, 'i')); //select function sa admin/include/conn.php


if (isset($_GET['gen_pdf']) && isset($_GET['id'])) {
    $frm_data = filteration($_GET);

    $query = "SELECT bo.*, bd.*, uc.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    INNER JOIN `guests_users` uc ON bo.user_id = uc.id
    WHERE bo.booking_id = '$frm_data[id]'";

    $res = mysqli_query($con, $query);

    $total_rows = mysqli_num_rows($res);

    if ($total_rows == 0) {
        header('location: index.php');
        exit;
    }

    $data = mysqli_fetch_assoc($res);

    $date = date("h:ia | d-m-Y", strtotime($data['datentime']));
    $checkin = date("h:ia | d-m-Y", strtotime($data['check_in']));
    $checkout = date("h:ia | d-m-Y", strtotime($data['check_out']));
    $checkin_d = new DateTime($data['check_in']);
    $checkout_d = new DateTime($data['check_out']);

    $interval = $checkin_d->diff($checkout_d);
    $count_days = $interval->days;




    $table_data = "
        <head>
            <link rel='stylesheet' href='https://use.fontawesome.com/releases/v6.2.0/css/all.css' />
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css' />
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css'>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css' integrity='sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=' crossorigin='anonymous' />
            </head>
        <style>
            
            @media print {
        body {
            margin: 0;
            padding: 1cm; /* Adjust this value to set the margin for the PDF */
        }


        .container {
            width: 100%;
        }

        .card {
            box-shadow: none;
            border: none;
        }

        .table {
            font-size: 16px; /* Adjust this value to set the font size for the table */
            line-height: 1.5;
            margin-top: 20px;
        }

    }
        </style>

        <div class='container'>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='card'>
                    <div class='card-body'>
                        <div class='invoice-title'>
                            <h4 class='float-end font-size-15'><b>Order ID: </b>$data[order_id]<span class='badge bg-success font-size-12 ms-2' style='padding: 10px;'>$data[booking_status]</span></h4>
                            <div class='mb-4'>
                                <h2 class='mb-1 text-muted'>
                                    $title_r[site_title]
                                </h2>
                            </div>
                            <div class='text-muted'>
                                <p class='mb-1'>$contact_r[address]</p>
                                <p class='mb-1'><i class='uil uil-envelope-alt me-1'></i>$contact_r[email]</p>
                                <p><i class='uil uil-phone me-1'></i>$contact_r[pn1]</p>
                            </div>
                        </div>

                        <hr class='my-4'>

                        <div class='row'>
                            <div class='col-sm-6'>
                                <div class='text-muted'>
                                    <h5 class='font-size-16 mb-3'>Billed To:</h5>
                                    <h5 class='font-size-15 mb-2'>$data[user_name]</h5>
                                    <p class='mb-1'>$data[address]</p>
                                    <p class='mb-1'>$data[email]</p>
                                    <p>$data[phonenum]</p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class='col-sm-6'>
                                <div class='text-muted text-sm-end'>
                                    <div class='mt-4'>
                                        <h5 class='font-size-15 mb-1'>Invoice Date:</h5>
                                        <p>$date</p>
                                    </div>
                                    <div class='mt-4'>
                                        <h5 class='font-size-15 mb-1'>Order No:</h5>
                                        <p>$data[order_id]</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->


                        <div class='py-2'>
                            <h5 class='font-size-15'>Booking Summary</h5>
                            <h3><span style='font-weight:bold'>Room/Facility:</span> $data[room_name]</h3>
                            <h3><span style='font-weight:bold'>Price:</span>₱ $data[price]</h3>
                            <h3><span style='font-weight:bold'>Check-in:</span> $checkin</h3>
                            <h3><span style='font-weight:bold'>Check-out:</span> $checkout</h3>
                            <h3><span style='font-weight:bold'>Number of Days:</span> $count_days</h3>

                            <div class='table-responsive'>
                                <table class='table align-middle table-nowrap table-centered mb-0'>
                                    <thead>
                                        <tr>
                                            <th class='text-end' style='width: 120px; font-size: 15px;'>Total</th>
                                        </tr>
                                    </thead>
                                    <!-- end thead -->
                                    <tbody>

                                        <!-- end tr -->
                                        <tr>
                                            <td>Sub Total</td>
                                            <td>₱ $data[trans_amt]</td>
                                        </tr>
                                        <!-- end tr -->

                                        <tr>
                                            <td>Tax</td>
                                            <td>₱ 00.00</td>
                                        </tr>
                                        <!-- end tr -->

                                        <tr>
                                            
                                            <td class='border-0'>Total</td>
                                            <td class='border-0'>
                                                <h4 class='m-0 fw-semibold'>₱ $data[trans_amt]</h4>
                                            </td>
                                        </tr>
                                        <!-- end tr -->
                                    </tbody>
                                    <!-- end tbody -->
                                </table>
                                <!-- end table -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
    
    ";

    // echo $table_data;

    $mpdf = new \Mpdf\Mpdf();

    $mpdf->WriteHTML($table_data);

    // Output a PDF file directly to the browser
    $mpdf->Output($data['order_id'] . '.pdf', 'D');
} else {
    header('location: dashboard.php');
}
