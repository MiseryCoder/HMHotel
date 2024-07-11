<?php

require('admin/include/conn.php');


$title_r = "SELECT * FROM `about_details` WHERE `settings_ID`=?";

if($title_r['shutdown']){
    echo<<<alertbar
        <div class="bg-danger text-center p-2 fw-bold">
            Bookings are Temporarily closed!
        </div>
    alertbar;
}
?>