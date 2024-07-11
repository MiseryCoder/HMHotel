<?php
require('../admin/include/conn.php');
require('../admin/include/essentials.php');


date_default_timezone_set("Asia/Manila");


if(isset($_POST['info_form'])){
    $frm_data = filteration($_POST);
    session_start();

    $u_exist = select("SELECT * FROM `guests_users` WHERE `phonenum`=? AND `id`!=? LIMIT 1", [$frm_data['phonenum'],$_SESSION['uId']], "ss");


    if (mysqli_num_rows($u_exist) != 0) {
        echo 'phone_already';
        exit;
    }

    $query = "UPDATE `guests_users` SET `name`=?,`email`=?,`address`=?,`phonenum`=? WHERE `id`=? LIMIT 1";
    $values = [$frm_data['name'],$frm_data['email'],$frm_data['address'],$frm_data['phonenum'],$_SESSION['uId']];

    if(update($query,$values,'ssssi')){
        $_SESSION['uName'] = $frm_data['name'];
        echo 1;
    } else{
        echo 0;
    }
}


if(isset($_POST['profile_form'])){
    session_start();


    $img = uploadUserImage($_FILES['idpic']);

    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }

    //fetching old image and deletin it


    $u_exist = select("SELECT * FROM `guests_users` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], "s");
    $u_fetch = mysqli_fetch_assoc($u_exist);

    deleteImage($u_fetch['idpic'],USERS_FOLDER);



    $query = "UPDATE `guests_users` SET `idpic`=? WHERE `id`=? LIMIT 1";
    $values = [$img,$_SESSION['uId']];

    if(update($query,$values,'si')){
        $_SESSION['uPic'] = $img;
        echo 1;
    } else{
        echo 0;
    }
}


if(isset($_POST['pass_form'])){
    $frm_data = filteration($_POST);
    session_start();

    if($frm_data['new_pass']!=$frm_data['confirm_pass']){
        echo 'mismatch';
        exit;
    }

    $enc_pass = password_hash($frm_data['new_pass'], PASSWORD_BCRYPT);

    $query = "UPDATE `guests_users` SET `pass`=? WHERE `id`=? LIMIT 1";
    $values = [$enc_pass,$_SESSION['uId']];

    if(update($query,$values,'si')){
        echo 1;
    } else{
        echo 0;
    }
}

?>