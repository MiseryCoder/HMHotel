<?php

//start session on web page

//config.php

//Include Google Client Library for PHP autoload file
require_once 'login_google/vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('67364271910-6pisl6jvr8a34mvlimelnrd90h45ue51.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://hmhotel.net/admin/index.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');


?>