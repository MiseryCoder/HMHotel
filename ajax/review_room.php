<?php
require('../admin/include/conn.php');
require('../admin/include/essentials.php');

date_default_timezone_set("Asia/Manila");
session_start();


require('sentiment/vendor/autoload.php');

use Sentiment\Analyzer;

error_reporting(E_ALL & ~E_DEPRECATED);

// Explicitly define properties in the Analyzer class to avoid dynamic creation
class CustomAnalyzer extends Analyzer
{
    protected $emoji_lexicon = [];
    protected $emojis = [];
}

$result = '';

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

if (isset($_POST['review_form'])) {
    $frm_data = filteration($_POST);

    // Create an instance of the CustomAnalyzer class
    $obj = new CustomAnalyzer();

    // Update lexicon dynamically with new words
    $obj->updateLexicon($tagalogWords);

    $text = $frm_data['review'];
    $result = $obj->getSentiment($text);

    // Check sentiment and store in the database
    if ($result['compound'] <= -0.05) {
        $sentiment = 'Negative';
    } elseif ($result['compound'] >= 0.05) {
        $sentiment = 'Positive';
    } else {
        $sentiment = 'Neutral';
    }

    $upd_query = "UPDATE `booking_order` SET `rate_review`=? WHERE `booking_id`=? AND `user_id`=?";

    $upd_values = [1, $frm_data['booking_id'], $_SESSION['uId']];

    $upd_result = update($upd_query, $upd_values, 'iii');

    $ins_query = "INSERT INTO `rating_review`(`booking_id`, `room_id`, `user_id`, `rating`, `review`, `sentiment`) VALUES (?,?,?,?,?,?)";

    //sentiment analysis
    $ins_values = [$frm_data['booking_id'], $frm_data['room_id'], $_SESSION['uId'], $frm_data['rating'], $text, $sentiment];

    $ins_result = insert($ins_query, $ins_values, 'iiiiss');

    echo $ins_result;
}
?>
