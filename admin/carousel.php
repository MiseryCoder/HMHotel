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
    <title>HM Hotel | Carousel</title>
</head>

<style>
    #Cactive, #Setactive {
        font-weight: bolder;
        color: #198754;
    }

    #Cactive:hover, #Setactive:hover {
        color: #198754;
    }
</style>

<body>

    <!-- Navigation start -->
    <?php require('include/Mnavigation.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-3 text-success fw-bold">CAROUSEL</h3>

                <!-- Carousel Team Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Images</h5>
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#carousel-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="row" id="carousel-data">
                        </div>
                    </div>
                </div>


                <!-- Carousel Team Settings modal -->
                <div class="modal fade" id="carousel-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">

                        <div class="modal-content">
                            <form id="carousel_s_form">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Carousel Image</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Picture</label>
                                        <input type="file" id="carousel_picture_inp" name="carousel_picture" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success shadow-none">Save</button>
                                </div>
                            </form>
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

    <!-- pinaka function (update,view,delete....) -->
    <script src="scripts/carousel.js"></script>
</body>

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

</html>