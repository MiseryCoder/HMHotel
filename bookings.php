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
    

    <title>HM Hotel | Bookings</title>
</head>

<body>
    <!------Navigation Bar------>
    <?php

    require('include/navigation.php');

    //session login
    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('index.php');
    }

    ?>
    <!-- End of Navigation Bar -->

    <!------Content------>


    <!-- Room Start -->


    <div class="container py-5 mt-1">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="mb-3">BOOKINGS</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-success text-decoration-none">HOME</a>
                    <span class="text-success"> > </span>
                    <a class="text-success text-decoration-none">BOOKINGS</a>
                </div>
            </div>

            <?php
            $query = "SELECT bo.*, bd.* FROM `booking_order` bo
                INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                WHERE ((bo.booking_status='Booked')
                OR (bo.booking_status='Cancelled')
                OR (bo.booking_status='Checked-In')
                OR (bo.booking_status='Checked-Out')
                OR (bo.booking_status='No Show')
                OR (bo.booking_status='Reserved')
                OR (bo.booking_status='Payment Failed'))
                AND (bo.user_id=?) 
                ORDER BY bo.booking_id DESC";

            $result = select($query, [$_SESSION['uId']], 'i');

            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    $date = date("d-m-Y", strtotime($data['datentime']));
                    $checkin = date("d-m-Y", strtotime($data['check_in']));
                    $checkout = date("d-m-Y", strtotime($data['check_out']));

                    $checkin_d = new DateTime($data['check_in']);
                    $checkout_d = new DateTime($data['check_out']);

                    $interval = $checkin_d->diff($checkout_d);
                    $count_days = $interval->days;

                    $status_bg = "";
                    $btn = "";
                    $btn2 = "";

                    //if booked
                    if ($data['booking_status'] == 'Booked' || $data['booking_status'] == 'Reserved') {
                        $status_bg = "bg-success";

                        if ($data['arrival'] == 0) {
                            $btn = "
                            <a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-success btn-sm shadow-none'>
                                <i class='bi bi-filetype-pdf me-1'></i> Download PDF
                            </a>
                        ";

                            $btn2 = "                     
                        <button onclick='cancel_booking($data[booking_id])' type='button' class='btn btn-danger btn-sm shadow-none'>
                            Cancel
                        </button>
                        
                        ";
                        } else {
                            $btn = "                     
                        <button onclick='cancel_booking($data[booking_id])' type='button' class='btn btn-danger btn-sm shadow-none'>
                            Cancel
                        </button>
                        
                        ";
                        }
                        //if Scheduled
                    } else if ($data['booking_status'] == 'Checked-Out') {
                        $status_bg = "bg-warning";

                        if ($data['arrival'] == 1) {
                            $btn = "
                            <a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-success btn-sm shadow-none'>
                                <i class='bi bi-filetype-pdf me-1'></i> Download PDF
                            </a>
                        ";

                            if ($data['rate_review'] == 0) {
                                $btn .= "
                            <button type='button' class='btn btn-success btn-sm shadow-none ms-2' onclick = 'review_room($data[booking_id],$data[room_id])' data-bs-toggle='modal' data-bs-target='#reviewModal'>
                                Rate & Review
                            </button>
                            
                            ";
                            }
                        } else {
                            $btn = "                     
                        <button onclick='cancel_booking($data[booking_id])' type='button' class='btn btn-danger btn-sm shadow-none'>
                            Cancel
                        </button>
                        
                        ";
                        }
                    } else if ($data['booking_status'] == 'Cancelled') {
                        $status_bg = "bg-danger";

                        if ($data['refund'] == 0) {
                            $btn = "<span class='badge bg-primary'>Refund in Proccess!</span>";
                        } else {
                            $btn = "
                        <a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-success btn-sm shadow-none'>
                            <i class='bi bi-filetype-pdf me-1'></i> Download PDF
                        </a>
                        
                        ";
                        }
                    } else {
                        $status_bg = "bg-warning";
                        $btn = "
                    <a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-success btn-sm shadow-none'>
                        <i class='bi bi-filetype-pdf me-1'></i> Download PDF
                    </a>
                    ";
                    }

                    echo <<<bookings
                    <div class='col-lg-4 col-md-6 col-sm-12 px-4 mb-4'>
                        <div class='bg-white p-4 rounded shadow'>
                            <h5 class='fw-bold'>$data[room_name]</h5>
                            <p>₱$data[price] per night</p>
                            
                            <p>
                                <b>Name: </b>$data[user_name] <br>
                                <b>Phone #: </b>$data[phonenum] <br>
                                <b>Email: </b>$data[email] 
                            </p>
                            <p>
                                <b>Check-in: </b>$checkin <br>
                                <b>Check-out: </b>$checkout <br>
                                <b>No. of days: </b>$count_days 
                            </p>

                            <p>
                                <b>Total Amount: </b>₱$data[total_pay] <br>
                                <b>Order ID: </b>$data[order_id] <br>
                                <b>Date: </b>$date<br> 
                            </p>

                            <p>
                                <span class='badge $status_bg'>$data[booking_status]</span>
                            </p>

                            $btn$btn2
                        </div>
                    </div>
                bookings;
                }
            } else {
                echo <<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-warning">
                                <i class="bi bi-exclamation-traaingle-fill"></i>
                                No Booking Record.
                                <br>
                            </p>
                        </div>
                    data;
            }

            ?>

        </div>
    </div>


    <!------ Modal for review ---->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="review-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-chat-square-heart fs-3 me-2"></i> Rate & Review
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select class="form-select shadow-none" name="rating">
                                <option value="5">Excellent</option>
                                <option value="4">Satisfied</option>
                                <option value="3">Good</option>
                                <option value="2">Poor</option>
                                <option value="1">Bad</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Review</label>
                            <textarea type="text" name="review" rows="3" class="form-control shadow-none" required></textarea>
                        </div>

                        <input type="hidden" name="booking_id">
                        <input type="hidden" name="room_id">

                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-sm shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!------ End Modal for review ---->


    <!-- Room End -->

    <?php
    if (isset($_GET['cancel_status'])) {
        alert('success', 'Booking Cancelled!');
    } else if (isset($_GET['review_status'])) {
        alert('success', 'Thank you for Rating and Review!');
    }
    ?>

    <!-- Footer -->
    <?php require('include/footer.php'); ?>
    <!-- Footer End -->


    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="css/swiper/swiper-bundle.min.js"></script>
    <script src="css/bootstrap/bootstrap.js"></script>

    
    <script>
        function cancel_booking(id) {
            if (confirm('Are you sure to Cancel your Booking?')) {
                //para maload ung query sa ajax/setting_crud.php. Sending data to
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/cancel_bookings.php", true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                //para maload ung laman nung sa database
                xhr.onload = function() {
                    if (this.responseText == 1) {
                        window.location.href = "bookings.php?cancel_status=true";
                    } else {
                        alert('error', 'Cancellation Failed!');
                    }
                }
                xhr.send('cancel_booking&id=' + id);
            }
        }

        let review_form = document.getElementById('review-form');

        function review_room(bid, rid) {
            review_form.elements['booking_id'].value = bid;
            review_form.elements['room_id'].value = rid;
        }

        review_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let data = new FormData();

            data.append('review_form', '');
            data.append('rating', review_form.elements['rating'].value);
            data.append('review', review_form.elements['review'].value);
            data.append('booking_id', review_form.elements['booking_id'].value);
            data.append('room_id', review_form.elements['room_id'].value);

            //para maload ung query sa ajax/setting_crud.php. Sending data to
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/review_room.php", true);

            //para maload ung laman nung sa database
            xhr.onload = function() {

                if (this.responseText == 1) {
                    window.location.href = 'bookings.php?review_status=true';
                } else {
                    var myModal = document.getElementById('reviewModal');
                    var modal = bootstrap.Modal.getInstance(myModal);
                    modal.hide();

                    alert('error', "Review & Rating Failed!");
                }

            }
            xhr.send(data);
        });
    </script>
</body>

</html>