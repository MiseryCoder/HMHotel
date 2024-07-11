<?php
require('include/conn.php');
require('include/essentials.php');
require('include/mailer.php');
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

$reg = $_GET['reg'];
$reg_type = "";

if ($reg == 1) {
    $reg_type = "Management";
} else if ($reg == 2) {
    $reg_type = "Front Desk";
} else if ($reg == 3) {
    $reg_type = "Housekeeping";
} else if ($reg == 4) {
    $reg_type = "Finance";
}

$l_type = "direct";


if (isset($_POST['register'])) {
    $data = filteration($_POST);

    $u_exist = select("SELECT * FROM `management_users` WHERE `m_email`=? LIMIT 1", [$data['email']], "s");

    if (mysqli_num_rows($u_exist) != 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_exist_fetch['m_email'] == $data['email']) {
            alert('error', "Email is Already Registered");
        }
    }


    //send confirmation link to user's email

    $token = bin2hex(random_bytes(16));
    $random6 = rand(100000, 999999);

    


    // Get the current time
    $current_time = time();

    // Add 3 minutes to the current time
    $expiration_time = $current_time + (3 * 60); // 3 minutes = 3 * 60 seconds

    // Format the expiration time as a readable date/time string
    $expiration_time_formatted = date('Y-m-d H:i:s', $expiration_time);
    send_mails($data['email'], $token, "email_confirmation", $random6);

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    $query = "INSERT INTO `management_users`(`m_name`, `m_email`,  `m_phone`, `m_address`, `m_password`, `m_type`, `otp`, `expiration_time`, `l_type`) VALUES (?,?,?,?,?,?,?,?,?)";

    $values = [$data['name'], $data['email'], $data['phonenum'], $data['address'], $enc_pass, $reg_type, $random6, $expiration_time_formatted, $l_type];


    if (insert($query, $values, 'ssssssiss')) {
        $inserted_id = mysqli_insert_id($con);
        redirect('otp.php?id=' . $inserted_id);
    } else {
        alert('danger', "Something went wrong");
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
    <title>Management | Register</title>

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
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container login-form">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <a class="btn btn-success shadow-none" href="choosereg.php"><- Back</a>
                        <div class="card flex-row my-3 border-0 shadow-lg rounded-3 overflow-hidden">
                            <div class="card-body p-4 p-sm-4" id="registerModal">
                                <img class="img-fluid mx-auto d-block mb-1" width="100px" height="100px" src="../img/plogo.png" alt="">
                                <h5 class="card-title text-center fw-bold fs-5">HM Hotel | Register</h5>
                                <h6 class="card-title text-center mb-4"><?php echo $reg_type ?></h6>
                                <form id="register-form" method="POST">
                                    <div class="modal-body">

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Name</label>
                                                <input name="name" type="text" class="form-control custom-input shadow-none" placeholder="Juanito Alfonso" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email</label>
                                                <input name="email" type="email" class="form-control custom-input shadow-none" placeholder="Juanito123@gmail.com" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Phone number</label>
                                                <input name="phonenum" type="number" class="form-control custom-input shadow-none" placeholder="09123456789" required>
                                            </div>
                                            <div class="col-md-12 mb-3 mb-3">
                                                <label for="AddressText" class="form-label">Address</label>
                                                <textarea name="address" class="form-control custom-input" id="AddressText" rows="1" required></textarea>
                                            </div>
                                            <div class="col-md-12 w-100" id="passNoMatch" hidden>
                                                <p class="fw-bold alert alert-danger">
                                                    <i class="bi bi-exclamation-circle-fill"></i>
                                                    Passwords do not match
                                                </p>
                                            </div>
                                            <div class="col-md-12 w-100" id="passMatch" hidden>
                                                <p class="fw-bold alert alert-success">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Passwords match
                                                </p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Password</label>
                                                <input id="pass" oninput="checkPasswordMatch()" name="pass" type="password" class="form-control custom-input shadow-none" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Re-type Password</label>
                                                <input id="repass" oninput="checkPasswordMatch()" name="repass" type="password" class="form-control custom-input shadow-none" required>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <td>
                                                <label class="form-label">
                                                    Already have an Account? <a type="button" class="text-success text-decoration-none shadow-none" href="index.php">Login</a>
                                                </label>
                                            </td>
                                            <td>
                                                <button name="register" type="submit" class="btn btn-success shadow-none" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" disabled>Register</button>
                                            </td>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
            </div>
        </div>
    </div>

    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>
    
    <script>
        function checkInputs() {
            var inputs = document.querySelectorAll('#registerModal input[type="text"], #registerModal input[type="email"], #registerModal input[type="number"], #registerModal input[type="password"], #registerModal textarea');
            var registerButton = document.querySelector('#registerModal button[type="submit"]');
            var pass = document.getElementById('pass');
            var repass = document.getElementById('repass');
            var passNoMatch = document.getElementById('passNoMatch');
            var passMatch = document.getElementById('passMatch');

            var isInputsValid = true;

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value === '') {
                    isInputsValid = false;
                    break;
                }
            }

            if (!isInputsValid || pass.value !== repass.value) {
                registerButton.disabled = true;
                if (pass.value !== repass.value) {
                    passNoMatch.hidden = false;
                    passMatch.hidden = true;
                } else {
                    passNoMatch.hidden = true;
                    passMatch.hidden = true;
                }
            } else {
                registerButton.disabled = false;
                passNoMatch.hidden = true;
                passMatch.hidden = false;
            }
        }

        // Event listener for text input changes
        var inputs = document.querySelectorAll('#registerModal input[type="text"], #registerModal input[type="email"], #registerModal input[type="number"], #registerModal input[type="password"], #registerModal textarea');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('input', checkInputs);
        }

        // Function to check if passwords match
        function checkPasswordMatch() {
            var pass = document.getElementById('pass');
            var repass = document.getElementById('repass');

            if (pass.value !== repass.value) {
                checkInputs();
            } else if (pass.value === repass.value) {
                var passNoMatch = document.getElementById('passNoMatch');
                var passMatch = document.getElementById('passMatch');
                passNoMatch.hidden = true;
                passMatch.hidden = false;
            } else {
                var passNoMatch = document.getElementById('passNoMatch');
                var passMatch = document.getElementById('passMatch');
                passNoMatch.hidden = true;
                passMatch.hidden = false;
            }
        }
    </script>
</body>


</html>