<?php

require('../include/conn.php');
require('../include/essentials.php');

mngmtLogin();

if (isset($_POST['get_systemlogs'])) {

    $frm_data = filteration($_POST);

    $limit = 10;
    $page = $frm_data['page'];
    $start = ($page - 1) * $limit;

    $query = "SELECT COUNT(*) as total FROM systemlog";
    $total_result = mysqli_query($con, $query);
    $total_row = mysqli_fetch_assoc($total_result)['total'];

    $total_pages = ceil($total_row / $limit);

    $query = "SELECT * FROM systemlog ORDER BY date DESC LIMIT $start, $limit";
    $res = mysqli_query($con, $query);

    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found!</b>";
        exit;
    }

    while ($data = mysqli_fetch_assoc($res)) {
        $table_data .= "
            <tr>
                <td>$data[id]</td>
                <td>$data[date]</td>
                <td>$data[email]</td>
                <td>$data[name]</td>
                <td>$data[action]</td>
                <td>$data[user_type]</td>
            </tr>
        ";
    }

    $pagination = "";

    if ($total_pages > 1) {

        if ($page != 1) {
            $pagination .= "<li class='page-item'><button onclick='change_page(1)' class='page-link shadow-none'>First</button></li>";
        }

        $disabled = ($page == 1) ? "disabled" : "";
        $prev = $page - 1;

        $pagination .= "<li class='page-item $disabled'><button onclick='change_page($prev)' class='page-link shadow-none'>Prev</button></li>";

        for ($i = max(1, $page - 2); $i <= min($page + 2, $total_pages); $i++) {
            $active = ($i == $page) ? "active" : "";
            $pagination .= "<li class='page-item $active'><button onclick='change_page($i)' class='page-link shadow-none'>$i</button></li>";
        }

        $next = $page + 1;
        $disabled = ($page == $total_pages) ? "disabled" : "";
        $pagination .= "<li class='page-item $disabled'><button onclick='change_page($next)' class='page-link shadow-none'>Next</button></li>";

        if ($page != $total_pages) {
            $pagination .= "<li class='page-item'><button onclick='change_page($total_pages)' class='page-link shadow-none'>Last</button></li>";
        }
    }

    $output = json_encode(["table_data" => $table_data, "pagination" => $pagination]);

    echo $output;
}
?>
