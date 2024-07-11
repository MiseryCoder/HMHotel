<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image" href="img/logo.png">
    <link rel="stylesheet" href="css/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/animation/aos.css">
    <title>HM Hotel | Contact Us</title>

    <style>
        .collapse .navbar-nav .nav-item .nav-link.Cactive {
            font-weight: bold;
            color: #198754;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <!------Navigation Bar------>
    <?php
    require('include/navigation.php');
    require('ajax/sentiment/vendor/autoload.php');

    use Sentiment\Analyzer;
    ?>
    <!-- End of Navigation Bar -->



    <!------Content------>
    <!-------Contact Us Start------->



    <div class="container-xxl py-5 mt-5">
        <div class="container">
            <div class="text-center" data-aos="slide-down" data-aos-duration="1000" data-aos-once="true">
                <h1>Contact <span class="text-dark">Us</span></h1>
                <div class="h-line bg-success mb-5"></div>
            </div>

            <!-- eto ung pangkuha nung data sa database sa table na contact_details-->
            <?php
            $contact_q = "SELECT * FROM `contact_details` WHERE `contact_ID`=?";
            $values = [1];
            $contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i')); //select function sa admin/include/conn.php
            ?>

            <div class="row">
                <div class="col-lg-6 col-md-6 mb-5 px-4" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
                    <div class="bg-wwhite rounded shadow p-4 ">
                        <iframe class="w-100 rounded mb-4" src="<?php echo $contact_r['iframe']; ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <h5>Address</h5>
                        <a href="<?php echo $contact_r['gmap']; ?>" target="_blank" class="d-inline-block text-decoration-none text-dark">
                            <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address']; ?>
                        </a>
                        <h5 class="mt-4">Call us</h5>
                        <a href="tel: +63123456789" class="d-inline-block text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> <?php echo $contact_r['pn1']; ?>
                        </a>
                        <br>
                        <!--    <a href="tel: +63123456789" class="d-inline-block text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> <?php echo $contact_r['pn2']; ?>
                        </a>--->

                        <h5 class="mt-4">Email</h5>
                        <a href="mailto: HMHotel@gmail.com" class="d-inline-block text-decoration-none text-dark">
                            <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email']; ?>
                        </a>

                        <h5 class="mt-4">Follow us</h5>
                        <a href="<?php echo $contact_r['fb']; ?>" class="d-inline-block text-decoration-none mb-3">
                            <span class="text-dark fs-5 p-2">
                                <i class="bi bi-facebook me-1"></i>
                            </span>
                        </a>

                        <a href="<?php echo $contact_r['instagram']; ?>" class="d-inline-block text-decoration-none mb-3">
                            <span class="text-dark fs-5 p-2">
                                <i class="bi bi-google me-1"></i>
                            </span>
                        </a>

                        <a href="<?php echo $contact_r['twitter']; ?>" class="d-inline-block text-decoration-none mb-3">
                            <span class="text-dark fs-5 p-2">
                                <i class="bi bi-twitter me-1"></i>
                            </span>
                        </a>

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 mb-5 px-4" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
                    <div class="bg-wwhite rounded shadow p-4 ">
                        <h5 class="mb-3">Message Us</h5>
                        <div class="container-fluid">
                            <div class="row">
                                <form method="POST">
                                    <div class="col-md-12 ps-0 mb-3">
                                        <input name="name" required type="text" class="form-control shadow-none" placeholder="Full Name">
                                    </div>

                                    <div class="col-md-12 p-0 mb-3">
                                        <input name="email" required type="email" class="form-control shadow-none" placeholder="Email">
                                    </div>

                                    <div class="col-md-12 p-0 mb-3">
                                        <input name="subject" required type="text" class="form-control shadow-none" placeholder="Subject">
                                    </div>

                                    <div class="col-md-12 mb-3 p-0 ps-0 mb-3">
                                        <textarea name="message" required class="form-control" id="AddressText" rows="3" placeholder="Message"></textarea>
                                    </div>

                                    <div id="notice" class="mb-3">
                                        <small>
                                            * By submitting this form I agree to the HM Hotel Privacy Notice and giving my consent to the collection and processing of my personal data in accordance with Data Privacy Act 2012.
                                        </small>
                                    </div>

                                    <button name="send" class="btn btn-success mb-3" type="submit">SEND MESSAGE</button>
                                </form>
                            </div>
                        </div>
                        
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------Contact Us End------->

    <?php
    if (isset($_POST['send'])) {

        $frm_data = filteration($_POST);

        $obj = new Analyzer();
        // Update lexicon dynamically with new words

        $obj->updateLexicon($tagalogWords);


        $text = $frm_data['message'];
        $result = $obj->getSentiment($text);

        // Check sentiment and store in the database
        if ($result['compound'] <= -0.05) {
            $sentiment = 'Negative';
        } elseif ($result['compound'] >= 0.05) {
            $sentiment = 'Positive';
        } else {
            $sentiment = 'Neutral';
        }


        $query = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`, `sentiment`) VALUES (?,?,?,?,?)";
        $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $text, $sentiment];

        $res = insert($query, $values, 'sssss');
        if ($res == 1) {
            alert('success', 'Mail Sent!');
        } else {
            alert('error', 'Server Down, Try Again later.');
        }
    }
    ?>


    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->


    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>
    <script src="css/animation/aos.js"></script>
    <script>
        AOS.init({
            duration: 3000,
            once: true,
        });
    </script>


</body>

</html>