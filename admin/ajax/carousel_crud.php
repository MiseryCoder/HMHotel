<?php

require('../include/conn.php');
require('../include/essentials.php');

mngmtLogin();


//pag mag a-add ng member sa settings (Picture and name)
if(isset($_POST['add_image'])){

    $img_r = uploadImage($_FILES['picture'],CAROUSEL_FOLDER);

    if($img_r == 'inv_img'){
        echo $img_r;
    } else if($img_r == 'inv_size'){
        echo $img_r;
    } else if($img_r == 'upd_failed'){
        echo $img_r;
    } else{
        $query = "INSERT INTO `carousel`(`image`) VALUES (?)";
        $values = [$img_r];
        $res = insert($query,$values,'s');
        echo $res;
    }
}

//pang view ng mga laman ng database para sa team members
if(isset($_POST['get_carousel'])){
    $res = selectAll('carousel');

    while($row = mysqli_fetch_assoc($res)){
        $path = CAROUSEL_IMG_PATH;
        echo <<< data
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white">
                    <img src="$path$row[image]" class="card-img">
                    <div class="card-img-overlay text-end">
                        <button type="button" onclick="rem_image($row[carousel_id])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        data;
    }
}

if(isset($_POST['rem_image'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_image']];

    $pre_q = "SELECT * FROM `carousel` WHERE `carousel_id`=?";
    $res = select($pre_q,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['image'],CAROUSEL_FOLDER)){
        $query = "DELETE FROM `carousel` WHERE `carousel_id`=?";
        $res = delete($query,$values,'i');
        echo $res;
    }
    else{
        echo 0;
    }
}

?>
