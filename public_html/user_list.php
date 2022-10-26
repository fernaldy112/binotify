<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

$userList = $STORE->getAllUser();

function make_tabel($userList){
    $tbl_array = [];
    $tbl_array[] = "<table class=\"styled-table\">";
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

template("components/user_list.html")->render(
    [
        "title"=> "See All User - Binotify",
        "user_list" => make_tabel($userList),
    ]
    );

