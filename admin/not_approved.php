<?php
require('include/conn.php');
require('include/essentials.php');

// $m_id = $_GET['m_id'];
// // $login_type = "";

// $query = "SELECT * FROM `management_users` WHERE `m_id`=?";
// $values = [$m_id];

// $res = select($query, $values, "i");

// if ($res->num_rows == 1) {
//     $row = mysqli_fetch_assoc($res);
//     // $login_type = $row['m_type'];
// }
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
    <title>HM Hotel | Not Approved</title>
</head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Dosis:300,400,500');

    /* Add your formal style modifications here */
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    h1 {
        color: #333;
        font-size: 32px;
        font-weight: 500;
        margin-top: 40px;
    }

    p {
        font-size: 18px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        text-align: center;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        margin-top: 100px;
    }

    .btn-go-home {
        display: inline-block;
        margin-top: 30px;
        padding: 10px 20px;
        font-size: 16px;
        text-decoration: none;
        background-color: #FFCB39;
        color: #fff;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-go-home:hover {
        background-color: #FFB800;
    }
</style>

<body>

    <div class="container">
        <img src="../img/plogo.png" alt="HM Hotel Logo" width="200px">
        <h1>Your Account is Not Approved by the Management Yet</h1>
        <p>Please wait for the management to approve your account.</p>
        <a href="index.php" class="btn btn-success">GO BACK TO LOGIN</a>
    </div>

    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>
</body>

</html>