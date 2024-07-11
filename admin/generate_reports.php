<?php
require('include/conn.php');
require('include/essentials.php');
require('include/mpdf/vendor/autoload.php');

date_default_timezone_set("Asia/Manila");

mngmtLogin();

// Get contact details from the database
$contact_q = "SELECT * FROM `contact_details` WHERE `contact_ID`=?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));

// Get about details from the database
$title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=?";
$values = [1];
$title_r = mysqli_fetch_assoc(select($title_q, $values, 'i'));

if (isset($_GET['gen_reports'])) {
    $currentDate = date("Y-m-d");

    // Fetch data from the database for the current date
    $query = mysqli_query($con, "SELECT bo.*, bd.*, uc.* FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
        INNER JOIN `guests_users` uc ON bo.user_id = uc.id");

    // Check if there is any data
    if ($data = mysqli_fetch_assoc($query)) {

        $total_sales = 0;
        $room_sales = [];

        while ($data = mysqli_fetch_assoc($query)) {
            $trans_amt = $data['trans_amt'];
            $extended_price = $data['extended_price'];

            // Calculate total sales for the day
            $total_sales += ($trans_amt + $extended_price);

            // Record room sales
            $room_name = $data['room_name'];
            if (!isset($room_sales[$room_name])) {
                $room_sales[$room_name] = 0;
            }
            $room_sales[$room_name] += ($trans_amt + $extended_price);
        }

        // Initialize table_data
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
                        padding: 1cm;
                    }

                    .container {
                        width: 100%;
                    }

                    .card {
                        box-shadow: none;
                        border: none;
                    }

                    .table {
                        font-size: 16px;
                        line-height: 1.5;
                        margin-top: 20px;
                    }
                }
            </style>
        ";

        // Build the table_data using fetched data
        $table_data .= "
            <div class='container'>
                <h3>Total Sales for the day: $total_sales</h3>
            </div>
        ";

        // Initialize MPDF
        $mpdf = new \Mpdf\Mpdf();

        // Write HTML to MPDF
        $mpdf->WriteHTML($table_data);

        // Output PDF to the browser
        $mpdf->Output(date('Y-m-d') . '_Reports.pdf', 'D');
    } else {
        echo "No data found for the current date.";
    }
} else {
    header('location: dashboard.php');
}
