<?php
require('include/conn.php');
require('include/essentials.php');

//session nasa include/essential.php
mngmtLogin();

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
    <title>HM Hotel | Pencil Bookings</title>
</head>

<style>
    #Nactive {
        font-weight: bolder;
        color: #198754;
    }

    #Nactive:hover {
        color: #198754;
    }

    /* Chrome, Safari, Edge, Opera */
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

<body>

    <!-- Navigation start -->
    <?php
    //pagshinutdown ang website
    require('include/Mnavigation.php');
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con, "SELECT `shutdown` FROM `about_details`"));

    ?>



    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <!--<div class="container">-->
                <!-- <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-1 d-flex justify-content-lg-right ">
                            <div class="btn-group" role="group">
                                
                                
                                <button href="new_bookings.php" type="button" disabled class="btn btn-success btn-s btn-sm shadow-none me-1" style="z-index: 0;">Pencil Booking</a>
                                <button class="btn btn-outline-success btn-s btn-sm shadow-none me-1" style="z-index: 0;">Reserved</button>
                                <a class="btn btn-outline-success btn-s btn-sm shadow-none me-1" href="checkin_booking.php" style="z-index: 0;">Checked-in</a>
                                <a class="btn btn-outline-success btn-s btn-sm shadow-none me-1" href="checkout_booking.php" style="z-index: 0;">Checked-out</a>
                                <a class="btn btn-outline-success btn-s btn-sm shadow-none me-1" href="cancelled.php" style="z-index: 0;">Cancelled</a>
                            </div>
                            <div class="btn-group" id="nav2" role="group">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-lg-start justify-content-center">
                            <?php
                            if ($is_shutdown['shutdown']) {
                                echo <<<data
                                        <h6 class="badge bg-danger py-2 px-3 rounded" style="z-index: 0;">Shutdown Mode is Active!</h6>
                                    data;
                            }
                            ?>
                        </div>
                    </div> -->


                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <?php
                        $sql2 = "SELECT * FROM management_users WHERE `m_id`='$_SESSION[mngmtID]'";
                        $result2 = $con->query($sql2);



                        if ($result2->num_rows >= 1) {
                            while ($row2 = $result2->fetch_assoc()) {
                                $login_type = $row2['m_type'];
                                if ($login_type == "Management") {
                                    echo <<< HTML
                                                        <a class="navbar-brand logo" href="#">
                                                            <b>BOOK STATUS</b>
                                                        </a>
                                                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                                            <span class="navbar-toggler-icon"></span>
                                                        </button>
                                                        <div class="collapse navbar-collapse justify-content-ceter" id="navbarSupportedContent">
                                                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link text-success PBactive" href="new_bookings.php"><b>Pencil Booking</b></a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link Ractive" href="res_bookings.php">Reserved</a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link Factive" href="checkin_booking.php">Checked-in</a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link AMactive" href="checkout_booking.php">Checked-out</a>
                                                                </li>
                            
                                                                <li class="nav-item">
                                                                    <a class="nav-link Aactive" href="cancelled.php">Cancelled</a>
                                                                </li>
                                                            </ul>
                            
                                                        </div>
                                                    HTML;
                                } else if ($login_type == "Front Desk") {
                                    echo <<< HTML
                                                    <a class="navbar-brand logo" href="#">
                                                        <b>BOOK STATUS</b>
                                                    </a>
                                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>
                                                    <div class="collapse navbar-collapse justify-content-ceter" id="navbarSupportedContent">
                                                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        

                                                            <li class="nav-item">
                                                                <a class="nav-link text-success Ractive" href="res_bookings.php">Reserved</a>
                                                            </li>
                                        
                                                            <li class="nav-item">
                                                                <a class="nav-link  Factive" href="checkin_booking.php">Checked-in</a>
                                                            </li>
                        
                                                            <li class="nav-item">
                                                                <a class="nav-link AMactive" href="checkout_booking.php">Checked-out</a>
                                                            </li>
                        
                                                            <li class="nav-item">
                                                                <a class="nav-link Aactive" href="cancelled.php">Cancelled</a>
                                                            </li>
                                                        </ul>
                        
                                                    </div>
                                                HTML;
                                } else if ($login_type == "Finance") {
                                    echo <<< HTML
                                                    <h3 class="mb-3 text-success fw-bold">Pencil Bookings</h3>
                                                HTML;
                                }
                            }
                        }
                        ?>
                    </div>
                </nav>






                <!-- Carousel Team Settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search for Name, OrderID or phone #">
                        </div>


                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="bg-success text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Booking Details</th>
                                        <th scope="col">Booking Status</th>
                                        <th scope="col">Valid ID</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Assign Room Number modal -->

    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">

            <div class="modal-content">
                <form id="assign_room_form">
                    <div class="modal-header">
                        <h5 class="modal-title">Make it a Reserved Room</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="booking_id">
                        <input type="hidden" name="amount_price">
                        <input type="hidden" name="amount_discounted" id="amount_discounted">
                        <input type="hidden" name="discount_percent" id="discount_percent">



                        <span class="d-flex badge rounded-pill bg-success mb-3 text-wrap fs-6 justify-content-center align-items-center lh-base ">
                            Note: Make sure that the Guests have paid the Reservation Fee.
                        </span>


                        <div class="col-md-12 mb-3">
                            <label class="form-label">Apply Discount?</label>
                            <div class="input-group">
                                <!-- Set the default value of the discount input to 0 -->
                                <input name="discount" oninput="check_discount_1st()" id="discount" type="number" value="0" class="form-control shadow-none" placeholder="Enter discount percentage">
                                <span class="input-group-text bg-success text-light" id="basic-addon2">%</span>
                            </div>
                            <div class="spinner-border text-success mb-3 d-none" id="info_loader" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h6 class="text-dark fw-bold" id="pay_info"></h6>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-success shadow-none">Reserve</button>
                    </div>
            </div>
            </form>
        </div>
    </div>


    <!-- Manage room images modal -->
    <div class="modal fade" id="valid_id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Valid ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <form id="valid_id_form" method="post">
                        <!-- Hidden input for user_id -->
                        <input type="hidden" name="user_id" value="">
                        <div id="user-image-data"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <!-- JavaScript Bundle with Popper -->

    <!-- alertbox lang to -->

    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>
    <?php require('include/scripts.php'); ?>


    <script>
        $(document).ready(function() {
            // When the form is submitted
            $("#assign_room_form").submit(function(e) {
                // Prevent the default form submission
                e.preventDefault();

                // Change the text of the button to a spinner
                var reserveButton = $(this).find("button[type='submit']");
                var originalText = reserveButton.text();
                reserveButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Reserving...');

                // Simulate an asynchronous action (e.g., AJAX request)
                setTimeout(function() {
                    // Restore the original text after the action is completed
                    reserveButton.html(originalText);

                    // You can add your actual form submission logic here if needed
                }, 5000); // Adjust the timeout as needed
            });
        });

        //make a function that can call the function check_discount when the value is 0

        let assign_room_form = document.getElementById('assign_room_form');


        function check_discount_1st() {
            let discountInput_val = assign_room_form.elements['discount'].value;


            // Check if either check-in or check-out values are not empty
            if (discountInput_val !== '') {
                check_discount();
            }
        }

        // for discount
        function check_discount() {
            let discountInput = assign_room_form.elements['discount'];
            let amount_val = assign_room_form.elements['amount_price'].value;
            let booking_id = assign_room_form.elements['booking_id'].value;
            let info_loader = document.getElementById('info_loader');
            let pay_info = document.getElementById('pay_info');

            let discount_val = discountInput.value;

            // Ensure the value is a valid number
            if (isNaN(discount_val)) {
                discount_val = 0; // Set default value to 0
            }

            // Limit the discount to 100
            discount_val = Math.min(100, discount_val);

            // Update the input value
            discountInput.value = discount_val;

            pay_info.classList.add('d-none');
            pay_info.classList.replace('text-dark', 'text-danger');
            info_loader.classList.remove('d-none');

            let data = new FormData();

            data.append('check_discount', '');
            data.append('discount', discount_val);
            data.append('amount', amount_val);
            data.append('booking_id', booking_id);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/discount.php", true);

            // para maload ung laman nung sa database
            xhr.onload = function() {
                let data = JSON.parse(this.responseText);

                pay_info.innerHTML =
                    "<br> Booking Fees: <span class='text-success' style='float: right;'> FREE </span>" +
                    "<br> Discount: <span class='text-dark' style='float: right;'> " + data.discount + "% </span>" +
                    "<br> Sub Total: <span class='text-dark' style='float: right;'>" + data.initial + "</span><hr>" +
                    "<h4>Total Amount to Pay:<span class='indented' style='float: right;'>₱" + data.discounted + "</span></h4>";

                // Update amount_discounted input field
                assign_room_form.elements['amount_discounted'].value = data.discounted;
                assign_room_form.elements['discount_percent'].value = data.discount;

                pay_info.classList.replace('text-danger', 'text-dark');

                pay_info.classList.remove('d-none');
                info_loader.classList.add('d-none');
            };

            xhr.send(data);
        }





        //pangkuha sa mngmt page nung nasa table
        function get_bookings(search = '') {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/new_bookings.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');


            //para maload ung laman nung sa database
            xhr.onload = function() {
                document.getElementById('table-data').innerHTML = this.responseText;
            }
            xhr.send('get_bookings&search=' + search);
        }


        function update_res(id, amount) {
            let assign_room_form = document.getElementById('assign_room_form');

            assign_room_form.elements['booking_id'].value = id;
            assign_room_form.elements['amount_price'].value = amount;

            let discountInput = document.getElementById('discount');

            // Set the discount input value to 0
            let newValue = 0;
            discountInput.value = newValue;

            // You may want to trigger the check_discount function after setting the value
            check_discount();

            // Set default values for amount_discounted and discount_percent
        }









        assign_room_form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Set default values for amount_discounted and discount_percent
            assign_room_form.elements['amount_discounted'].value = document.getElementById('amount_discounted').value || '';
            assign_room_form.elements['discount_percent'].value = document.getElementById('discount_percent').value || '';

            let data = new FormData(assign_room_form);
            data.append('assign_room', '');

            // The rest of your AJAX code remains unchanged
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/new_bookings.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('assign-room');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 1) {
                    alert('success', 'The room was successfully Reserved.');
                    assign_room_form.reset();
                    get_bookings();
                } else {
                    alert('error', 'Server Down!');
                }
            }

            xhr.send(data);
        });






        function cancel_booking(id) {
            if (confirm("Are you sure, you want to cancel this Booking?")) {
                let data = new FormData();
                data.append('booking_id', id);
                data.append('cancel_booking', '');

                //para maload ung query sa ajax/setting_crud.php. Sending data to
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/new_bookings.php", true);

                //para maload ung laman nung sa database
                xhr.onload = function() {
                    if (this.responseText == 1) {
                        alert('success', 'Booking Cancelled!');
                        get_bookings();
                    } else {
                        alert('error', 'Server Dowwn!');
                    }
                }
                xhr.send(data);
            }
        }

        let image_form = document.getElementById('valid_id');

        function valid_id_proof(id) {
            // Update the way you get the form element
            let image_form = document.getElementById('valid_id_form');
            if (!image_form) {
                console.error('Form element not found.');
                return;
            }

            image_form.elements['user_id'].value = id;

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/new_bookings.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('user-image-data').innerHTML = this.responseText;
            }

            xhr.send('get_id_images=' + id);
        }






        //pang load ulit nung nasa table:>
        window.onload = function() {
            get_bookings();
        }




        function loadDoc() {
            setInterval(function() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("noti_number").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "include/notifications/bookings.php", true);
                xhttp.send();
            }, 1000);
        }
        loadDoc();
    </script>
</body>

</html>