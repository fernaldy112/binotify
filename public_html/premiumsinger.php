<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/header.php");
require_once(__DIR__."/../src/components/navbar.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$data = file_get_contents("http://rest/artistList");
$artistList = json_decode($data);

if (!isset($STORE) || !isset($NAVBAR) || !isset($HEADER)) {
    http_response_code(500);
    return;
}

$subscription = $STORE->getSubscriptionById($_SESSION["user_id"]);

function makeTable($artistList){
    global $subscription;

    $tbl_array = [];
    $tbl_array[] = "<table class=\"styled-table\">";
    $tbl_array[] = "<tr><th>Artist ID</th><th>Artist Name</th></tr>";
    foreach ($artistList as $artist){

        $sub = array_filter($subscription, function ($subscription) use($artist) {
            return $subscription["creator_id"] == $artist->user_id;
        });
        $status = $sub ? array_values($sub)[0]["status"] : "REJECTED";

        $tbl_array[] = "<tr>";
        $tbl_array[] = "<td>$artist->user_id</td>";
        $tbl_array[] = "<td>$artist->name</td>";

        switch ($status) {
            // Can subscribe
            case "REJECTED":
                $tbl_array[] = "<td><button class='subscribeButton' artistID=$artist->user_id>Subscribe</button></td>";
                break;

            // Requested
            case "PENDING":
                $tbl_array[] = "<td>Requested</td>";
                break;
            
            // Subscribed
            case "ACCEPTED":
                $tbl_array[] = "<td><a href=\"/premiumsingersong?artist=$artist->user_id\">See musics</a></td>";
                break;
        }
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
css("css/subscribe.css");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
js("js/auth.js");
js("js/subscribe.js");

template("components/premiumsinger.html")->bind([
    "title" => "Premium Artist List",
    "navbar" => $NAVBAR,
    "main" => $main
])->render();
