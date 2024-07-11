<?php
require('sentiment/vendor/autoload.php');
require('../admin/include/conn.php');
require('../admin/include/essentials.php');

use Sentiment\Analyzer;

// Function to store the comment in the database
function storeComment($comment, $sentiment)
{
    
    require('../admin/include/conn.php');
    require('../admin/include/essentials.php');

    // Insert the comment into the database
    $sql = "INSERT INTO rating_review (review, sentiment) VALUES ('$comment', '$sentiment')";
    if ($con->query($sql) === TRUE) {
        echo "Thank you for your feedback!";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Close the database connection
    $con->close();
}

$obj = new Analyzer();

$result = '';

if (isset($_POST['submit'])) {


    // Update lexicon dynamically with new words
    $tagalogWords = [
        'maganda' => '1.0', // positive
        'magaling' => '1.0',
        'mabuti' => '1.0',
        'mabait' => '1.0',
        'maayos' => '1.0',
        'kahanga-hanga' => '1.0',
        'gusto' => '1.0',
        'galing' => '1.0',
        'kaaya-aya' => '1.0',
        'nakakatuwa' => '1.5',
        'mahusay' => '1.5',
        'matino' => '1.0',
        'gagi' => '-1.0',  // negative
        'wala' => '-1.5',
        'puta' => '-1.5',
        'pota' => '-1.5',
        'taena' => '-1.5',
        'tang ina' => '-1.5',
        'bobo' => '-1.5',
        'shuta' => '-1.5',
        'gago' => '-1.5',
        'gagu' => '-1.5',
        'hindi' => '-1.5',  // negative
        'tanga' => '-1.5',
        'nakakainis' => '-1.5',
        'kainis' => '-1.5',
        'magulo' => '-1.0',
        'gulo' => '-1.0',
        'mabagal' => '-1.0',  // negative
        'matagal' => '-1.0',
        'mababa' => '-1.0',  // negative
        'panget' => '-1.0',  // negative
        'pangit' => '-1.0',  // negative
        'sira' => '-1.0',
        'sagwa' => '-1.0',
        'kulang'=> '-1.0',
        'masagwa' => '-1.0',
        'tamad' => '-1.0',
        'umay' => '-0.5',
        'korni' => '-0.5',
        'pwede' => '0.0',  //neutral
        'okay' => '0.0',
        'oks' => '0.0',
        'sakto' => '0.0',
        'saks' => '0.0',
        'lang' => '0.0',
        'medyo' => '0.0',
        'medjo' => '0.0',
        'depende' => '0.0',
        'parang' => '0.0',

        

        // Add more new words as needed
    ];
    $obj->updateLexicon($tagalogWords);


    $text = $_POST['text'];
    $result = $obj->getSentiment($text);

    // Check sentiment and store in the database
    if ($result['compound'] <= -0.05) {
        storeComment($text, 'Negative');
    } elseif ($result['compound'] >= 0.05) {
        storeComment($text, 'Positive');
    } else {
        storeComment($text, 'Neutral');
    }
}
