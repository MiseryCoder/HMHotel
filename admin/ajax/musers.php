<?php

require('../include/conn.php');
require('../include/essentials.php');

mngmtLogin();

if (isset($_POST['get_users'])) {
    $res = selectAll('management_users');
    $i = 1;
    $path = USERS_IMG_PATH;


    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn = "<button type='button' onclick='remove_user($row[m_id])' class='btn btn-danger shadow-none'>
                <i class='bi bi-trash'></i> 
            </button>";
        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

        if($row['verified']){
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            //ibalik pag meron na otp or email verification
            // $del_btn = "";

        }

        $status = "<button onclick='toggle_status($row[m_id],0)' class='btn btn-success btn-sm shadow-none'>Approved</button>";

        if(!$row['approved']){
            $status = "<button onclick='toggle_status($row[m_id],1)' class='btn btn-warning btn-sm shadow-none'>No Access</button>";

        }

        $date = date("d-m-Y",strtotime($row['datentime']));

        $data .= "
            <tr>
                <td>$i</td>
                <td>
                    $row[m_name]
                </td>
                <td>$row[m_type]</td>
                <td>$row[m_email]</td>
                <td>$row[m_phone]</td>
                <td>$row[m_address]</td>
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

    $sql = "UPDATE `management_users` SET `approved`=? WHERE `m_id`=?";
    $value = [$frm_data['value'], $frm_data['toggle_status']];

    if (update($sql, $value, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}

if(isset($_POST['remove_user'])){
    $frm_data = filteration($_POST);

    $res = delete("DELETE FROM `management_users` WHERE `m_id`=?",[$frm_data['id']],'i');

    if($res){
        echo 1;
    } else{
        echo 0;
    }

}


if (isset($_POST['search_user'])) {
    $frm_data = filteration($_POST);
    $query = "SELECT * FROM `management_users` WHERE `m_name` LIKE ?";
    $res = select($query,["%$frm_data[name]%"],'s');
    $i = 1;

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found!</b>";
        exit;
    }

    $path = USERS_IMG_PATH;


    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn = "<button type='button' onclick='remove_user($row[m_id])' class='btn btn-danger shadow-none'>
                <i class='bi bi-trash'></i> 
            </button>";
        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

        if($row['verified']){
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            //ibalik pag meron na otp or email verification
            

        }

        $status = "<button onclick='toggle_status($row[m_id],0)' class='btn btn-success btn-sm shadow-none'>Approved</button>";

        if(!$row['approved']){
            $status = "<button onclick='toggle_status($row[m_id],1)' class='btn btn-warning btn-sm shadow-none'>No Access</button>";

        }

        $date = date("d-m-Y",strtotime($row['datentime']));

        $data .= "
            <tr>
                <td>$i</td>
                <td>
                    $row[m_name]
                </td>
                <td>$row[m_email]</td>
                <td>$row[m_type]</td>
                <td>$row[m_phone]</td>
                <td>$row[m_address]</td>
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
