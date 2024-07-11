<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

</head>

<?php

require('../admin/include/conn.php');
require('../admin/include/essentials.php');
require('../admin/include/mailer.php');
date_default_timezone_set("Asia/Manila");


//pag pinindot na si login

if (isset($_POST['login'])) {
    $data = filteration($_POST);


    //check user if it's exists int he database or not

    $u_exist = select("SELECT * FROM `guests_users` WHERE `email`=? OR `phonenum`=? LIMIT 1", [$data['email_mob'], $data['email_mob']], "ss");

    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email_mob';
        exit;
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            echo 'not_verified';
        } else if ($u_fetch['status'] == 0) {
            echo 'inactive';
        } else {
            if (!password_verify($data['pass'], $u_fetch['pass'])) {
                echo 'invalid_pass';
            } else {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['uId'] = $u_fetch['id'];
                $_SESSION['uName'] = $u_fetch['name'];
                $_SESSION['uPic'] = $u_fetch['idpic'];
                $_SESSION['uPhone'] = $u_fetch['phonenum'];
                echo 1;
            }
        }
    }
}


//pag pinindot na si send link sa forgot password

if (isset($_POST['forgot_pass'])) {
    $data = filteration($_POST);


    //check user if it's exists int he database or not

    $u_exist = select("SELECT * FROM `guests_users` WHERE `email`=? LIMIT 1", [$data['email']], "s");

    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email';
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            echo 'not_verified';
        } else if ($u_fetch['status'] == 0) {
            echo 'inactive';
        } else {
            //send reset link to email
            $token = bin2hex(random_bytes(16));

            $date = date("Y-m-d");

            $query = mysqli_query($con, "UPDATE `guests_users` SET `token`='$token' WHERE `id`='$u_fetch[id]'");

            
            if ($query) {
                send_mail($data['email'], $token, "account_recovery");
                echo 1;
            } else {
                echo 'upd_failed';
            }
        }
    }
}


if (isset($_POST['recover_user'])) {
    $data = filteration($_POST);

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    $query = "UPDATE `guests_users` SET `pass`=?, `token`=?, `t_expire`=? WHERE `email`=? AND `token`=?";

    $values = [$enc_pass, null, null, $data['email'], $data['token']];

    if (update($query, $values, 'sssss')) {
        echo 1;
    } else {
        echo 'failed';
    }
}
