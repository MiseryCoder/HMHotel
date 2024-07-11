<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

//default path, baguhin nlanag pag naglive server na :>
define('SITE_URL','http://localhost/hmhotel/');
define('SITE_URL_ADMIN','http://localhost/hmhotel/admin');
// define('SITE_URL','http://www.hmhotel.net/');
// define('SITE_URL_ADMIN','http://www.hmhotel.net/admin');


//front end data, ung path to nung mga images
define('ABOUT_IMG_PATH',SITE_URL.'img/about/');
define('CAROUSEL_IMG_PATH',SITE_URL.'img/carousel/');
define('FACILITIES_IMG_PATH',SITE_URL.'img/facilities/');
define('ROOMS_IMG_PATH',SITE_URL.'img/rooms/');
define('USERS_IMG_PATH',SITE_URL.'img/users/');

//backend upload need tong data, path din pero para sa management side
define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].SITE_URL.'img/'); //ito yung error sa picture na nadebug na //
define('ABOUT_FOLDER','about/');
define('CAROUSEL_FOLDER','carousel/');
define('FACILITIES_FOLDER','facilities/');
define('ROOMS_FOLDER','rooms/');
define('USERS_FOLDER','users/');
define('PROOF_FOLDER','users/proof');

//paypal config
define('CLIENT_ID', ''); // put the API HERE
define('CLIENT_SECRET', ''); // put the API HERE

define('PAYPAL_RETURN_URL', SITE_URL.'paypalSuccess.php');
define('PAYPAL_CANCEL_URL', SITE_URL.'paypalCancel.php');
define('PAYPAL_CURRENCY', 'PHP'); // set your currency here

//sendgrid api key
define('SENDGRID_API_KEY',""); // put the API HERE


//sa SESSION login
function mngmtLogin(){
    session_start();
    if(!(isset($_SESSION['mngmtLogin']) && $_SESSION['mngmtLogin']==true)){
        echo "<script>
            window.location.href='index.php';
        </script>
        ";
        exit;
    }
}







// pangredirect sa ibang pages
function redirect($url){
    echo"<script>
        window.location.href='$url';
    </script>
    ";
    exit;
}

//alert box
function alert($type,$msg){
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

    echo <<<alert
    <div class="alert $bs_class alert-dismissible fadeOut fade show custom-alert ml-auto position-fixed top-0 end-0" role="alert" style="z-index: 111111;">
        <strong class="me-3">$msg</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    alert;
}


// pangredirect sa pag-upload for images
function uploadImage($image,$folder){
    $valid_mime = ['image/jpeg','image/png','image/webp'];
    $img_mime = $image['type'];

    if(!in_array($img_mime,$valid_mime)){
        return 'inv_img'; //invalid image format
    } 
    else if($image['size']/(4048*4048)>8){
        return 'inv_size'; // invalid size
    } 
    else{
        $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
        $rname = 'IMG_'.random_int(11111,99999).".$ext";

        $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
        if(move_uploaded_file($image['tmp_name'],$img_path)){
            return $rname;
        } else{
            return 'upd_failed';
        }
    }
}

// pangdelete sa pag-upload for images and folder content
function deleteImage($image, $folder){
    if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
        return true;
    }
    else{
        return false;
    }
}


// pangredirect sa pag-upload for SVG images
function uploadSVGImage($image,$folder){
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if(!in_array($img_mime,$valid_mime)){
        return 'inv_img'; //invalid image format
    } 
    else if($image['size']/(1024*1024)>1){
        return 'inv_size'; // invalid size greater than 1MB!
    } 
    else{
        $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
        $rname = 'IMG_'.random_int(11111,99999).".$ext";

        $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
        if(move_uploaded_file($image['tmp_name'],$img_path)){
            return $rname;
        } else{
            return 'upd_failed';
        }
    }
}

function uploadUserImage($image){
    $valid_mime = ['image/jpeg','image/png','image/webp'];
    $img_mime = $image['type'];

    if(!in_array($img_mime,$valid_mime)){
        return 'inv_img'; //invalid image format
    } 
    else{
        $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
        $rname = 'IMG_'.random_int(11111,99999).".jpeg";

        $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

        if($ext == 'png' || $ext == 'PNG'){
            $img = imagecreatefrompng($image['tmp_name']);
        } else if($ext == 'webp' || $ext == 'WEBP'){
            $img = imagecreatefromwebp($image['tmp_name']);
        } else{
            $img = imagecreatefromjpeg($image['tmp_name']);
        }

        if(imagejpeg($img,$img_path,75)){
            return $rname;
        } else{
            return 'upd_failed';
        }
    }
}


function uploadUserProof($image) {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img'; // invalid image format
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . "." . $ext;

        $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}







?>
