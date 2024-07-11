<?php
require('include/conn.php');
require('include/essentials.php');

//session nasa include/essential.php
mngmtLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <link rel="icon" type="image" href="../img/logo.png">
    <link rel="stylesheet" href="../css/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
    <script src="../jquery/chart.js"></script>
    <title>HM Hotel | Dashboard</title>

    <style>
        #Dashactive {
            font-weight: bolder;
            color: #198754;
        }

        #Dashactive:hover {
            color: #198754;
        }
    </style>
</head>

<body>
    <?php
    require('include/Mnavigation.php');

    $room_type = '';

    $date = date("Y-m-d");
    $lastday = date("Y-m-t", strtotime($date));

    //pagshinutdown ang website
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con, "SELECT `shutdown` FROM `about_details`"));

    //total no. of new bookings and refunnds
    $current_bookings = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
                        COUNT(CASE WHEN booking_status='Booked' OR booking_status='Reserved' AND arrival=0 THEN 1 END) AS `new_bookings`,
                        COUNT(CASE WHEN booking_status='Cancelled' AND refund=0 THEN 1 END) AS `refund_bookings`
                        FROM `booking_order`"));

    //comments and concern
    $unread_queries = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(uqueries_id) AS `count` 
                                        FROM `user_queries` WHERE `seen`=0"));
    //rate and reviews
    $unread_reviews = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(rating_id) AS `count` 
                                        FROM `rating_review` WHERE `seen`=0"));


    //total no. of new bookings and refunnds
    $current_users = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
                        COUNT(id) AS `total`,
                        COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`,
                        COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`,
                        COUNT(CASE WHEN `is_verified`=0 THEN 1 END) AS `unverified`
                        FROM `guests_users`"));


    $roomss = $con->query("SELECT * FROM `rooms` LIMIT 1");
    $room_ress = [];
    foreach ($roomss->fetch_all(MYSQLI_ASSOC) as $rows) {
        $room_ress = $rows['room_id'];
    }
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <?php
                if ($is_shutdown['shutdown']) {
                    echo <<<data
                                <div class="col-lg-12 mb-3 d-flex justify-content-lg-start justify-content-center">
                                    <h6 class="badge bg-danger py-2 px-3 rounded" style="z-index: 0;">Shutdown Mode is Active!</h6>
                                </div>
                            data;
                }
                ?>


                <div class="mb-1">
                    <h4>Booking Overview</h4>
                </div>

                <div class="row mb-1">
                    <div class="col-md-3 mb-3">
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center bg-success text-white p-2">
                                <h6 class="fw-bold">New Bookings</h6>
                                <h1><?php echo $current_bookings['new_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-3">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center bg-info text-white p-2">
                                <h6 class="fw-bold">User Messages</h6>
                                <h1><?php echo $unread_queries['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="rate_review.php" class="text-decoration-none">
                            <div class="card text-center bg-dark text-white p-2">
                                <h6 class="fw-bold">Rating & Reviews</h6>
                                <h1><?php echo $unread_reviews['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="generate_reports.php?gen_reports" class="text-decoration-none">
                            <div class="card text-center bg-success text-white p-2">
                                <h6 class="fw-bold">Download Reports for the day</h6>
                            </div>
                        </a>
                    </div>

                </div>

                <!-- start graph -->
                <?php
                // Initialize arrays to store data
                $datasets = array(); // Array to store chart datasets
                $chart_labels = array(); // Array to store chart labels

                // Query to fetch the monthly sales data
                $result = $con->query("
                                    SELECT
                                    DATE_FORMAT(bd.check_in, '%Y-%m') AS month_year,
                                    SUM(bd.trans_amt) AS total_transaction_amount
                                FROM
                                    booking_order bd
                                WHERE
                                    (bd.booking_status = 'Checked-out')
                                GROUP BY
                                    month_year
                                ORDER BY
                                    month_year;
            
                                    ");

                $chart_data = array();

                // Initialize an array to hold all months of the year
                $all_months = array();
                for ($month = 1; $month <= 12; $month++) {
                    $all_months[] = date('Y-m', strtotime("2023-$month-01"));
                }

                while ($data = $result->fetch_assoc()) {
                    $month_year = $data['month_year'];
                    $total_transaction_amount = $data['total_transaction_amount'];
                    $chart_data[$month_year] = $total_transaction_amount;
                }

                // Combine fetched data with all months, filling in missing months with zero values
                foreach ($all_months as $month) {
                    if (!isset($chart_data[$month])) {
                        $chart_data[$month] = 0;
                    }
                }

                // Sort the data by month
                ksort($chart_data);

                // Prepare chart labels with month names
                foreach ($chart_data as $month_year => $value) {
                    $month_name = date('F', strtotime($month_year . '-01'));
                    $chart_labels[] = $month_name;
                }
                ?>




                <!-- START OF UPDATE -->

                <h6 class="text-center fw-bold">Monthly Sales Analytics</h6>
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <canvas id="monthlySalesAnalyticsChart" class="mb-2"></canvas>
                    </div>

                    <div class="col-lg-4 mb-3">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body">


                                <!-- booking analytics -->
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6>Booking Analytics</h6>
                                    <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                                        <option value="1">Past 30 Days</option>
                                        <option value="2">Past 90 Days</option>
                                        <option value="3">Past 1 Year</option>
                                        <option value="4">All time</option>
                                    </select>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-md-6 mb-3">
                                        <div class="card text-center bg-success text-white p-3">
                                            <h6>Total Bookings</h6>
                                            <h4 class="mt-2 mb-0" id="total_bookings">0</h4>
                                            <h5 class="mt-2 mb-0" id="total_amt">₱ 00.00</h5>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="card text-center bg-warning p-3">
                                            <a href="Full_calendar.php" class="text-decoration-none text-dark">
                                                <h6>Active Bookings</h6>
                                                <h4 class="mt-2 mb-0" id="active_bookings">0</h4>
                                                <h5 class="mt-2 mb-0" id="active_amt">₱ 00.00</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-md-6 mb-3">
                                        <div class="card text-center bg-danger text-white p-3">
                                            <h6>Cancelled Bookings</h6>
                                            <h4 class="mt-2 mb-0" id="cancelled_bookings">0</h4>
                                            <h5 class="mt-2 mb-0" id="cancelled_amt">₱ 00.00</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Pie chart JavaScript -->


                    <!-- END OF UPDATE -->







                    <!-- end graph -->



                    <?php
                    // Calculate the date 30 days ago from today
                    $thirtyDaysAgo = date("Y-m-d", strtotime("-30 days"));

                    // Define all possible reservation statuses
                    $statuses = array("Booked", "Reserved", "Checked-In", "Checked-Out", "Cancelled", "No show");

                    // Initialize counts for each reservation status
                    $counts = array();
                    foreach ($statuses as $status) {
                        $counts[$status] = 0;
                    }

                    // Fetch reservation statuses within the last 30 days from the database
                    $query = "SELECT booking_status FROM `booking_order` WHERE CURDATE() >= ?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("s", $thirtyDaysAgo);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Update counts based on the fetched data
                    while ($row = $result->fetch_assoc()) {
                        $status = $row['booking_status'];
                        if (array_key_exists($status, $counts)) {
                            $counts[$status]++;
                        }
                    }

                    $sql99 = "SELECT rs.type, COUNT(bo.booking_status) AS room_count
                            FROM rooms rs
                            LEFT JOIN booking_order bo ON rs.room_id = bo.room_id
                            AND bo.booking_status = 'Checked-Out'
                            GROUP BY rs.type";


                    $result = $con->query($sql99);

                    $data = array();
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    ?>



                    <!-- START OF UPDATE -->

                    <div class='col-lg-6 col-md-6 col-sm-12 px-4 mb-4'>
                        <h4 class="mb-3">Reservation Status (Last 30 Days)</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3"><br>
                            <canvas id="reservationPieChart" width="100" height="100"></canvas>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div style="width: 105%; margin: auto;">
                                <canvas id="roomUsageChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- END OF UPDATE -->





                    <!-- Bar graph -->


                    <script>
                        // Convert PHP data to JavaScript
                        var roomData = <?php echo json_encode($data); ?>;

                        var ctx3 = document.getElementById('roomUsageChart').getContext('2d');

                        var roomTypes = roomData.map(function(item) {
                            return item.type;
                        });

                        var roomCounts = roomData.map(function(item) {
                            return item.room_count;
                        });

                        new Chart(ctx3, {
                            type: 'line',
                            data: {
                                labels: roomTypes,
                                datasets: [{
                                    label: 'Room Usage',
                                    data: roomCounts,
                                    borderColor: '#198754', // Change line color to #198754
                                    fill: true, // To make it a line chart without filling the area under the line
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        beginAtZero: true


                                    }
                                }
                            }

                        });
                    </script>




                    <!-- Room Analalytics -->




                    <!-- START OF UPDATE -->

                    <!-- end of room analytics -->

                    <!-- Users, Queries, Reviews Analytics -->
                    <center>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3>Users, Queries, Reviews Analytics</h3>
                            <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
                                <option value="1">Past 30 Days</option>
                                <option value="2">Past 90 Days</option>
                                <option value="3">Past 1 Year</option>
                                <option value="4">All time</option>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 mb-3">
                                <div class="card text-center p-1 bg-info text-white">
                                    <h6>New Registration</h6>
                                    <h1 class="mt-2 mb-0" id="total_new_reg">0</h1>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="card text-center p-1 bg-warning text-white">
                                    <h6>Queries</h6>
                                    <h1 class="mt-2 mb-0" id="total_queries">0</h1>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center p-1 bg-success text-white">
                                    <h6>Reviews</h6>
                                    <h1 class="mt-2 mb-0" id="total_review">0</h1>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-3 mb-3">
                                <div class="card text-center p-1 bg-dark text-white">
                                    <h6>Total Users</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $current_users['total'] ?></h1>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center p-1 bg-secondary text-white">
                                    <h6>Active Users</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $current_users['active'] ?></h1>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center p-1 bg-primary text-white">
                                    <h6>Inactive Users</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $current_users['inactive'] ?></h1>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center p-1 bg-danger text-white">
                                    <h6>Unverified Users</h6>
                                    <h1 class="mt-2 mb-0"><?php echo $current_users['unverified'] ?></h1>
                    </center>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    <!-- END OF UPDATE -->



    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>
    <script src="../jquery/chart.min.js"></script>


    <!-- Pie chart JavaScript -->
    <script>
        // Get the reservation data from PHP
        var reservationData = <?php echo json_encode($counts); ?>;

        // Get the canvas element
        var ctx = document.getElementById('reservationPieChart').getContext('2d');

        // Create the pie chart
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(reservationData),
                datasets: [{
                    data: Object.values(reservationData),
                    backgroundColor: [
                        '#198754', // Booked
                        '#000', // Reserved
                        '#ffc107', // Checked-In
                        '#C107FF', // Checked-Out
                        '#dc3545', // Cancelled
                        '#0dcaf0' // No Show
                    ],
                }],
            },
            options: {
                legend: {
                    display: false, // Set the legend display to false
                }
            }
        });
    </script>







    <script>
        // Create a chart using Chart.js for monthly sales analytics
        var ctx = document.getElementById('monthlySalesAnalyticsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar', // Bar chart
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    label: 'Monthly Sales',
                    data: <?php echo json_encode(array_values($chart_data)); ?>,
                    backgroundColor: '#198754', // Bar color
                    borderColor: '#198754', // Border color
                    borderWidth: 1 // Border width
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Transaction Amount'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });
    </script>



    <script src="scripts/dashboard.js"></script>

    <script>
        function loadDoc() {
            setInterval(function() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("noti_number").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "include/notifications/bookings.php", true);
                xhttp.send();
            }, 1000);
        }
        loadDoc();
    </script>
</body>



</html>