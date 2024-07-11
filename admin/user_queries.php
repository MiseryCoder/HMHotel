<?php
require('include/conn.php');
require('include/essentials.php');

//session nasa include/essential.php
mngmtLogin();


//mark as read ung message 
if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['seen'] == 'all') {
        $query = "UPDATE `user_queries` SET `seen`=?";
        $values = [1];
        if (update($query, $values, 'i')) {
            alert('success', 'Marked all as Read');
        } else {
            alert('error', 'Operation Failed - Read All');
        }
    } else {
        $query = "UPDATE `user_queries` SET `seen`=? WHERE `uqueries_id`=?";
        $values = [1, $frm_data['seen']];
        if (update($query, $values, 'ii')) {
            alert('success', 'Marked as Read');
        } else {
            alert('error', 'Operation Failed - Read');
        }
    }
}

//delete the message of the user
if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['del'] == 'all') {
        $query = "DELETE FROM `user_queries`";
        if (mysqli_query($con, $query)) {
            alert('success', 'All Data Deleted');
        } else {
            alert('error', 'Operation Failed - Delete All');
        }
    } else {
        $query = "DELETE FROM `user_queries` WHERE `uqueries_id`=?";
        $values = [$frm_data['del']];
        if (update($query, $values, 'i')) {
            alert('success', 'Data Deleted');
        } else {
            alert('error', 'Operation Failed - Delete');
        }
    }
}
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
    <title>HM Hotel | User Queries</title>
</head>

<style>
    #USactive,
    #Feedactive {
        font-weight: bolder;
        color: #198754;
    }

    #USactive:hover,
    #Feedactive:hover {
        color: #198754;
    }
</style>

<body>

    <!-- Navigation start -->
    <?php require('include/Mnavigation.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-3 text-success fw-bold">USER QUERIES</h3>

                <!-- Carousel Team Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">


                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-success rounded-pill shadow-none btn-sm">
                                <i class="bi bi-bookmark-check"></i> Mark all Read
                            </a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                                <i class="bi bi-trash"></i> Delete all
                            </a>
                        </div>
                        <div class="table-responsive-md" style="height: 450px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-success text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" width="20%">Subject</th>
                                        <th scope="col" width="30%">Message</th>
                                        <th scope="col">Sentiment</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM `user_queries` ORDER BY `uqueries_id` DESC";
                                    $data = mysqli_query($con, $query);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $seen = '';
                                        $date = date('d-m-Y', strtotime($row['datentime']));
                                        if ($row['seen'] != 1) {
                                            $seen = "<a href='?seen=$row[uqueries_id]' class='btn btn-sm rounded-pill btn-success'>Read</a> <br>";
                                        }
                                        $seen .= "<a href='?del=$row[uqueries_id]' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";
                                        if ($row['sentiment'] == 'Negative') {
                                            $feed = "bg-danger text-light text-center";
                                        } else if ($row['sentiment'] == 'Positive') {
                                            $feed = "bg-success text-light text-center";
                                        } else {
                                            $feed = "bg-secondary text-light text-center";
                                        }
                                        echo <<<query
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[subject]</td>
                                                    <td>$row[message]</td>
                                                    <td class='$feed'>$row[sentiment]</td>
                                                    <td>$date</td>
                                                    <td>$seen</td>
                                                </tr>
                                            query;
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