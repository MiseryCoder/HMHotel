<?php
require('../include/conn.php');

if(isset($_POST['room_category_choice'])){
    $room_category_choice = $con->real_escape_string($_POST['room_category_choice']); // Retrieve room_category_choice

    if ($room_category_choice == 'GR') {
        $room = $con->query("SELECT * FROM `rooms` WHERE `room_ntype` = 'Room'");
    } else {
        $room = $con->query("SELECT * FROM `rooms` WHERE `room_ntype` = 'Facility'");
    }
    
    $room_type_options = '';
    foreach ($room->fetch_all(MYSQLI_ASSOC) as $row1) {
        $room_type_options .= "<option value='" . $row1['room_id'] . "'>" . $row1['type'] . "</option>";
    }
    
    echo $room_type_options;
}

if (isset($_POST['action'])) {
    // Initialize variables
    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;
    $review_content = array();
    $room_id = (int)$_POST['action'];

    // Query to retrieve review data
    $query = "
    SELECT rr.*,uc.name AS uname,uc.idpic, r.type AS rname FROM `rating_review` rr 
                        INNER JOIN `guests_users` uc ON rr.user_id = uc.id
                        INNER JOIN `rooms` r ON rr.room_id = r.room_id
                        WHERE rr.room_id = $room_id
                        ORDER BY `rating_id` DESC";

    $result = $con->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $review_content[] = array(
                'user_id' => $row["uname"],
                'review' => $row["review"],
                'rating' => $row["rating"],
                'datentime' => date('l jS, F Y h:i:s A', strtotime($row["datentime"]))
            );

            // Count ratings
            if ($row["rating"] == 5) {
                $five_star_review++;
            } elseif ($row["rating"] == 4) {
                $four_star_review++;
            } elseif ($row["rating"] == 3) {
                $three_star_review++;
            } elseif ($row["rating"] == 2) {
                $two_star_review++;
            } elseif ($row["rating"] == 1) {
                $one_star_review++;
            }

            // Update total review count and user rating
            $total_review++;
            $total_user_rating += $row["rating"];
        }

        // Calculate average rating
        $average_rating = $total_user_rating / $total_review;

        // Determine feedback based on average rating
        $feedback = '';
        if ($average_rating >= 4.5) {
            $feedback = 'Positive';
        } elseif ($average_rating >= 3 && $average_rating < 4.5) {
            $feedback = 'Neutral';
        } else {
            $feedback = 'Negative';
        }
    }

    // Prepare the output data
    $output = array(
        'average_rating' => number_format($average_rating, 1),
        'total_review' => $total_review,
        'five_star_review' => $five_star_review,
        'four_star_review' => $four_star_review,
        'three_star_review' => $three_star_review,
        'two_star_review' => $two_star_review,
        'one_star_review' => $one_star_review,
        'review_data' => $review_content,
        'feedback' => $feedback
    );

    echo json_encode($output);
}
?>
