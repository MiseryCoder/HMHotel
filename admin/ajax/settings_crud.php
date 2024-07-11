<?php

require('../include/conn.php');
require('../include/essentials.php');

mngmtLogin();


//pangkuha to ng data sa database
if(isset($_POST['get_general'])){
    $query = "SELECT * FROM `about_details` WHERE `settings_ID`=?";
    $values = [1];
    $res = select($query,$values,"i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
}


//pangupdate ng data sa database
if(isset($_POST['upd_general'])){

    $frm_data = filteration($_POST);

    $query = "UPDATE `about_details` SET `site_title`=?, `site_about`=?,`site_mission`=?,`site_vision`=? WHERE `settings_ID`=?";
    $values = [$frm_data['site_title'], $frm_data['site_about'],$frm_data['site_mission'],$frm_data['site_vision'],1]; 
    $res = update($query,$values,"ssssi");
    echo $res;
}

//pangupdate ng shutdown mode sa database
if(isset($_POST['upd_shutdown'])){

    $frm_data = ($_POST['upd_shutdown']==0) ? 1 : 0;

    $query = "UPDATE `about_details` SET `shutdown`=? WHERE `settings_ID`=?";
    $values = [$frm_data,1]; 
    $res = update($query,$values,"ii");
    echo $res;
}

//pangupdate ng shutdown mode sa database
if(isset($_POST['upd_payment'])){

    $frm_data = ($_POST['upd_payment']==0) ? 1 : 0;

    $query = "UPDATE `about_details` SET `Online_payment`=? WHERE `settings_ID`=?";
    $values = [$frm_data,1]; 
    $res = update($query,$values,"ii");
    echo $res;
}


//pangkuha to ng data sa database
if(isset($_POST['get_contacts'])){
    $query = "SELECT * FROM `contact_details` WHERE `contact_ID`=?";
    $values = [1];
    $res = select($query,$values,"i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
}

//pangupdate ng data sa database
if(isset($_POST['upd_contacts'])){

    $frm_data = filteration($_POST);

    $query = "UPDATE `contact_details` SET `address`=?,`gmap`=?,`pn1`=?,`pn2`=?,`email`=?,`fb`=?,`instagram`=?,`twitter`=?,`iframe`=? WHERE `contact_ID`=?";
    $values = [$frm_data['address'], $frm_data['gmap'], $frm_data['pn1'], $frm_data['pn2'], $frm_data['email'], $frm_data['fb'], $frm_data['ig'], $frm_data['tw'], $frm_data['iframe'],1]; 
    $res = update($query,$values,"sssssssssi");
    echo $res;
}

//pag mag a-add ng member sa settings (Picture and name)
if(isset($_POST['add_member'])){
    $frm_data = filteration($_POST);

    $img_r = uploadImage($_FILES['picture'],ABOUT_FOLDER);

    if($img_r == 'inv_img'){
        echo $img_r;
    } else if($img_r == 'inv_size'){
        echo $img_r;
    } else if($img_r == 'upd_failed'){
        echo $img_r;
    } else{
        $query = "INSERT INTO `team_details`(`name`, `picture`) VALUES (?,?)";
        $values = [$frm_data['name'],$img_r];
        $res = insert($query,$values,'ss');
        echo $res;
    }
}

//pang view ng mga laman ng database para sa team members
if(isset($_POST['get_members'])){
    $res = selectAll('team_details');

    while($row = mysqli_fetch_assoc($res)){
        $path = ABOUT_IMG_PATH;
        echo <<< data
            <div class="col-md-2 mb-3">
                <div class="card bg-success text-white">
                    <img src="$path$row[picture]" class="card-img">
                    <div class="card-img-overlay text-end">
                        <button type="button" onclick="rem_member($row[team_id])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                    <p class="card-text text-center px-3 py-2">$row[name]</p>
                </div>
            </div>
        data;
    }
}

if(isset($_POST['rem_member'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_member']];

    $pre_q = "SELECT * FROM `team_details` WHERE `team_id`=?";
    $res = select($pre_q,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['picture'],ABOUT_FOLDER)){
        $query = "DELETE FROM `team_details` WHERE `team_id`=?";
        $res = delete($query,$values,'i');
        echo $res;
    }
    else{
        echo 0;
    }
}

?>
