<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image" href="img/logo.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <title>HM Hotel | Profile</title>
</head>

<body>
    <!------Navigation Bar------>
    <?php

    require('include/navigation.php');

    //session login
    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('index.php');
    }

    $u_exist = select("SELECT * FROM `guests_users` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 's');

    if (mysqli_num_rows($u_exist) == 0) {
        redirect('index.php');
    }

    $u_fetch = mysqli_fetch_assoc($u_exist);

    ?>
    <!-- End of Navigation Bar -->

    <!------Content------>


    <!-- Room Start -->


    <div class="container py-5 mt-1">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="mb-3">PROFILE</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-success text-decoration-none">HOME</a>
                    <span class="text-success"> > </span>
                    <a class="text-success text-decoration-none">PROFILE</a>
                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-4 p-md-4 rounded shadow">
                    <form id="info-form">
                    <div class="row" style="padding: 20px;">
                        <h5 class="mb-3 fw-bold">Basic Information</h5>
                        
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" value="<?php echo $u_fetch['name'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input name="phonenum" type="number" value="<?php echo $u_fetch['phonenum'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" value="<?php echo $u_fetch['email'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="AddressText" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="AddressText" rows="2" required><?php echo $u_fetch['address'] ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-md shadow-none d-flex justify-content-end">Save Changes</button>

                    </form>
                </div>
            </div>

            <div class="col-md-4 mb-0 px-4">
                <div class="bg-white p-0 p-md-0 rounded shadow-none">
                    <form id="profile-form">
                        
                    </form>
                </div>
            </div>

           <div class="col-12 mb-5 px-4">
                <div class="bg-white p-4 p-md-4 rounded shadow">
                    <form id="pass-form">
                        <div class="row" style="padding: 20px;">
                        <h5 class="mb-3 fw-bold">Change Password</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input name="new_pass" type="password" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Re-type New Password</label>
                                <input name="confirm_pass" type="password" class="form-control shadow-none" required>
                            </div>

                            <div id="password-requirements" class="text-muted">
                               <strong class="text-yellow"> Password must contain at least 8 characters, one uppercase letter, one lowercase letter, and one special character. </strong>
                            </div>

                        </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-md shadow-none d-flex justify-content-end">Save Changes</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script>
        let info_form = document.getElementById('info-form');

        info_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let data = new FormData();
            data.append('info_form', '');
            data.append('name', info_form.elements['name'].value);
            data.append('phonenum', info_form.elements['phonenum'].value);
            data.append('email', info_form.elements['email'].value);
            data.append('address', info_form.elements['address'].value);

            //para maload ung query sa ajax/setting_crud.php. Sending data to
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);

            //para maload ung laman nung sa database
            xhr.onload = function() {
                if (this.responseText == 'phone_already') {
                    alert('error', "Phone Number is already Registered!");
                } else if (this.responseText == 0) {
                    alert('error', "No Changes Made!");
                } else {
                    alert('success', "Changes Saved!");
                }
            }
            xhr.send(data);
        });

        let profile_form = document.getElementById('profile-form');

        profile_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let data = new FormData();
            data.append('profile_form', '');
            data.append('idpic', profile_form.elements['idpic'].files[0]);

            //para maload ung query sa ajax/setting_crud.php. Sending data to
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);

            //para maload ung laman nung sa database
            xhr.onload = function() {
                if (this.responseText == 'inv_img') {
                    alert('error', "Only JPG, WEBP & PNG images are allowed!");
                } else if (this.responseText == 'upd_failed') {
                    alert('error', "image upload failed!");
                } else if (this.responseText == 0) {
                    alert('error', "Updation Failed");
                } else {
                    window.location.href = window.location.pathname;
                }
            }
            xhr.send(data);
        });

        

        let pass_form = document.getElementById('pass-form');
        let passwordRequirements = document.getElementById('password-requirements');
        

        pass_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let new_pass = pass_form.elements['new_pass'].value;
            let confirm_pass = pass_form.elements['confirm_pass'].value;

            // Add your password requirements here
            let requirementsRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            
            if (!requirementsRegex.test(new_pass)) {
            alert('error', 'Password must contain at least 8 characters,<br> one uppercase letter, one lowercase letter, <br> and one special character.');
            return false;
            }
           
            if(new_pass!=confirm_pass){
                alert('error','Password do not Match!');
                return false;
            }

            let data = new FormData();
            data.append('pass_form', '');
            data.append('new_pass', new_pass);
            data.append('confirm_pass', confirm_pass);

            //para maload ung query sa ajax/setting_crud.php. Sending data to
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);

            //para maload ung laman nung sa database
            xhr.onload = function() {
                if (this.responseText == 'mismatch') {
                    alert('error', "Password do not match");
                } else if (this.responseText == 0) {
                    alert('error', "Updation Failed");
                } else {
                    alert('success', 'Password Changed!');
                }
            }
            xhr.send(data);
        });
    </script>
</body>

</html>