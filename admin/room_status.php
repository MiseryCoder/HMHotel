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
    <title>HM Hotel | Room Status</title>
</head>

<style>
    #RSactive,
    #ROactive {
        font-weight: bolder;
        color: #198754;
    }

    #RSactive:hover,
    #ROactive:hover {
        color: #198754;
    }
</style>

<body>

    <!-- Navigation start -->
    <?php
    require('include/Mnavigation.php');
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con, "SELECT `shutdown` FROM `about_details`"));
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="d-flex align-items-center mb-3">
                    <div class="row">
                        <div class="col-lg-12 mb-1 d-flex justify-content-lg-start justify-content-center">
                            <?php
                            if ($is_shutdown['shutdown']) {
                                echo <<<data
                                            <h6 class="badge bg-danger py-2 px-3 rounded" style="z-index: 0;">Shutdown Mode is Active!</h6>
                                        data;
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Carousel Team Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive-md">
                            <table class="table table-hover border">

                                <tr class="bg-success text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Room Number</th>
                                    <th scope="col">Room Availability</th>
                                    <th scope="col">Room Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                <tbody>
                                    <?php
                                    // $query = "SELECT rr.*,uc.name AS uname, r.type AS rname FROM `rating_review` rr 
                                    //         INNER JOIN `guests_users` uc ON rr.user_id = uc.id
                                    //         INNER JOIN `rooms` r ON rr.room_id = r.room_id
                                    //         ORDER BY `rating_id` DESC";

                                    $query = "SELECT *
                                                FROM room_no";

                                    $data = mysqli_query($con, $query);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $room_no = $row['room_nos'];

                                        $query2 = "SELECT booking_order.booking_status
                                                    FROM booking_details
                                                    INNER JOIN booking_order ON booking_details.booking_id = booking_order.booking_id
                                                    WHERE booking_details.room_no = '$room_no'";

                                        $data2 = mysqli_query($con, $query2);

                                        // Check if there are any matching rows
                                        if (mysqli_num_rows($data2) > 0) {
                                            $row2 = mysqli_fetch_assoc($data2);
                                            $booking_status = "Not Available";
                                        } else {
                                            $booking_status = "Available";
                                        }

                                        echo "<tr>";
                                        echo "<td>$i</td>";
                                        echo "<td>" . $row['room_nos'] . "</td>";
                                        echo "<td>" . $booking_status . "</td>";
                                        echo "<td>" . $row['room_status'] . "</td>";
                                        echo "<td><button class='btn btn-success shadow-none' data-bs-dismiss='modal' aria-label='Close' data-bs-toggle='modal' data-bs-target='#houseModal'><i class='bi bi-pencil-square'></i></button></td>";
                                        echo "</tr>";

                                        $i++;
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!------ Modal for otp(OTP) ---->
    <div class="modal fade" id="houseModal" tabindex="-1" aria-labelledby="OtppModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="house-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-person-circle fs-3 me-2"></i> Update Room Status
                        </h5>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <select name="type" class="shadow-none form-select w-100" id="room_select" name="room">
                                <label class="form-label fw-bold">Room Type</label>
                                <option value="Vacant Clean">Vacant Clean</option>
                                <option value="Vacant Ready">Vacant Ready</option>
                                <option value="Vacant Dirty">Vacant Dirty</option>
                                <option value="Occupied">Occupied</option>
                                <option value="Occupied Dirty">Occupied Dirty</option>

                            </select>
                        </div>


                        <div class="align-items-end mb-2">
                            <button type="submit" class="btn btn-success shadow-none">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!------ End Modal for Login(BOOK NOW) ---->


    <!-- JavaScript Bundle with Popper -->
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>

    <!-- alertbox lang to -->

    <?php require('include/scripts.php'); ?>

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