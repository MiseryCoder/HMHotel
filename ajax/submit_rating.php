<?php

require('../admin/include/conn.php');
require('../admin/include/essentials.php');

if (isset($_POST["rating_data"])) {
    $user_name = $con->real_escape_string($_POST["user_name"]);
    $rating_data = (int)$_POST["rating_data"];
    $user_review = $con->real_escape_string($_POST["user_review"]);
    $datetime = time();

    $query = "
    INSERT INTO rating_review 
    (user_id, rating, review, datentime) 
    VALUES ('$user_name', $rating_data, '$user_review', '$datetime')
    ";

    if ($con->query($query) === TRUE) {
        echo "Your Review & Rating Successfully Submitted";
    } else {
        echo "Error: " . $query . "<br>" . $con->error;
    }
}

if (isset($_POST["action"]) && $_POST["action"] === 'load_data') {
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
    $room_id = (int)$_POST["room_id"];

    // Query to retrieve review data
    $query = "
    SELECT rr.*,uc.name AS uname,uc.idpic, r.type AS rname FROM `rating_review` rr 
                        INNER JOIN `guests_users` uc ON rr.user_id = uc.id
                        INNER JOIN `rooms` r ON rr.room_id = r.room_id
                        WHERE rr.room_id = $room_id AND `seen` = 1
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
        'review_data' => $review_content
    );

    echo json_encode($output);
}
?>
