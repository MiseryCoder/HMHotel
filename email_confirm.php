<?php

require('admin/include/conn.php');
require('admin/include/essentials.php');

if(isset($_GET['email_registration']))
{
    $data = filteration($_GET);

    $query = select("SELECT * FROM `guests_users` WHERE `email`=? AND `token`=? LIMIT 1",[$data['email'],$data['token']],'ss');

    if(mysqli_num_rows($query)==1)
    {
        $fetch = mysqli_fetch_assoc($query);
        if($fetch['is_verified']==1){
            echo"<script>alert('Email Already Verified!')</script>";
        }
        else{
            $update = update("UPDATE `guests_users` SET `is_verified`=? WHERE `id`=?",[1,$fetch['id']],'ii');
            if($update){
                echo"<script>alert('Email Verification Successful! Please Login your Account')</script>";
            }
            else{
                echo"<script>alert('Email Verification Failed! SERVER DOWN!')</script>";

            }
        }
        redirect('index.php');
    }
    else{
        echo "<script>alert('Invalid Link!')</script>";
        redirect('index.php');
    }
}

?>