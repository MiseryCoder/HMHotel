<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

// eto ung pangkuha nung data sa database sa table na about_details
$title_q = "SELECT * FROM `about_details` WHERE `settings_ID`=?";
$values = [1];
$title_r = mysqli_fetch_assoc(select($title_q, $values, 'i')); //select function sa admin/include/conn.php
?>

<?php
//eto ung pangkuha nung data sa database sa table na contact_details
$contact_q = "SELECT * FROM `contact_details` WHERE `contact_ID`=?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));


require('admin/include/mailer.php');
?>



<footer class="footer-top text-lg-start text-white">
    <!-- Grid container -->
    <div class="container p-4">
        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

                <div class="d-flex align-items-center justify-content-center mb-4 mx-auto" style="width: 130px; height: 130px;">
                    <img src="img/plogo.png" height="130" alt="" loading="lazy" />
                </div>

                <h4 class="text-center text-success"><?php echo $title_r['site_title']; ?></h4>

                <ul class="list-unstyled d-flex flex-row justify-content-center footer-contact">
                    <li>
                        <a class="text-white" href="https://web.facebook.com/pamantasannglungsodngpasig">
                            <i class="fab fa-facebook-square"></i>
                        </a>
                    </li>
                    <li>
                        <a class="text-white" href="https://twitter.com/psscofficial">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a class="text-white" href="https://goo.gl/maps/Hct9tB1UWaVrmhxr7">
                            <i class="bi bi-google"></i>
                        </a>
                    </li>
                </ul>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0 footer-contact">
                <h5 class="text-success text-uppercase mb-4">Navigation</h5>

                <ul class="list-unstyled ">
                    <li class="mb-2">
                        <a href="index.php" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-house pe-3"></i>Home</a>
                    </li>
                    <li class="mb-2">
                        <a href="rooms.php" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-bed pe-3"></i>Rooms</a>
                    </li>
                    <li class="mb-2">
                        <a href="facility.php" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-door-open pe-3"></i>Facilities</a>
                    </li>
                    <li class="mb-2">
                        <a href="Amenities.php" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-tv pe-3"></i>Amenities</a>
                    </li>

                </ul>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-success text-uppercase mb-4">About Us</h5>

                <ul class="list-unstyled ">
                    <li class="mb-2">
                        <a href="AboutUS.php" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-circle-info pe-3"></i>General Information</a>
                    </li>
                    <li class="mb-2">
                        <a href="FAQ.php" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-circle-question pe-3"></i>FAQ</a>
                    </li>
                    <li class="mb-2">
                        <a href="T&C.php" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-scroll pe-3"></i>Terms and Conditions</a>
                    </li>

                </ul>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-success text-uppercase mb-4">Contact Us</h5>

                <ul class="list-unstyled ">
                    <li class="mb-2">
                        <a href="#!" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-address-card pe-3"></i><?php echo $contact_r['address']; ?></a>
                    </li>
                    <li class="mb-2">
                        <a href="#!" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-phone pe-3"></i><?php echo $contact_r['pn1']; ?></a>
                    </li>
                    <li class="mb-2">
                        <a href="#!" class="d-inline-block text-decoration-none text-secondary"><i class="fa-solid fa-envelope pe-3"></i><?php echo $contact_r['email']; ?></a>
                    </li>

                </ul>
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class=" footer-bottom">
        <div class="container">
            &copy; <?php echo $title_r['site_title']; ?> of PLPasig | 2022
        </div>
    </div>
    <!-- Copyright -->
</footer>
<!-- End of .container -->


<?php

if (isset($_POST['login'])) {
    $data = filteration($_POST);

    // Check if the user exists in the database or not
    $u_exist = select("SELECT * FROM `guests_users` WHERE `email`=? OR `phonenum`=? LIMIT 1", [$data['email_mob'], $data['email_mob']], "ss");

    if (mysqli_num_rows($u_exist) == 0) {
        alert('error', "Invalid Email or Mobile Number");
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            alert('error', "Email is not Verified!");
        } else if ($u_fetch['status'] == 0) {
            alert('error', "Account Suspended! Please Contact Admin");
        } else {
            if (!password_verify($data['pass'], $u_fetch['pass'])) {
                alert('error', "Incorrect Password!");
            } else {
                // Store user information in session variables
                $_SESSION['login'] = true;
                $_SESSION['uId'] = $u_fetch['id'];
                $_SESSION['uName'] = $u_fetch['name'];
                $_SESSION['uPic'] = $u_fetch['idpic'];
                $_SESSION['uPhone'] = $u_fetch['phonenum'];


                // Refresh the page after successful login, only if it hasn't been reloaded before
                if (!isset($_SESSION['page_reloaded'])) {
                    $_SESSION['page_reloaded'] = true;
                    echo '<script>window.location.reload();</script>';
                } else {
                    alert('success', "Welcome back, " . $u_fetch['name'] . "!");
                    //for system logs
                    $sys_email = "";
                    $sys_name = "";
                    $sys_action = "Logged in";
                    $sys_user_type = "Guest User";

                    // gettingall the rooms for the select tag and input the room types
                    $room = $con->query("SELECT * FROM `guests_users` WHERE `id`='$_SESSION[uId]'");
                    foreach ($room->fetch_all(MYSQLI_ASSOC) as $row) {
                        $sys_email = $row['email'];
                        $sys_name = $row['name'];
                    }
                    $query = "INSERT INTO `systemlog`(`email`,`name`,`action`,`User_type`) VALUES (?,?,?,?)";
                    $values = [$sys_email, $sys_name, $sys_action, $sys_user_type];
                    $res = insert($query, $values, 'ssss');
                }
            }
        }
    }
}


if (isset($_POST['register'])) {
    // Filter and sanitize input data
    $data = filteration($_POST);

    // Check if the email already exists in the database
    $u_exist = select("SELECT * FROM `guests_users` WHERE `email`=? LIMIT 1", [$data['email']], "s");

    if (mysqli_num_rows($u_exist) > 0) {
        // Email already exists
        $user_data = mysqli_fetch_assoc($u_exist);

        if ($user_data['is_verified'] == 0) {
            // Email is not verified, send verification email
            $token = bin2hex(random_bytes(32));
            send_mail($data['email'], $token, "email_registration");

            // Show a success message
            alert('success', "Mail sent. Check your email inbox or spam message to re-verify your account");
        } else {
            alert('error', "Email Already Exists.");
        }
    } else {
        // Email is unique, proceed with registration
        // Generate a unique token for email verification (replace this with your logic)
        $token = bin2hex(random_bytes(32));
        // Hash the password before storing it in the database (for security)
        $hashed_password = password_hash($data['pass'], PASSWORD_DEFAULT);
        // Insert the user data into the database
        $insert_result = insert("INSERT INTO `guests_users` (`name`, `email`, `phonenum`, `pass`, `token`) VALUES (?, ?, ?, ?, ?)", [$data['name'], $data['email'], $data['phonenum'], $hashed_password, $token], "sssss");

        if ($insert_result) {
            // Registration successful, send email confirmation
            send_mail($data['email'], $token, "email_registration");
            // Show a success message
            alert('success', "Registration Successful. Check your email to verify your account");
        } else {
            // Registration failed, show an error message
            alert('error', "Registration Failed");
        }
    }
}







// Clear the reload flag if the user is not logged in
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    unset($_SESSION['page_reloaded']);
}

?>


<script>
    // Get the input element
    var nameInput = document.getElementById("nameInput");

    // Add an input event listener
    nameInput.addEventListener("input", function(event) {
        // Get the input value
        var inputValue = event.target.value;

        // Remove special characters and allow alphanumeric characters and spaces
        var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');

        // Update the input value
        event.target.value = sanitizedValue;
    });
</script>


<script>
    function checkLoginToBook(status, room_id, checkin, checkout) {
        if (status) {
            window.location.href = 'confirm_booking.php?room_id=' + room_id + '&checkin=' + checkin + '&checkout=' + checkout;
        } else {
            alert('error', 'Please Login to Book a Room!');
        }
    }


    function checkInputs() {
        var inputs = document.querySelectorAll('#registerModal input[type="text"], #registerModal input[type="email"], #registerModal input[type="number"], #registerModal input[type="password"], #registerModal textarea');
        var registerButton = document.querySelector('#registerModal button[type="submit"]');
        var pass = document.getElementById('pass');
        var repass = document.getElementById('repass');
        var passnmatch = document.getElementById('passnmatch');
        var passmatch = document.getElementById('passmatch');

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
                passnmatch.hidden = false;
                passmatch.hidden = true;
            } else {
                passnmatch.hidden = true;
                passmatch.hidden = true;
            }
        } else {
            registerButton.disabled = false;
            passnmatch.hidden = true;
            passmatch.hidden = false;
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
        } else {
            var passnmatch = document.getElementById('passnmatch');
            var passmatch = document.getElementById('passmatch');
            passnmatch.hidden = true;
            passmatch.hidden = false;
        }
    }


    // //insertion ng data  for registration - Guests side
    // let register_form = document.getElementById('register-form');

    // register_form.addEventListener('submit', (e) => {
    //     e.preventDefault();

    //     let data = new FormData();

    //     data.append('name', register_form.elements['name'].value);
    //     data.append('email', register_form.elements['email'].value);
    //     data.append('phonenum', register_form.elements['phonenum'].value);
    //     data.append('pass', register_form.elements['pass'].value);
    //     data.append('repass', register_form.elements['repass'].value);
    //    // data.append('idpic', register_form.elements['idpic'].files[0]);
    //     data.append('register', '');


    //     var myModal = document.getElementById('registerModal');
    //     var modal = bootstrap.Modal.getInstance(myModal);
    //     modal.hide();

    //     var myModal = document.getElementById('notifEmail');
    //     var modal = bootstrap.Modal.getInstance(myModal);
    //     modal.show();

    //     //para maload ung query sa ajax/features_facilities.php Sending data to
    //     let xhr = new XMLHttpRequest();
    //     xhr.open("POST", "ajax/login_register.php", true);


    //     //para maload ung laman nung sa database
    //     xhr.onload = function() {
    //         if (this.responseText == "pass_mismatch") {
    //             alert("error", "Password Mismatch", "body");
    //         } else if (this.responseText == "email_already") {
    //             alert("error", "Email is already Registered!", "body");
    //         } else if (this.responseText == "phone_already") {
    //             alert("error", "Phone Number is already Registered!", "body");
    //         } else if (this.responseText == "inv_img") {
    //             alert("error", "Only JPG, WEBP & PNG images are allowed!", "body");
    //         } else if (this.responseText == "upd_failed") {
    //             alert("error", "image upload failed!", "body");
    //         } else if (this.responseText == "mail_failed") {
    //             alert("error", "Cannot send confirmation email!", "body");
    //         } else if (this.responseText == "ins_failed") {
    //             alert("error", "Registration failed! Server Down!", "body");
    //         } else if(this.responseText == 1){
    //             alert("success", "Registration Successful, Check your email to verify your account", "body");
    //             register_form.reset();
    //         }
    //     }
    //     xhr.send(data);


    // });


    //para sa otp
    let otp_form = document.getElementById('otp-form');

    otp_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('otp', otp_form.elements['otpInput'].value);
        data.append('otpbutton', '');



        //para maload ung query sa ajax/features_facilities.php Sending data to
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);


        //para maload ung laman nung sa database
        xhr.onload = function() {

            if (this.responseText == "inv_code") {
                alert('error', "Invalid code");

            } else if (this.responseText == "exp_code") {
                alert('error', "The code expired!");

            } else if (this.responseText == "upd_failed") {
                alert('error', "System down, Try Again Later!");

            } else {
                alert('success', "Success, Please Login");
                otp_form.reset();
                var myModal = document.getElementById('otpModal');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                var myModal2 = document.getElementById('loginModal');
                var modal2 = bootstrap.Modal.getInstance(myModal2);
                modal.show();

            }
        }
        xhr.send(data);
    });

    //para sa forgot password
    let forgot_form = document.getElementById('forgot-form');

    forgot_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('email', forgot_form.elements['email'].value);
        data.append('forgot_pass', '');


        var myModal = document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();


        //para maload ung query sa ajax/features_facilities.php Sending data to
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);


        //para maload ung laman nung sa database
        xhr.onload = function() {
            if (this.responseText == 'inv_email') {
                alert('error', "Invalid Email or Mobile Number");
            } else if (this.responseText == 'not_verified') {
                alert('error', "Email is not Verified!");
            } else if (this.responseText == 'inactive') {
                alert('error', "Account Suspended! Please Contact Admin");
            } else if (this.responseText == 'mail_failed') {
                alert('error', "Cannot send Email! Server Down!!!");
            } else if (this.responseText == 'upd_failed') {
                alert('error', "Account Recovery Failed! Server Down!");
            } else {
                alert('success', "Reset Link Sent to Email", "body");


                forgot_form.reset();
            }
        }
        xhr.send(data);
    });
</script>