<?php
require('include/conn.php');
require('include/essentials.php');
require('include/M_googleconfig.php');

//sa session to para ung nakalogin lang makaaccess sa dashboard
session_start();
if ((isset($_SESSION['mngmtLogin']) && $_SESSION['mngmtLogin'] == true)) {
    redirect('dashboard.php');
}

// gettingall the rooms for the select tag and input the room types
$room = $con->query("SELECT * FROM `rooms` LIMIT 1");
$room_res = [];
foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
    $room_res = $row['room_id'];
}


$login_button = '';
// $tlogin_button = '';
// $flogin_button = '';



//pagpinindot na si login button
if (isset($_POST['login'])) {
    $frm_data = filteration($_POST); //pantanggal ng mga characters na d naman belong sa mundo ex. <>/?=+ etc.

    $query = "SELECT * FROM `management_users` WHERE `m_email`=?";
    $values = [$frm_data['M_email']];

    $res = select($query, $values, "s"); //magpapasa to ng data sa function na select sa include/conn.php
    if ($res->num_rows == 1) {
        $row = mysqli_fetch_assoc($res);
        if (password_verify($frm_data['M_pass'], $row['m_password'])) {
            if ($row['approved'] == 1) {
                $_SESSION['mngmtLogin'] = true;
                $_SESSION['mngmtID'] = $row['m_id'];

                //for system logs
                $sys_email = "";
                $sys_name = "";
                $sys_action = "Logged in";
                $sys_user_type = "";

                // gettingall the management users
                $room = $con->query("SELECT * FROM `management_users` WHERE `m_id`='$row[m_id]'");
                foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
                    $sys_email = $row['m_email'];
                    $sys_name = $row['m_name'];
                    $sys_user_type = $row['m_type'];
                }
                $query = "INSERT INTO `systemlog`(`email`,`name`,`action`,`User_type`) VALUES (?,?,?,?)";
                $values = [$sys_email, $sys_name, $sys_action, $sys_user_type];
                $res = insert($query, $values, 'ssss');

                if($sys_user_type == "Management"){
                    redirect('Full_calendar.php?room=' . $room_res); // pasa data sa redirect function sa include/essential.php
                } else if($sys_user_type == "Front Desk"){
                    redirect('Full_calendar.php?room=' . $room_res); // pasa data sa redirect function sa include/essential.php
                } else{
                    redirect('dashboard.php'); 
                }

            } else {
                redirect('not_approved.php');
            }
        } else {
            alert('error', "Incorrect Password!");
        }
    } else {
        //magpapasa ng data sa function na alert sa include/essential.php
        alert('error', 'Login failed - Invalid Credentials');
    }
}


//login thru gmail account

if (isset($_GET["code"])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    // Check if user already exists in the database
    $google_client->setAccessToken($token['access_token']);
    $_SESSION['access_token'] = $token['access_token'];

    $google_service = new Google_Service_Oauth2($google_client);
    $data = $google_service->userinfo->get();

    $u_exist = select("SELECT * FROM `management_users` WHERE `email`=? LIMIT 1", [$data['email']], "s");
    $u_fetch = mysqli_fetch_assoc($u_exist);

    if (!isset($token['error'])) {
        if (mysqli_num_rows($u_exist) == 0) {
            $guest_name = $data['given_name'] . $data['family_name'];
            $l_type = "google";

            // Insert the record into the database
            $query = "INSERT INTO `management_users`(`m_name`, `m_email`, `l_type`) VALUES ('$guest_name', '{$data['email']}', '$l_type')";

            if (mysqli_query($con, $query)) {
                // Store user information in session variables
                $_SESSION['mngmtLogin'] = true;


                // Retrieve the inserted ID
                $inserted_id = mysqli_insert_id($con);
                $_SESSION['mngmtID'] = $inserted_id;


                // Refresh the page after successful login, only if it hasn't been reloaded before
                if (!isset($_SESSION['page_reloaded'])) {
                    $_SESSION['page_reloaded'] = true;
                    header('Location: Full_calendar.php?room=' . $room_res);
                    exit;
                }
            }
        } else {
            // Store user information in session variables
            $_SESSION['mngmtLogin'] = true;


            // Retrieve the inserted ID
            $inserted_id = mysqli_insert_id($con);
            $_SESSION['mngmtID'] = $inserted_id;


            // Refresh the page after successful login, only if it hasn't been reloaded before
            if (!isset($_SESSION['page_reloaded'])) {
                $_SESSION['page_reloaded'] = true;
                header('Location: Full_calendar.php?room=' . $room_res);
                exit;
            }
        }
    }
}


if (!isset($_SESSION['access_token'])) {

    // $login_button = '<a class="btn btn-sm w-100 text-light rounded shadow-none py-2 px-4 mb-1" style="background-color: #dd4b39;" href="' . $google_client->createAuthUrl() . '"><i class="fab fa-google me-2"></i> Sign in with google</a>';
    $login_button = '<a class="btn btn-sm w-100 text-light rounded shadown-none py-2 px-4 mb-1" style="background-color: #dd4b39;" href="'.SITE_URL.'"><i class="fas fa-user me-2"></i> Sign-in as Guest User</a>';
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

    <title>Management | Login</title>

    <style>
        .card-img-left {
            width: 45%;
            /* Link to your background image using in the property below! */
            background: scroll center url('../img/lobby.jpg');
            background-size: cover;
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
        }

        .btn-google {
            color: white !important;
            background-color: #ea4335;
        }

        .btn-facebook {
            color: white !important;
            background-color: #3b5998;
        }

        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #198754;
        }

        .login-form {
            margin-top: 25px;
        }

        .pop:hover {
            transform: scale(1.03);
            transition: all 0.3s;
            color: #198754;
        }

        .socials {
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Login start -->
    <!-- <div class="login-form rounded bg-white shadow overflow-none ">
        <form method="POST">

            <div class="p-4">
                <div class="text-center">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i>HM Hotel | Login
                    </h5>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input name="M_email" type="email" class="form-control shadow-none" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="M_pass" type="password" class="form-control shadow-none" required>
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <label class="form-label">
                        Don't have an Account? <a type="button" href="choosereg.php" class="text-success text-decoration-none shadow-none">Register</a>
                    </label>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <button name="login" type="submit" class="btn btn-success shadow-none">Login</button>
                    <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
                </div>
            </div>

        </form>
    </div> -->

    <!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

    <body>
        <div class="container login-form">
            <div class="row">
                <div class="col-lg-10 col-xl-9 mx-auto">
                    <div class="card flex-row my-5 border-0 shadow-lg rounded-3 overflow-hidden">
                        <div class="card-img-left d-none d-md-flex">
                            <!-- Background image for card set in CSS! -->
                        </div>
                        <div class="card-body p-4 p-sm-4">
                            <img class="img-fluid mx-auto d-block mb-1" width="100px" height="100px" src="../img/plogo.png" alt="">
                            <h5 class="card-title text-center mb-4 fw-bold fs-5">HM Hotel | Login</h5>
                            <form method="POST">

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control shadow-none" name="M_email" id="floatingInputEmail" placeholder="name@example.com" required>
                                    <label for="floatingInputEmail">Email address</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control shadow-none" name="M_pass" id="floatingPassword" placeholder="Password" required>
                                    <label for="floatingPassword">Password</label>
                                </div>

                                <div class="d-grid mb-2">
                                    <button class="btn btn-lg btn-success btn-login fw-bold shadow-none text-uppercase" type="submit" name="login">Login</button>
                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <label class="form-label">
                                        Don't have an Account? <a type="button" href="choosereg.php" class="text-success text-decoration-none shadow-none">Register</a>
                                    </label>
                                </div>

                                <div class="divider d-flex align-items-center my-4">
                                    <p class="text-center text-success mx-3 mb-0">Or</p>
                                </div>

                                <div class="socials mb-2">
                             
                                    <?php echo $login_button; ?>
                                  

                                </div>


                                <!-- <div class="d-grid">
                                    <button class="btn btn-lg btn-facebook btn-login fw-bold text-uppercase" type="submit">
                                        <i class="fab fa-facebook-f me-2"></i> Sign up with Facebook
                                    </button>
                                </div> -->

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>


    <!-- Login End -->



    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>
</body>

</html>