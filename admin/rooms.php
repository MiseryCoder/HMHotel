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
    <title>HM Hotel | Rooms Settings</title>
</head>

<style>
    #Ractive,
    #ROactive {
        font-weight: bolder;
        color: #198754;
    }

    #Ractive:hover,
    #ROactive:hover {
        color: #198754;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .navbar {
    z-index: 1000;
    }
    .modal {
    z-index: 2000; /* Ensure the z-index of the modal is higher than the navigation bar */
    }
</style>

<body>

    <!-- Navigation start -->
    <?php
    require('include/Mnavigation.php');

    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-3 text-success fw-bold">ROOMS & FACILITIES SETTINGS</h3>

                <!-- Carousel Team Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#add-room">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>


                        <div class="table-responsive-lg" style="height: 450px; overflow-y:scroll;">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-success text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guests Capacity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Images</th>
                                        </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Add room modal -->
    <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">
                <form id="add_room_form" autocomplete="off">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Room</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Room Category</label>
                                <select name="room_category" class="form-select shadow-none">
                                    <option value="Room">Room</option>
                                    <option value="Facility">Facility</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Room Type</label>
                                <select name="type" class="form-select shadow-none">
                                    <option value="Standard Room">Standard Room</option>
                                    <option value="Deluxe Room">Deluxe Room</option>
                                    <option value="Suite Room">Suite Room</option>
                                    <option value="Bedroom Suite">Bedroom Suite</option>
                                    <option value="Presidential Suite">Presidential Suite</option>
                                    <option value="Banquet Hall">Banquet Hall</option>
                                    <option value="Function Hall">Function Hall</option>
                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Size</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adult (Max.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Children (Max.)</label>
                                <input type="number" name="children" class="form-control shadow-none" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Room Number</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('room_no');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                                <div class='col-md-3'>
                                                    <label>
                                                        <input type='checkbox' name='room_nos' value='$opt[id]' class='form-check-input shadow-none mb-3'>
                                                        $opt[room_nos]
                                                    </label>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('features');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                                <div class='col-md-3'>
                                                    <label>
                                                        <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none mb-3'>
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('facilities');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                                <div class='col-md-3'>
                                                    <label>
                                                        <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none mb-3'>
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" rows="4" class="form-control shadown-none"></textarea>
                            </div>
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


    <!-- Edit room modal -->
    <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">
                <form id="edit_room_form" autocomplete="off">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Room</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Room Category</label>
                                <select name="room_category" class="form-select shadow-none">
                                    <option value="Room">Room</option>
                                    <option value="Facility">Facility</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Room Type</label>
                                <select name="type" class="form-select shadow-none">
                                    <option value="Standard Room">Standard Room</option>
                                    <option value="Deluxe Room">Deluxe Room</option>
                                    <option value="Suite Room">Suite Room</option>
                                    <option value="Bedroom Suite">Bedroom Suite</option>
                                    <option value="Presidential Suite">Presidential Suite</option>
                                    <option value="Banquet Hall">Banquet Hall</option>
                                    <option value="Function Hall">Function Hall</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Size</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adult (Max.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Children (Max.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>


                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Room Number</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('room_no');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                                <div class='col-md-3'>
                                                    <label>
                                                        <input type='checkbox' name='room_nos' value='$opt[id]' class='form-check-input shadow-none mb-3'>
                                                        $opt[room_nos]
                                                    </label>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </div>


                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('features');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                                <div class='col-md-3'>
                                                    <label>
                                                        <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none mb-3'>
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Amenities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('facilities');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                                <div class='col-md-3'>
                                                    <label>
                                                        <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none mb-3'>
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" rows="4" class="form-control shadown-none"></textarea>
                            </div>

                            <input type="hidden" name="room_id">
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


    <!-- Manage room images modal -->
    <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Room Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image-alert"></div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add_image_form">
                            <label class="form-label fw-bold">Add Image</label>
                            <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3" required>
                            <button class="btn btn-success shadow-none">Add</button>
                            <input type="hidden" name="room_id">

                        </form>
                    </div>

                    <div class="table-responsive-lg" style="height: 350px; overflow-y:scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="bg-success text-light sticky-top">
                                    <th scope="col" width="60%">Image</th>
                                    <th scope="col">Thumbnail</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="room-image-data">
                            </tbody>
                        </table>
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

    <script src="scripts/rooms.js"></script>

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