<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" type="image" href="img/logo.png">

	<link rel="stylesheet" href="css/swiper/swiper-bundle.min.css">
	<link rel="stylesheet" href="css/bootstrap/bootstrap-icons.css">
	<link rel="stylesheet" href="css/fontawesome/css/all.css">
	<link rel="stylesheet" href="css/bootstrap/bootstrap.css">
	<link rel="stylesheet" href="css/animation/aos.css">

	<title>HM Hotel | Home</title>
</head>

<style>
	/* Chrome, Safari, Edge, Opera */
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	/* Add this style to ensure the modal appears above the footer */
	.modal1 {
		z-index: 1050;
	}

	/* Firefox */
	input[type=number] {
		-moz-appearance: textfield;
	}

	.collapse .navbar-nav .nav-item .nav-link.Hactive {
		font-weight: bold;
		color: #198754;
	}

	.pop:hover {
		transform: scale(1.03);
		transition: all 0.3s;
	}

	.button {
		box-shadow: none;
	}


	.box:hover {
		transform: scale(1.10);
		/* Increase the size of the image on hover */
		transition: transform 0.2s ease;
		/* Add a smooth transition effect */
		cursor: pointer;
		/* Change the cursor to a pointer on hover */
	}

	.box {
		position: relative;
		overflow: hidden;
	}

	.details {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(255, 255, 255, 0.9);
		/* Adjust the background color and transparency */
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		opacity: 0;
		transition: opacity 0.3s ease;
		font-size: 14px;
	}

	.box:hover .details {
		opacity: 1;
	}

	.details p {
		margin: 0;
		font-size: 55px;
		font-family: Arial, Helvetica, sans-serif;
		font-weight: bolder;
		color: #198754;
	}

	.mb-4 {
		text-align: justify;
	}

	.h1 {
		text-align: center;
	}

	img {
		transition: transform 0.3s ease-in-out;
	}

	img:hover {
		transform: scale(1.2);
	}

	#carou {
		margin-top: 55px;
	}
</style>

<body>

	<!------Navigation Bar------>
	<?php require('include/navigation.php') ?>
	<!-- End Navigation Bar -->

	<!------ Carousel Banner ------>

	<div class="container-fluid p-0 carousel">
		<!-- Swiper -->
		<div id="carou" class="swiper swiper-container">
			<div class="swiper-wrapper">
				<?php
				$res = selectAll('carousel');

				while ($row = mysqli_fetch_assoc($res)) {
					$path = CAROUSEL_IMG_PATH;
					echo <<< data
							<div class="swiper-slide">
								<img src="$path$row[image]" class="w-100 d-block" />
							</div>
						data;
				}
				?>
			</div>
		</div>
	</div>

	<!-- filter rooms -->
	<div class="container booking">
		<div class="row">
			<div class="col-lg-12 bg-white shadow p-4 rounded">
				<h5 class="text-center mb-4">Check Available Room</h5>
				<form action="rooms.php">
					<div class="row align-items-end">

						<!-- START OF UPDATE -->

						<div class="col-lg-4">
							<label class="form-label" style="font-weight: 500;">Check-in</label>&nbsp;<span style="color: #198754" id="checkinDay"></span> <!--ito yung text para mapalabas yung correspond days -->
							<!-- Set the min attribute to disable past dates -->
							<input type="date" class="form-control shadow-none custom-date-picker" name="checkin" id="checkin" required min="<?php echo date('Y-m-d'); ?>">

						</div>

						<div class="col-lg-4"><br>
							<label class="form-label" style="font-weight: 500;">Check-out</label>&nbsp;<span style="color: #198754" id="checkoutDay"></span> <!--ito yung text para mapalabas yung correspond days for checkout -->
							<!-- Set the min attribute to disable past dates -->
							<input type="date" class="form-control shadow-none custom-date-picker" name="checkout" id="checkout" required min="<?php echo date('Y-m-d'); ?>">
						</div>


						<!-- JAVASCRIPT NG UPDATES CALENDAR PICKER NAPAPALABAS NA YUNG DAYS -->

						<script>
							// Function to update the day of the week
							function updateDayOfWeek(inputId, dayId) {
								var input = document.getElementById(inputId);
								var daySpan = document.getElementById(dayId);

								// Check if the input value is not empty
								if (input.value) {
									var date = new Date(input.value);
									var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
									var dayOfWeek = daysOfWeek[date.getDay()];

									// Update the span with the day of the week
									daySpan.textContent = dayOfWeek;
								} else {
									// If input is empty, clear the span
									daySpan.textContent = '';
								}
							}





							// Attach event listeners to input elements
							document.getElementById('checkin').addEventListener('input', function() {
								updateDayOfWeek('checkin', 'checkinDay');
							});

							document.getElementById('checkout').addEventListener('input', function() {
								updateDayOfWeek('checkout', 'checkoutDay');
							});
						</script>


						<!-- END OF UPDATE -->



						<div class="col-lg-3"><br>
							<label class="form-label" style="font-weight: 500;">Capacity</label>
							<select class="form-select shadow-none" name="adult" required>
								<?php
								//maximum adlut and children for dropdown
								$guests_q = mysqli_query($con, "SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children` 
												FROM `rooms` WHERE `status`='1' AND `removed`='0'");

								$guests_res = mysqli_fetch_assoc($guests_q);

								for ($i = 1; $i <= $guests_res['max_adult']; $i++) {
									echo "<option value='$i'>$i</option>";
								}

								?>
							</select>
						</div>
						<div class="col-lg-2" hidden><br>
							<label class="form-label" style="font-weight: 500;">Children</label>
							<select class="form-select shadow-none" name="children" required>
								<?php
								for ($i = 1; $i <= $guests_res['max_children']; $i++) {
									echo "<option value='$i'>$i</option>";
								}
								?>
							</select>
						</div>
						<input type="hidden" name="check_availability">
						<div class="col-lg-1">
							<br><button type="submit" class="btn btn-success shadow-none">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- end of filter rooms -->

	<!------Content------>
	<!-- About Start -->
	<div id="about" class="container-xxl py-5">
		<div class="container">
			<div class="row g-5 align-items-center" data-aos="slide-up" data-aos-duration="2000" data-aos-once="true">
				<div class="col-lg-6">
					<h6 class="section-title text-start text-success text-uppercase">About Us</h6>
					<h2 class="mb-4">Welcome to <span class="text-dark text-uppercase">HM Hotel</span></h2> <!-- Change Text into Black -->
					<p class="mb-4">The Pamantasan ng Lungsod ng Pasig (PLP) HRM Multi-purpose Building is a Serbisyong May Puso Project of the City Government of Pasig envisioned during the compassionate administration of Mayor Maribel Andaya Eusebio designed as a training facility for world class studentry. The PLP-HRM Multi-Purpose Building consists of amenities that blends aesthetics and functionality and creates an environment meant to inspire the youth to conquer the limitless world of knowledge.</p>

					<a class="btn btn-success shadow-none py-3 px-5 mt-2" href="AboutUS.php">Explore More</a>
				</div>
				<div class="col-lg-6">
					<div class="row g-3">
						<div class="col-6 text-end" data-aos="fade-out" data-aos-duration="2000" data-aos-once="true">
							<img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="img/homepage3.jpg" style="margin-top: 25%;">
						</div>
						<div class="col-6 text-start" data-aos="fade-out" data-aos-duration="3000" data-aos-once="true">
							<img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="img/homepage4.jpg">
						</div>
						<div class="col-6 text-end" data-aos="fade-out" data-aos-duration="4000" data-aos-once="true">
							<img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="img/homepage2.jpg">
						</div>
						<div class="col-6 text-start" data-aos="fade-out" data-aos-duration="5000" data-aos-once="true">
							<img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="img/homepage1.jpg">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- About End -->


	<!-- Room Start -->
	<div class="container-xxl py-5">
		<div class="container">
			<div class="text-center wow fadeInUp" data-wow-delay="0.1s">
				<h6 class="section-title text-center text-success text-uppercase">The Rooms</h6>
				<h2 class="mb-3">Explore Our <span class="text-dark text-uppercase">Rooms</span></h2>
				<div class="h-line bg-success mb-4"></div>
			</div>

			<div class="col-lg-12 text-end mt-3 mb-3">
				<a href="rooms.php" class="text-success fw-bold shadow-none">More Rooms ></a>
			</div>
			<div class="row g-4">

				<?php
				$room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `room_id` ASC LIMIT 3", [1, 0], 'ii');

				while ($room_data = mysqli_fetch_assoc($room_res)) {

					//GET FEATURES OF ROOM

					$fea_q = mysqli_query($con, "SELECT f.name FROM `features` f 
                            INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
                            WHERE rfea.room_id = '$room_data[room_id]'");

					$features_data = "";
					while ($fea_row = mysqli_fetch_assoc($fea_q)) {
						$features_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
                                    $fea_row[name]                            
                                </span>";
					}


					// get facilities of room

					$fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                            INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
                            WHERE rfac.room_id = '$room_data[room_id]'");

					$facilities_data = "";

					while ($fac_row = mysqli_fetch_assoc($fac_q)) {
						$facilities_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
                                    $fac_row[name]                            
                                </span>";
					}

					//get thumbnail photo

					$room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
					$thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                            WHERE `room_id`='$room_data[room_id]' 
                            AND `thumb`='1'");

					if (mysqli_num_rows($thumb_q) > 0) {
						$thumb_res = mysqli_fetch_assoc($thumb_q);
						$room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
					}

					$book_btn = "";
					if (!$title_r['shutdown']) {
						$login = 0;
						if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
							$login = 1;
						}
						$book_btn = "<button onclick='checkLoginToBook1($login,$room_data[room_id])' class='btn btn-sm w-100 btn-success rounded shadow-none py-2 px-4 mb-1' data-bs-toggle='modal1' data-bs-target='#loginModal'>Book Now </button>";
					}


					$rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review`
								WHERE `room_id`='$room_data[room_id]' ORDER BY `rating_id` DESC LIMIT 20";

					$rating_res = mysqli_query($con, $rating_q);
					$rating_fetch = mysqli_fetch_assoc($rating_res);

					$rating_data = "";

					if ($rating_fetch['avg_rating'] != Null) {
						$rating_data = "<div class='ps-2'>";

						for ($i = 0; $i < $rating_fetch['avg_rating']; $i++) {
							// 			$rating_data .= "<small class='fa fa-star text-success'></small>";
						}

						$rating_data .= "</div>";
					}

					$nothing = '';
					//print room card

					echo <<<room
						<div class="col-lg-4 col-md-6 wow fadeInUp" data-aos="zoom-in" data-aos-duration="2000" data-aos-once="true">
							<div class="room-item shadow rounded overflow-hidden">
								<div class="position-relative">
									<img class="img-fluid" src="$room_thumb" alt="">
									<small class="position-absolute start-0 top-100 translate-middle-y bg-success text-white rounded py-1 px-3 ms-4">₱ $room_data[price]/Night</small>
								</div>
								<div class="p-4 mt-2">
									<div class="d-flex justify-content-between mb-3">
										<h5 class="mb-0">$room_data[type]</h5>
										$rating_data
									</div>
								
									<h6 class="mb-1">Capacity</h6>
										
									<div class="d-flex mb-3">
									<li style='display: inline;'>•
											$room_data[adult] Capacity &nbsp;                        
										</li>
										<li style='display: inline;' hidden>•
											$room_data[children] Children                           
										</li>
									</div>
									
									<div class="text-center">
										$book_btn
										<a class="btn btn-sm w-100 btn-outline-success shadow-none rounded py-2 px-4" href="room_details.php?room_id=$room_data[room_id]">More Details</a>
									</div>
								</div>
							</div>
						</div>
					room;
				}
				?>
			</div>
		</div>

		<!-- Javascript for Book Now Facility para pumunta sa confirm_bookingfacility -->
		<script>
			function checkLoginToBook1(isLoggedIn, roomId) {
				if (isLoggedIn) {
					// Redirect to confirm_booking.php with room_id parameter
					window.location.href = 'confirm_booking.php?room_id=' + roomId;
				} else {
					// Show login modal if not logged in
					$('#loginModal').modal('show');
				}
			}
		</script>

		<!-- End of Javascript for Book Now Facility para pumunta sa confirm_bookingfacility -->




	</div>
	<!-- Room End -->


	<!-- roadmap -->
	<div class="container">
		<div class="text-center">
			<h2 class="mb-3">How to make a <span class="text-dark text-uppercase">Reservation</span></h2> <!-- change to black -->
			<div class="h-line bg-success mb-4"></div>
		</div>
		<img src="img/roadmap.png" alt="roadmap picture" class="img-fluid mb-3" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
	</div>

	<!-- end of roadmap -->

	<!-- Room Start -->
	<div class="container-xxl py-5">
		<div class="container">
			<div class="text-center wow fadeInUp" data-wow-delay="0.1s">
				<h6 class="section-title text-center text-success text-uppercase">The Facilities</h6>
				<h2 class="mb-3">Explore Our <span class="text-dark text-uppercase">Facilities</span></h2> <!-- change to black -->
				<div class="h-line bg-success mb-4"></div>
			</div>

			<div class="col-lg-12 text-end mt-3 mb-3">
				<!-- 	<a href="facility.php" class="text-success fw-bold shadow-none">More Facilities ></a>--> <!-- Remove More Facilities>> -->
			</div>
			<div class="row g-4 d-flex justify-content-center">

				<?php
				$room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? AND `type`='Banquet Hall' OR `type`='Function Hall' ORDER BY `room_id` ASC LIMIT 3", [1, 0], 'ii');

				while ($room_data = mysqli_fetch_assoc($room_res)) {

					//GET FEATURES OF ROOM

					$fea_q = mysqli_query($con, "SELECT f.name FROM `features` f 
							INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
							WHERE rfea.room_id = '$room_data[room_id]'");

					$features_data = "";
					while ($fea_row = mysqli_fetch_assoc($fea_q)) {
						$features_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
									$fea_row[name]                            
								</span>";
					}


					// get facilities of room

					$fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
							INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
							WHERE rfac.room_id = '$room_data[room_id]'");

					$facilities_data = "";

					while ($fac_row = mysqli_fetch_assoc($fac_q)) {
						$facilities_data .= "<span class='badge rounded-pill bg-success text-light text-wrap  me-1 mb-1'>
									$fac_row[name]                            
								</span>";
					}

					//get thumbnail photo

					$room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
					$thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
							WHERE `room_id`='$room_data[room_id]' 
							AND `thumb`='1'");

					if (mysqli_num_rows($thumb_q) > 0) {
						$thumb_res = mysqli_fetch_assoc($thumb_q);
						$room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
					}

					$book_btn = "";
					if (!$title_r['shutdown']) {
						$login = 0;
						if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
							$login = 1;
						}
						//START OF UPDATE

						//$book_btn = "<button onclick='checkLoginToBook2($login,$room_data[room_id])' class='btn btn-sm w-100 btn-success rounded shadow-none py-2 px-4 mb-1' data-bs-toggle='modal1' data-bs-target='#loginModal'>Book Now </button>";

						//END OF UPDATE					
					}


					$rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review`
								WHERE `room_id`='$room_data[room_id]' ORDER BY `rating_id` DESC LIMIT 20";

					$rating_res = mysqli_query($con, $rating_q);
					$rating_fetch = mysqli_fetch_assoc($rating_res);

					$rating_data = "";

					if ($rating_fetch['avg_rating'] != Null) {
						$rating_data = "<div class='ps-2'>";

						for ($i = 0; $i < $rating_fetch['avg_rating']; $i++) {
							$rating_data .= "<small class='fa fa-star text-success'></small>";
						}

						$rating_data .= "</div>";
					}

					//print room card

					echo <<<room
						<div class="col-lg-4 col-md-6 wow fadeInUp" data-aos="zoom-in" data-aos-duration="1000" data-aos-once="true">
							<div class="room-item shadow rounded overflow-hidden">
								<div class="position-relative">
									<img class="img-fluid" src="$room_thumb" alt="">
									<small class="position-absolute start-0 top-100 translate-middle-y bg-success text-white rounded py-1 px-3 ms-4">₱ $room_data[price]/Night</small>
								</div>
								<div class="p-4 mt-2">
									<div class="d-flex justify-content-between mb-3">
										<h5 class="mb-0">$room_data[type]</h5>
										$rating_data
									</div>
								
									<h6 class="mb-1">Capacity</h6>
										
									<div class="d-flex mb-3">
									<li style='display: inline;'>• 
											$room_data[adult] Capacity  &nbsp;                       
										</li>
										<li style='display: inline;' hidden>•  
											$room_data[children] Children                            
										</li>
									</div>
									
									<div class="text-center">
										$book_btn
										<!-- START OF UPDATE -->	<a class="btn btn-sm w-100 btn-outline-success shadow-none rounded py-2 px-4" href="facility.php">More Details</a>    <!-- END OF UPDATE -->
										</div>
								</div>
							</div>
						</div>
					room;
				}
				?>
			</div>
		</div>

		<!-- Javascript for Book Now Facility para pumunta sa confirm_bookingfacility -->
		<script>
			function checkLoginToBook2(isLoggedIn, roomId) {
				if (isLoggedIn) {
					// Redirect to confirm_booking.php with room_id parameter
					window.location.href = 'confirm_facility.php?room_id=' + roomId;
				} else {
					// Show login modal if not logged in
					$('#loginModal').modal('show');
				}
			}
		</script>

		<!-- End of Javascript for Book Now Facility para pumunta sa confirm_bookingfacility -->
	</div>
	<!-- Room End -->


	<!-- Start of Amenities -->
	<div class="our-services">
		<div class="container">
			<h6 class="section-title text-center text-success text-uppercase">The Services</h6>
			<div class="text-center">
				<h2 class="section-title text-center">Our <span class="text-dark text-uppercase">Services</span></h2>
				<div class="h-line bg-success mb-4">
				</div>
			</div>
			<br> <!-- update para maaadjust yung spacing >>  -->



			<!-- Start ng update para matanggal yung More Services >>  -->

			<!-- Amenities More Services <div class="col-lg-12 text-end mt-3 mb-3">
												<a href="Amenities.php" class="text-success fw-bold shadow-none text-decoration-underline">More Services ></a>
											</div> -->

			<!-- End ng update para matanggal yung More Services >>  -->



			<!-- Start ng update para maging clickable si Image to Amenities.php >>  -->

			<div class="container">
				<div class="row">

					<div class="col-lg-4 col-md-6 mb-4 px-4">
						<a href="Amenities.php">
							<div class="bg-white rounded shadow p-2 border-success border-top border-4 text-center box" data-aos="slide-up" data-aos-duration="1000" data-aos-once="true">
								<img src="img/services/gym1.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
								<div class="details">
									<p>GYM</p>
									<p2>
										A gym is a place where people go to train and <br>exercise, but also to unwind, socialize, and <br> recharge.
										It is a facility that promotes physical <br>activity, provides a safe, functional, and <br> comfortable workout environment.
									</p2>
								</div>
							</div>
						</a>
					</div>


					<div class="col-lg-4 col-md-6 mb-4 px-4">
						<div class="bg-white rounded shadow p-2 border-success border-top border-4 text-center box" data-aos="slide-up" data-aos-duration="1500" data-aos-once="true">
							<a href="Amenities.php">
								<img src="img/services/parking1.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
								<div class="details">
									<p>PARKING</p>
									<p2 class="mb-0">
										a location that is designated for parking, either <br>paved or unpaved.
										It can be in a parking garage,<br> in a parking lot or on a city street.
										The space <br>may be delineated by road surface markings.
									</p2>
								</div>
						</div>
						</a>
					</div>


					<div class="col-lg-4 col-md-6 mb-4 px-4">
						<div class="bg-white rounded shadow p-2 border-success border-top border-4 text-center box" data-aos="slide-up" data-aos-duration="2000" data-aos-once="true">
							<a href="Amenities.php">
								<img src="img/services/spa.jpg" alt="Gym Image" class="img-fluid" alt="Responsive Image" width="500">
								<div class="details">
									<p>SPA</p>
									<p2>
										A spa is a fancy hotel or resort, especially one <br> that offers health and beauty treatments or <br> is located near a natural mineral spring.
									</p2>
								</div>
						</div>
						</a>
					</div>



					<!-- End ng update para maging clickable si Image to Amenities.php >>  -->


				</div>
			</div>
		</div>
	</div>
	</div>
	</div>

	<!-- End of Amenities -->





	<!-- comments End -->

	<!-- Paasword Reset Modal -->

	<div class="modal fade" id="recoveryModal" tabindex="-1" aria-labelledby="recoveryModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form id="recovery-form">
					<div class="modal-header">
						<h5 class="modal-title d-flex align-items-center">
							<i class="bi bi-shield-lock me-2"></i> Set-up New Password
						</h5>
						<button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">

						<div class="mb-3">
							<label class="form-label">New Password</label>
							<input type="password" name="pass" class="form-control shadow-none" required>
						</div>
						<input type="hidden" name="email">
						<input type="hidden" name="token">

						<div class="d-flex align-items-center justify-content-between mb-2">
							<button type="button" class="btn shadow-none" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-success shadow-none">Submit</button>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
	<!------ End Modal for password reset modal ---->






	<!-- Footer -->
	<script src="jquery/jquery-3.5.1.min.js"></script>
	<script src="css/swiper/swiper-bundle.min.js"></script>
	<script src="css/bootstrap/bootstrap.js"></script>
	<?php require('include/footer.php'); ?>
	<!-- Footer End -->


	<?php
	date_default_timezone_set("Asia/Manila");
	if (isset($_GET['account_recovery'])) {
		$data = filteration($_GET);

		$t_date = date("Y-m-d");

		$query = select("SELECT * FROM `guests_users` WHERE `email`=? AND `token`=? LIMIT 1", [$data['email'], $data['token']], 'ss');

		if (mysqli_num_rows($query) == 1) {
			echo <<<showModal
					<script>
						var myModal = document.getElementById('recoveryModal');

						myModal.querySelector("input[name='email']").value = '$data[email]';
						myModal.querySelector("input[name='token']").value = '$data[token]';

						var modal = bootstrap.Modal.getOrCreateInstance(myModal);
						modal.show();
					</script>
				showModal;
		} else {
			alert("error", "Invalid or Expired Link!");
		}
	}

	?>



	<!---- carousel javascript ----->
	<script>
		var swiper = new Swiper(".swiper-container", {
			spaceBetween: 30,
			effect: "fade",
			loop: true,
			autoplay: {
				delay: 3500,
				disableOnInteraction: false,
			}
		});


		const today = new Date().toISOString().split('T')[0];
		// document.getElementById("checkout").setAttribute("max", today);
		// document.getElementById("checkin").setAttribute("max", today);


		//recover account

		let recovery_form = document.getElementById('recovery-form');

		recovery_form.addEventListener('submit', (e) => {
			e.preventDefault();

			let data = new FormData();

			data.append('pass', recovery_form.elements['pass'].value);
			data.append('email', recovery_form.elements['email'].value);
			data.append('token', recovery_form.elements['token'].value);
			data.append('recover_user', '');


			var myModal = document.getElementById('recoveryModal');
			//var modal = bootstrap.Modal.getOrCreateInstance(myModal);
			var modal = bootstrap.Modal.getInstance(myModal);
			modal.hide();

			//para maload ung query sa ajax/features_facilities.php Sending data to
			let xhr = new XMLHttpRequest();
			xhr.open("POST", "ajax/login_register.php", true);


			//para maload ung laman nung sa database
			xhr.onload = function() {
				if (this.responseText == 'failed') {
					alert('error', "Account Reset Failed!");
				} else {
					window.location.href = "index.php"; // Use window.location.href to set the new URL
					alert('success', "Account Reset Successful, Please Login");
					forgot_form.reset();
				}

			}
			xhr.send(data);
		});
	</script>

	<!-- Initialize Swiper -->
	<script>
		var swiper = new Swiper(".swiper-comments", {
			effect: "coverflow",
			grabCursor: true,
			centeredSlides: true,
			slidesPerView: "auto",
			slidesPerView: "3",
			loop: true,
			coverflowEffect: {
				rotate: 50,
				stretch: 0,
				depth: 100,
				modifier: 1,
				slideShadows: false,
			},
			pagination: {
				el: ".swiper-pagination",
			},
			breakpoints: {
				320: {
					slidesPerView: 1,
				},
				640: {
					slidesPerView: 1,
				},
				768: {
					slidesPerView: 2,
				},
				1024: {
					slidesPerView: 3,
				},
			}
		});
	</script>

	<script src="css/animation/aos.js"></script>
	<script>
		AOS.init({
			duration: 3000,
			once: true,
		});
	</script>
</body>

</html>