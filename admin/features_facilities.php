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
    <title>HM Hotel | Features & Facilities</title>
</head>

<style>
    #Factive, #ROactive {
        font-weight: bolder;
        color: #198754;
    }

    #Factive:hover, #ROactive:hover {
        color: #198754;
    }

    .navbar {
    z-index: 1000;
    }
    .modal {
    z-index: 2000; /* z-index of the modal is higher than the navigation bar */
    }

</style>

<body>

    <!-- Navigation start -->
    <?php require('include/Mnavigation.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-3 text-success fw-bold">Features and Amenities</h3>

                <!-- Carousel Team Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <!-- room number -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Room Numbers</h5>
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#roomnumber-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>


                        <div class="table-responsive-md" style="height: 350px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-success text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Room Number</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="roomnumber-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- room features -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Features</h5>
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#feature-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>


                        <div class="table-responsive-md" style="height: 350px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-success text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="features-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- room facility -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Amenities</h5>
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#facility-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>


                        <div class="table-responsive-md" style="height: 350px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-success text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" width="40%">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="facilities-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>


    <!-- Room numbers modal -->
    <div class="modal fade" id="roomnumber-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">
                <form id="roomnumber_s_form">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Room Number</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Room Number</label>
                            <input type="text" name="roomnumber_name" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-success shadow-none">SUBMIT</button>
                    </div>
            </div>
            </form>
        </div>
    </div>


    <!-- Feature modal -->
    <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">
                <form id="feature_s_form">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Feature</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="feature_name" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-success shadow-none">SUBMIT</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Facility modal -->
    <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">
                <form id="facility_s_form">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Amenities</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="facility_name" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Icon</label>
                            <input type="file" name="facility_icon" accept=".jpg, .png, .webp, .jpeg, .svg" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-success shadow-none">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>



        <!-- JavaScript Bundle with Popper -->
        <script src="../jquery/jquery-3.5.1.min.js"></script>
        <script src="../css/swiper/swiper-bundle.min.js"></script>
        <script src="../css/bootstrap/bootstrap.js"></script>

        <!-- alertbox lang to -->

        <?php require('include/scripts.php'); ?>

        <script src="scripts/FaF.js"></script>

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