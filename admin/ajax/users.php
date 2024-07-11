<?php

require('../include/conn.php');
require('../include/essentials.php');

mngmtLogin();

if (isset($_POST['get_users'])) {
    $res = selectAll('guests_users');
    $i = 1;
    $path = USERS_IMG_PATH;


    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none'>
                <i class='bi bi-trash'></i> 
            </button>";
        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

        if($row['is_verified']){
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            //ibalik pag meron na otp or email verification
            // $del_btn = "";

        }

        $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-success btn-sm shadow-none'>active</button>";

        if(!$row['status']){
            $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>";

        }

        $date = date("d-m-Y",strtotime($row['datentime']));

        $data .= "
            <tr>
                <td>$i</td>
                <td>
                    $row[name]
                </td>
                <td>$row[email]</td>
                <td>$row[phonenum]</td>
                <td>$row[address]</td>
                <td>$verified</td>
                <td>$status</td>
                <td>$date</td>
                <td>$del_btn</td>
                
            </tr>
        ";
        $i++;
    }
    echo $data;
}

if (isset($_POST['toggle_status'])) {
    $frm_data = filteration($_POST);

    $sql = "UPDATE `guests_users` SET `status`=? WHERE `id`=?";
    $value = [$frm_data['value'], $frm_data['toggle_status']];

    if (update($sql, $value, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}


if(isset($_POST['remove_user'])){
    $frm_data = filteration($_POST);

    $res = delete("DELETE FROM `guests_users` WHERE `id`=?",[$frm_data['id']],'i');

    if($res){
        echo 1;
    } else{
        echo 0;
    }

}


if (isset($_POST['search_user'])) {

    $frm_data = filteration($_POST);
    $query = "SELECT * FROM `guests_users` WHERE `name` LIKE ?";
    $res = select($query,["%$frm_data[name]%"],'s');
    $i = 1;

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found!</b>";
        exit;
    }
    
    $path = USERS_IMG_PATH;


    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none'>
                <i class='bi bi-trash'></i> 
            </button>";
        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

        if($row['is_verified']){
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            //ibalik pag meron na otp or email verification
            

        }

        $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-success btn-sm shadow-none'>active</button>";

        if(!$row['status']){
            $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>";

        }

        $date = date("d-m-Y",strtotime($row['datentime']));

        $data .= "
            <tr>
                <td>$i</td>
                <td>
                    <img src='$path$row[idpic]' width='55px'>
                    <br>
                    $row[name]
                </td>
                <td>$row[email]</td>
                <td>$row[phonenum]</td>
                <td>$row[address]</td>
                <td>$verified</td>
                <td>$status</td>
                <td>$date</td>
                <td>$del_btn</td>
                
            </tr>
        ";
        $i++;
    }
    echo $data;
}

?>
