<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/header.php");
require_once(__DIR__."/../src/components/navbar.php");

// $data = file_get_contents("http://rest/artistList");
$data = '[{"user_id":1,"name":"exampleName"}]';
$artistList = json_decode($data);

if (!isset($STORE) || !isset($NAVBAR) || !isset($HEADER)) {
    http_response_code(500);
    return;
}

function makeTable($artistList){
    $tbl_array = [];
    $tbl_array[] = "<table class=\"styled-table\">";
    $tbl_array[] = "<tr><th>Artist ID</th><th>Artist Name</th></tr>";
    foreach ($artistList as $artist){
        $tbl_array[] = "<tr>";
        $tbl_array[] = "<td>$artist->user_id</td>";
        $tbl_array[] = "<td>$artist->name</td>";
        $tbl_array[] = "</tr>";
    }
    $tbl_array[] = "</table>";
    
    return implode('', $tbl_array);
}

$header = html("components/shared/header.html");
$main = template("components/premiumsinger/main.html")->bind([
    "header" => $HEADER,
    "user_list" => makeTable($artistList)
]);

css("css/user_list.css");
css("css/styles.css");
css("css/shared.css");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
js("js/auth.js");

template("components/premiumsinger.html")->bind([
    "title" => "Premium Artist List",
    "navbar" => $NAVBAR,
    "main" => $main
])->render();
