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
    <title>HM Hotel | Settings</title>
</head>

<style>
    #Sactive,
    #Setactive {
        font-weight: bolder;
        color: #198754;
    }

    #Sactive:hover,
    #Setactive:hover {
        color: #198754;
    }

    .custom-alert {
        position: fixed;
        z-index:111111; 
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
                <h3 class="mb-3 text-success fw-bold">SETTINGS</h3>

                <!-- General Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#general-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Website Name</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
                        <p class="card-text" id="site_about"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">Mission</h6>
                        <p class="card-text" id="site_mission"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">Vision</h6>
                        <p class="card-text" id="site_vision"></p>
                    </div>
                </div>

                <!-- General Settings modal -->
                <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">

                        <div class="modal-content">
                            <form action="POST" id="general_s_form">
                                <div class="modal-header">
                                    <h5 class="modal-title">General Settings</h5>
                                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Site Title</label>
                                        <input type="text" id="site_title_inp" name="site_title" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="AddressText" class="form-label fw-bold">About us</label>
                                        <textarea name="site_about" id="site_about_inp" class="form-control shadow-none" rows="6" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="AddressText" class="form-label fw-bold">Mission</label>
                                        <textarea name="site_mission" id="site_mission_inp" class="form-control shadow-none" rows="6" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="AddressText" class="form-label fw-bold">Vision</label>
                                        <textarea name="site_vision" id="site_vision_inp" class="form-control shadow-none" rows="6" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="site_title.value = general_data.site_title, site_about.value = general_data.site_about, site_mission.value = general_data.site_mission, site_vision.value = general_data.site_vision" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success shadow-none">Save</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <!-- Shutdown section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown Website</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggle">
                                </form>
                            </div>
                        </div>


                        <p class="card-text">
                            No Customers will be allowed to book hotel room, when shutdown mode is turned on.
                        </p>
                    </div>
                </div>

                <!-- Turn off Online Payment -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Online Payment</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input onchange="upd_payment(this.value)" class="form-check-input" type="checkbox" id="payment-toggle">
                                </form>
                            </div>
                        </div>


                        <p class="card-text">
                            Online payment will be available when it's turned on.
                        </p>
                    </div>
                </div>

                <!-- Contacts Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contacts Settings</h5>
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#contacts-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Contact Numbers</h6>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">E-mail</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Social Medias</h6>
                                    <p class="card-text">
                                        <i class="bi bi-facebook me-1"></i>
                                        <span id="fb"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-google me-1"></i>
                                        <span id="ig"></span>
                                    </p>

                                    <p class="card-text">
                                        <i class="bi bi-twitter me-1"></i>
                                        <span id="tw"></span>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iFrame Src (ex. https://www.google.com/...)</h6>
                                    <iframe id="iframe" loading="lazy" class="border p-2 w-100"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Contacts Settings modal -->
                <div class="modal fade" id="contacts-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">

                        <div class="modal-content">
                            <form action="POST" id="contacts_s_form">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contacts Settings</h5>
                                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Address</label>
                                                    <input type="text" id="address_inp" name="address" class="form-control shadow-none" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Google map Link</label>
                                                    <input type="text" id="gmap_inp" name="gmap" class="form-control shadow-none" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Phone Number</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">@</span>
                                                        <input name="pn1" id="pn1_inp" type="text" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">@</span>
                                                        <input name="pn2" id="pn2_inp" type="text" class="form-control shadow-none" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Email</label>
                                                    <input type="text" id="email_inp" name="email" class="form-control shadow-none" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Social Links</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                                        <input name="fb" id="fb_inp" type="text" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-google"></i></span>
                                                        <input name="ig" id="ig_inp" type="text" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-twitter"></i></span>
                                                        <input name="tw" id="tw_inp" type="text" class="form-control shadow-none" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="card-subtitle mb-1 fw-bold">iFrame Src</h6>
                                                    <input type="text" name="iframe" id="iframe_inp" class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="contacts_inp(contacts_data)" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success shadow-none">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Management Team Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Team Settings</h5>
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#team-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="row" id="team-data">
                        </div>
                    </div>
                </div>


                <!-- Manangement Team Settings modal -->
                <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">

                        <div class="modal-content">
                            <form id="team_s_form">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Team Member</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <input type="text" id="member_name_inp" name="member_name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Picture</label>
                                        <input type="file" id="member_picture_inp" name="member_picture" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" required>
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
    <script src="scripts/settings.js"></script>

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