<?php
require('admin/include/conn.php');
require('admin/include/essentials.php');
require('admin/include/scripts.php');
require('admin/include/googleconfig.php');

date_default_timezone_set("Asia/Manila");


session_start();

// eto ung pangkuha nung data sa database sa table na about_details
$title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=?";
$values = [1];
$title_r = mysqli_fetch_assoc(select($title_q, $values, 'i')); //select function sa admin/include/conn.php

if ($title_r['shutdown']) {
    echo <<<alertbar
            <div class="bg-danger fs-6 fixed-bottom text-center text-light p-2 fw-bold">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Bookings are Temporarily closed! <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        alertbar;
}



//eto ung magchecheck ng booking pag hindi dumating si guests tas nagbook magiging no show ung status tsaka checked out nmaan pagtapos na
$dateToday = date("Y-m-d H:i:s");
$sql = "SELECT * FROM `booking_order`";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['booking_id'];
        $checkin_date = $row['check_in'];
        $checkout_date = $row['check_out'];
        $expiration_time = $row['expires_time'];
        $expiration_date = $row['check_out'];
        $arrival = $row['arrival'];
        $booking_status = $row['booking_status'];

        if ($arrival == 0 && strtotime($expiration_time) <= time() && strtotime($expiration_date) <= strtotime(date("Y-m-d", time()))) {
            // Arrival is 0 and check-in date has passed
            $status = "No show";
            $update_sql = "UPDATE `booking_order` SET `booking_status`='$status' WHERE `booking_id`='$id'";
            $con->query($update_sql);
        } elseif ($arrival == 1 && strtotime($checkout_date) < strtotime($dateToday) && $booking_status != "Checked-Out") {
            // Arrival is 1 and check-out date has passed
            $status = "Checked-Out";
            $update_sql = "UPDATE `booking_order` SET `booking_status`='$status' WHERE `booking_id`='$id'";
            $con->query($update_sql);
        }
    }
}



$login_button = '';
$login_adminbutton = '';



//login thru gmail account

if (isset($_GET["code"])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    $u_exist = select("SELECT * FROM `guests_users` WHERE `email`=? LIMIT 1", [$data['email']], "s");
    $u_fetch = mysqli_fetch_assoc($u_exist);

    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];
        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();
        if (mysqli_num_rows($u_exist) == 0) {
            $guest_name = $data['given_name'] . $data['family_name'];
            $tokenDirect = bin2hex(random_bytes(16));
            $l_type = "google";

            // Insert the record into the database
            $query = "INSERT INTO `guests_users`(`name`, `email`, `token`, `l_type`) VALUES ('$guest_name', '{$data['email']}', '$tokenDirect', '$l_type')";

            if (mysqli_query($con, $query)) {
                // Store user information in session variables
                $_SESSION['login'] = true;
                $_SESSION['uName'] = $guest_name;
                $_SESSION['user_email_address'] = $data['email'];
                $_SESSION['uPic'] = '';
                $_SESSION['uPhone'] = '';

                if (!empty($data['picture'])) {
                    $_SESSION['user_image'] = $data['picture'];
                } else {
                    $_SESSION['user_image'] = '';
                }

                // Retrieve the inserted ID
                $inserted_id = mysqli_insert_id($con);
                $_SESSION['uId'] = $inserted_id;

                echo "<script>alert('success', 'Welcome back, {$_SESSION['uName']}!');</script>";
            }
        } else {
            // Store user information in session variables
            $_SESSION['login'] = true;
            $_SESSION['uName'] = $u_fetch['name'];
            $_SESSION['user_email_address'] = $u_fetch['email'];
            $_SESSION['uPic'] = '';
            $_SESSION['uPhone'] = '';
            $_SESSION['uId'] = $u_fetch['id'];

            if (!empty($data['picture'])) {
                $_SESSION['user_image'] = $data['picture'];
            } else {
                $_SESSION['user_image'] = '';
            }

            echo "<script>alert('success', 'Welcome back, {$_SESSION['uName']}!');</script>";
        }
    }
}





if (!isset($_SESSION['access_token'])) {

    $login_adminbutton = '<a class="btn btn-sm w-100 text-light rounded shadown-none py-2 px-4 mb-1" style="background-color: #198754;" href="' . SITE_URL_ADMIN . '"><i class="fas fa-user-cog me-2"></i> Sign-in as Management</a>';
    $login_button = '<a class="btn btn-sm w-100 text-light rounded shadown-none py-2 px-4 mb-1" style="background-color: #dd4b39;" href="' . $google_client->createAuthUrl() . '"><i class="fab fa-google me-2"></i> Sign-in with google</a>';
}

?>

<!-- Navigation start -->

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand logo" href="index.php"><?php echo $title_r['site_title']; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link Hactive" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link Ractive" href="rooms.php">Rooms</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link Factive" href="facility.php">Facilities</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link AMactive" href="Amenities.php">Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link Aactive" href="AboutUS.php">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link Cactive" href="contactus.php">Contact Us</a>
                </li>

            </ul>
            <div class="d-flex">

                <?php


                if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                    $path = USERS_IMG_PATH;
                    $Simage = $_SESSION['uPic'];
                    if (!empty($_SESSION['user_image'])) {
                        $directimage = $_SESSION['user_image'];
                    } else {
                        $directimage = $path . $Simage;
                    }
                    echo <<<data
                            <div class="btn-group">
                                <button type="button" class="btn btn-success shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    $_SESSION[uName]
                                </button>
                                <ul class="dropdown-menu dropdown-menu-md-end">
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                                    <li><a class="dropdown-item" href="logout.php" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal">Logout</a></li>
                                    </ul>
                            </div>
                            data;
                } else {
                    echo <<<data
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#loginModal">Login/Sign Up</button>
                        data;
                }
                ?>
            </div>

        </div>
    </div>
</nav>
<!------ End of Navigation Bar ------>

<!------ Modal for Login(LOGIN NOW) ---->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="login-form" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> Login
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <?php echo $login_adminbutton; ?>
                    </div>


                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center text-success fw-bold mx-3 mb-0">Or</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email address / Contact Number</label>
                        <input type="text" name="email_mob" class="form-control shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="pass" class="form-control shadow-none" required>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label class="form-label">
                            Don't have an account? <a type="button" class="text-success text-decoration-none shadow-none" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                        </label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button name="login" type="submit" class="btn btn-success shadow-none">Login</button>
                        <label class="form-label">
                            <a type="button" class="text-secondary text-decoration-none shadow-none" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#forgotModal">Forgot Password?</a>
                        </label>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!------ End Modal for Login(BOOK NOW) ---->

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutConfirmationModalLabel">Logout Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <a href="logout.php" class="btn btn-danger">Yes</a>
            </div>
        </div>
    </div>
</div>


<!------ Modal for otp(OTP) ---->
<div class="modal fade" id="otpModal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="otp-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> One Time Password
                    </h5>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Enter 6-digit code:</label>
                        <input type="number" name="otpInput" class="form-control shadow-none" required>
                    </div>

                    <span class="d-flex badge rounded-pill bg-success mb-3 text-wrap justify-content-center align-items-center lh-base ">
                        Note: Check your email inbox or spam to get the code.
                    </span>

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button type="submit" class="btn btn-success shadow-none">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!------ End Modal for Login(BOOK NOW) ---->

<!------ Modal for otp(OTP) ---->
<div class="modal fade" id="notifEmail" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutConfirmationModalLabel">Email Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Check Your Email Inbox Or Spam Messages, for the Verification Link.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!------ End Modal for Login(BOOK NOW) ---->




<!------ Modal for forget password(LOGIN NOW) ---->
<div class="modal fade" id="forgotModal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="forgot-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-patch-question-fill me-2"></i> Forgot Password
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="text" name="email" class="form-control shadow-none" required>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button type="submit" class="btn btn-success shadow-none">Send link</button>
                        <label class="form-label">
                            Already have an account? <a type="button" class="text-success text-decoration-none shadow-none" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        </label>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!------ End Modal for Login(BOOK NOW) ---->






<!------ Modal for Register ---->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="register-form" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-lines-fill me-2"> </i> Register
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="col-md-12 ps-0 mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" id="nameInput" type="text" class="form-control shadow-none" placeholder="Juanito Alfonso" required>
                        </div>

                        <div class="ccol-md-12 p-0 mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control shadow-none" placeholder="Juanito123@gmail.com" required>
                        </div>

                        <div class="col-md-12 ps-0 mb-3">
                            <label class="form-label">Phone number</label>
                            <input name="phonenum" type="number" class="form-control shadow-none" placeholder="09123456789" required>
                        </div>

                        <!-- <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">Profile Picture</label></label>
                                    <input name="idpic" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
                                </div> -->

                        <div class="col-md-12 ps-0 mb-3">
                            <label class="form-label">Password</label>
                            <input id="pass" oninput="checkPasswordMatch()" name="pass" type="password" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-12 ps-0" id="passnmatch" hidden>
                            <p class="fw-bold alert alert-danger">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                Passwords do not match.
                            </p>
                        </div>
                        <div class="col-md-12 ps-0" id="passmatch" hidden>
                            <p class="fw-bold alert alert-success">
                                <i class="bi bi-check-circle-fill"></i>
                                Password matches.
                            </p>
                        </div>

                        <div class="col-md-12 p-0 mb-3">
                            <label class="form-label">Re-type Password</label>
                            <input id="repass" oninput="checkPasswordMatch()" name="repass" type="password" class="form-control shadow-none" required>
                        </div>

                    </div>

                    <div class="text-center">
                        <button name="register" type="submit" class="btn btn-success shadow-none w-75" disabled>
                            Register
                        </button>
                    </div>
                    <center>
                        <label class="form-label text-center text-muted">
                            Already have an account? <a type="button" class="text-success text-decoration-none shadow-none" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        </label>
                    </center>
                </div>
        </div>
    </div>
    </form>
</div>
</div>
</div>
<!------ End Modal for Register ---->