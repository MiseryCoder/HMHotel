<?php

require('include/conn.php');
require('include/essentials.php');

// Check if the form has been submitted
if (isset($_POST['otp'])) {
    $enteredOTP = $_POST['otpInput'];
    $id = $_GET['id'];

    // Prepare and execute the SQL query to update 'verified' to 1 if the OTP matches
    $stmt = $con->prepare("UPDATE management_users SET verified = 1 WHERE m_id = ? AND otp = ?");
    $stmt->bind_param("is", $id, $enteredOTP);
    if ($stmt->execute()) {
        // Check if any rows were affected (OTP matched and update successful)
        if ($stmt->affected_rows > 0) {
            // OTP is correct, redirect the user to index.php or perform any other actions
            header("Location: index.php");
            exit();
        } else {
            // Incorrect OTP, display an error message
            alert("error", "Wrong OTP code");
        }
    } else {
        // Handle the database error
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
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
    <title>HM Hotel | One Time Password</title>
</head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Dosis:300,400,500');

    /* Add your formal style modifications here */
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    h3 {
        color: #333;
        font-size: 24px;
        font-weight: 500;
        margin-top: 20px;
    }

    p {
        font-size: 14px;
        margin-bottom: 0;
    }

    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 40px 0 0 10px;
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

    .font-sss {
        font-size: 10px;
        position: absolute;
        bottom: 10px;
        left: 10px;
    }
</style>

<body>

    <div class="container">
        <img src="../img/plogo.png" class="img-fluid mb-4" alt="HM Hotel Logo" width="100px">
        <form method="POST">
            <h3>One Time Password</h3>
            <hr>

            <div class="modal-body">
                <p class="fw-bold mb-2">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <i>Note: Check your Email to get your OTP code.</i>
                </p>
                <h6>Enter Your 6-Digit Code</h6>

                <div class="mb-3 d-flex align-items-center justify-content-center">
                    <input type="number" name="otpInput" class="form-control shadow-none w-75" required>
                </div>

                <div class="d-flex align-items-center justify-content-end">
                    <button name="otp" type="submit" class="btn btn-success shadow-none">Submit</button>
                </div>

            </div>
        </form>
    </div>

    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>

</body>

</html>