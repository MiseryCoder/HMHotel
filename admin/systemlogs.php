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
    <title>HM Hotel | System Logs</title>
</head>

<style>
    #SLactive,
    #SLactive {
        font-weight: bolder;
        color: #198754;
    }

    #SLactive:hover,
    #SLactive:hover {
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

                <div class="container">
                    <div class="row">
                        <h3 class="mb-3 text-success fw-bold">System Logs</h3>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-lg-start justify-content-center">
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

                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="bg-success text-light">
                                        <th scope="col">ID</th>
                                        <th scope="col">Date & Time</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">User Type</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                </tbody>
                            </table>

                            <nav>
                                <ul class="pagination mt-3" id="table-pagination">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- JavaScript Bundle with Popper -->
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>

    <!-- alertbox lang to -->

    <?php require('include/scripts.php'); ?>

    <script src="scripts/systemlogs.js"></script>
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