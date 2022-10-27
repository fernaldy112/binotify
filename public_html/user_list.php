<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (array_key_exists("username", $_SESSION)) {
    $tempUsername = $_SESSION["username"];
    $isAdmin = $STORE->getIsAdminByUsername($tempUsername);
} else {
    $isAdmin = false;
}

if (!$isAdmin){
    header("Location: /");
    return;
}

$userList = $STORE->getAllUser();

function make_tabel($userList){
    $tbl_array = [];
    $tbl_array[] = "<table class=\"styled-table\">";
    $tbl_array[] = "<tr><th>Username</th><th>Email</th></tr>";
    foreach ($userList as $user){
        $tbl_array[] = "<tr>";
        $username = $user->getUsername();
        $email = $user->getEmail();
        $tbl_array[] = "<td>$username</td>";
        $tbl_array[] = "<td>$email</td>";
        $tbl_array[] = "</tr>";
    }
    $tbl_array[] = "</table>";
    
    return implode('', $tbl_array);
}

$header = html("components/shared/header.html");
$main = template("components/user_list/main.html")->bind([
    "header" => $header,
    "user_list" => make_tabel($userList)
]);

template("components/user_list.html")->bind([
    "title" => "See All User",
    "navbar" => html("components/shared/navbar.html"),
    "main" => $main
])->render();

