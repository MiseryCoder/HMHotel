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
    <title>HM Hotel | Ratings & Reviews</title>
</head>

<style>
    #SAactive,
    #Feedactive {
        font-weight: bolder;
        color: #198754;
    }

    #SAactive:hover,
    #Feedactive:hover {
        color: #198754;
    }


    .progress-label-left {
        float: left;
        margin-right: 0.5em;
        line-height: 1em;
    }

    .progress-label-right {
        float: right;
        margin-left: 0.3em;
        line-height: 1em;
    }

    .star-light {
        color: #e9ecef;
    }

     /* Add color styles for positive, neutral, and negative feedback */
     .positive-feedback {
        color: #28a745; /* Green color for positive feedback */
    }

    .neutral-feedback {
        color: #ffc107; /* Yellow color for neutral feedback */
    }

    .negative-feedback {
        color: #dc3545; /* Red color for negative feedback */
    }
    
</style>

<body>

    <!-- Navigation start -->
    <?php require('include/Mnavigation.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-3 overflow-hidden">
                <h3 class="mb-3 text-success fw-bold">SENTIMENT ANALYSIS</h3>

                <!-- Carousel Team Settings -->
                <div class="row">
                    <div class="col-lg-4 col-md-12 px-4">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <b>Category:</b>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <select class="shadow-none form-select w-100" id="room_category_choice" name="room_category_choice">
                                                <option>Select Room Category</option>
                                                <option value="GR">Guest Room</option>
                                                <option value="F">Facility</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4">
                                        <b>Room Type:</b>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <select class="shadow-none form-select w-100" id="room_type_select" name="room">
                                                <option>Select Room Type</option>
                                                <!-- Options will be loaded dynamically using AJAX -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-4">
                                        <b>Room:</b>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <select class="shadow-none form-select w-100" id="room_no_select" name="roomno">
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- main content -->
                    <div class="col-lg-8 col-md-12 px-4">
                        <div class="row">
                        
                           
                            <!-- Review Analytics -->
                        
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-body">
                                <h6>Review Analytics</h6>
                                <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <h1 class="text-warning mt-4 mb-4">
                                            <b><span id="average_rating">0.0</span> / 5</b>
                                        </h1>
                                        <div class="mb-3">
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                        </div>
                                        <h3><span id="total_review">0</span> Review</h3>
                                    </div>

                                    <div class="col-sm-4">
                                        <p>
                                        <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                                        <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                                        </div>
                                        </p>
                                        <p>
                                        <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                                        <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                                        </div>
                                        </p>
                                        <p>
                                        <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                                        <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                                        </div>
                                        </p>
                                        <p>
                                        <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                                        <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                                        </div>
                                        </p>
                                        <p>
                                        <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                                        <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                                        </div>
                                        </p>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <h5>Feedback:</h5>
                                        <h3 id="feedback_text" class="feedback-color"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 mb-5" id="review_content"></div>
                    </div>

                    </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>
    </div>


    <!-- JavaScript Bundle with Popper -->
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../css/swiper/swiper-bundle.min.js"></script>
    <script src="../css/bootstrap/bootstrap.js"></script>

    <!-- alertbox lang to -->

    <?php require('include/scripts.php'); ?>

    <script>
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
        var roomNoSelected = $("#room_type_select");
        var selectedRoomId = roomNoSelected.val(); // Assuming this returns a single room ID




                function load_rating_data(selectedRoomId) {
                $.ajax({
                url: "ajax/fetch_room_types.php",
                method: "POST",
                data: {
                    action: selectedRoomId,
                },
                dataType: "JSON",
                success: function (data) {
                    // Determine feedback based on average rating
                    var feedbackText = "";
                    var feedbackClass = ""; // Add this line

                    if (data.average_rating >= 4 && data.average_rating <= 5) {
                        feedbackText = "Positive";
                        feedbackClass = "positive-feedback"; // Add this line
                    } else if (data.average_rating === 3) {
                        feedbackText = "Neutral";
                        feedbackClass = "neutral-feedback"; // Add this line
                    } else if (data.average_rating >= 1 && data.average_rating <= 2) {
                        feedbackText = "Negative";
                        feedbackClass = "negative-feedback"; // Add this line
                    } else if (data.average_rating === 0) {
                        feedbackText = "No Feedback";
                    }

            // Display the feedback and apply color coding
            $('#feedback_text').text(feedbackText).removeClass("positive-feedback neutral-feedback negative-feedback").addClass(feedbackClass);

            // Display the feedback
                    $('#feedback_text').text(feedbackText);
                    $('#average_rating').text(data.average_rating);
                    $('#total_review').text(data.total_review);

                    var count_star = 0;

                    $('.main_star').each(function() {
                        count_star++;
                        if (Math.ceil(data.average_rating) >= count_star) {
                            $(this).addClass('text-warning');
                            $(this).addClass('star-light');
                        }
                    });

                    $('#total_five_star_review').text(data.five_star_review);
                    $('#total_four_star_review').text(data.four_star_review);
                    $('#total_three_star_review').text(data.three_star_review);
                    $('#total_two_star_review').text(data.two_star_review);
                    $('#total_one_star_review').text(data.one_star_review);

                    $('#five_star_progress').css('width', (data.five_star_review / data.total_review) * 100 + '%');
                    $('#four_star_progress').css('width', (data.four_star_review / data.total_review) * 100 + '%');
                    $('#three_star_progress').css('width', (data.three_star_review / data.total_review) * 100 + '%');
                    $('#two_star_progress').css('width', (data.two_star_review / data.total_review) * 100 + '%');
                    $('#one_star_progress').css('width', (data.one_star_review / data.total_review) * 100 + '%');

                    if (data.review_data.length > 0) {
                        var html = '';

                        for (var count = 0; count < data.review_data.length; count++) {
                            html += '<div class="row mb-3">';
                            html += '<div class="col-sm-1">';
                            html += '<div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">';
                            html += '<h3 class="m-0">' + data.review_data[count].user_id.charAt(0) + '</h3>';
                            html += '</div>';
                            html += '</div>';
                            html += '<div class="col-sm-11">';
                            html += '<div class="card mb-3">';
                            html += '<div class="card-header no-shadow"><b>' + data.review_data[count].user_id + '</b></div>';
                            html += '<div class="card-body">';

                            for (var star = 1; star <= 5; star++) {
                                var class_name = '';
                                if (data.review_data[count].rating >= star) {
                                    class_name = 'text-warning';
                                } else {
                                    class_name = 'star-light';
                                }
                                html += '<i class="fas fa-star ' + class_name + ' mr-1"></i>';
                            }

                            html += '<br />';
                            html += data.review_data[count].review;
                            html += '</div>';
                            html += '<div class="card-footer text-end">On ' + data.review_data[count].datentime + '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        }

                        $('#review_content').html(html);
                    }
                }
            });
        }


        $(document).ready(function() {
            var roomTypeSelect = $("#room_type_select");
            var categorySelect = $("#room_category_choice");
            var selectedRoomId;

            // Initially disable the room_type_select
            roomTypeSelect.empty().prop('disabled', true);

            categorySelect.on("change", function() {
                var selectedCategory = $(this).val();

                // Enable/disable roomTypeSelect based on category
                if (selectedCategory === 'GR' || selectedCategory === 'F') {
                    roomTypeSelect.prop('disabled', false);

                    // Perform the AJAX request to load room types
                    $.ajax({
                        type: "POST",
                        url: "ajax/fetch_room_types.php",
                        data: {
                            room_category_choice: selectedCategory
                        },
                        success: function(data) {
                            $("#room_type_select").html(data);

                            // When the room types are loaded, trigger a change event to update the reviews for the selected room type
                            roomTypeSelect.trigger("change");
                        }
                    });
                } else {
                    roomTypeSelect.empty().prop('disabled', true);
                    // Clear the reviews when category changes
                }
            });

            // Handle room type selection
            roomTypeSelect.on("change", function() {
                selectedRoomId = $(this).val();
                load_rating_data(selectedRoomId);
            });

            //ratings review script
            var rating_data = 0;

            $(document).on('mouseenter', '.submit_star', function() {
                var rating = $(this).data('rating');
                reset_background();
                for (var count = 1; count <= rating; count++) {
                    $('#submit_star_' + count).addClass('text-warning');
                }
            });

            function reset_background() {
                for (var count = 1; count <= 5; count++) {
                    $('#submit_star_' + count).addClass('star-light');
                    $('#submit_star_' + count).removeClass('text-warning');
                }
            }

            $(document).on('mouseleave', '.submit_star', function() {
                reset_background();
                for (var count = 1; count <= rating_data; count++) {
                    $('#submit_star_' + count).removeClass('star-light');
                    $('#submit_star_' + count).addClass('text-warning');
                }
            });

            $(document).on('click', '.submit_star', function() {
                rating_data = $(this).data('rating');
            });

            // Load the initial rating data
            load_rating_data(selectedRoomId);
        });
    </script>

</body>

</html>