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
    <title>Management | User Type</title>

    <style>
        .choosereg-form {
            padding-top: 200px;
        }

        @media screen and (max-width: 992px) {
            .choosereg-form {
                padding-top: 50px;
            }
        }

        pop{
            color: #fff;
        }

        .pop:hover {
            transform: scale(1.03);
            transition: all 0.3s;
            color: #198754;
        }

        #bbutton {
            display: inline;
        }
    </style>
</head>

<body>
    <div id="about" class="container choosereg-form">

        <div class="container">
            <h2 class="text-center fw-bold ">Choose User Type</h2>
            <div class="row g-5">


                <div class="container mt-5 ">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-xs-6 mb-4 px-4 pop">
                            <a class="text-decoration-none text-dark" href="m_register.php?reg=1">
                                <div class="bg-white rounded shadow p-4 border-success border-top border-4 text-center box">
                                    <img src="../img/mngmt.png" width="70">
                                    <h4 class="mt-3">MANAGEMENT</h4>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4 col-xs-6 px-4 pop">
                            <a class="text-decoration-none text-dark" href="m_register.php?reg=2">
                                <div class="bg-white rounded shadow p-4 border-success border-top border-4 text-center box">
                                    <img src="../img/fdesk.png" width="70">
                                    <h4 class="mt-3">FRONT DESK</h4>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4 col-xs-6 px-4 pop">
                            <a class="text-decoration-none text-dark" href="m_register.php?reg=4">
                                <div class="bg-white rounded shadow p-4 border-success border-top border-4 text-center box">
                                    <img src="../img/fnance.png" width="70">
                                    <h4 class="mt-3">FINANCE</h4>
                                </div>
                            </a>
                        </div>

                        <a href="index.php" class="btn btn-success shadow-none mb-5" id="bbutton" type="submit">BACK</a>




                    </div>
                </div>



            </div>


        </div>
    </div>

    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>
</body>

</html>