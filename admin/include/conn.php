<?php

date_default_timezone_set("Asia/Manila");


$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'hmhoteldb';

$con = mysqli_connect($hname, $uname, $pass, $db);

if (!$con) {
    die("Cannot Connect to Database" . mysqli_connect_error());
}

//filteration
function filteration($data)
{
    foreach ($data as $key => $value) {
        $data[$key] = trim($value);
        $data[$key] = stripcslashes($value);
        $data[$key] = htmlspecialchars($value);
        $data[$key] = strip_tags($value);
    }
    return $data;
}

//HINIWALAY KONA UNG MGA FUNCTION FOR SELECT,UPDATE,DELETE,CREATE PARA TAWAG TAWAG NALANG FUNCTION

//Select/View ng data
function select($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Select");
        }
    } else {
        die("Query cannot be Prepared - Select");
    }
}

//Update
function update($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Update");
        }
    } else {
        die("Query cannot be Prepared - Update");
    }
}

//Update
function insert($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Insert");
        }
    } else {
        die("Query cannot be Prepared - Insert");
    }
}

//table view
function selectAll($table)
{
    $con = $GLOBALS['con'];
    $res = mysqli_query($con, "SELECT * FROM $table");
    return $res;
}

//Delete
function delete($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Delete");
        }
    } else {
        die("Query cannot be Prepared - Delete");
    }
}



//for sentiment analysis
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
    'kulang' => '-1.0',
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
