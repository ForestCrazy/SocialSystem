<?php

session_start();

$connect = mysqli_connect("localhost", "root", "", "social_system");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
} else {
    mysqli_set_charset($connect, 'utf8');
}

function UserInfo($user_id) {
    global $connect;
    $sql_user = 'SELECT * FROM account WHERE user_id = "' . $user_id . '"';
    $res_user = mysqli_query($connect, $sql_user);
    return mysqli_fetch_assoc($res_user);
}