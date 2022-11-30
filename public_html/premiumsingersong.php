<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/header.php");
require_once(__DIR__."/../src/components/navbar.php");

if (!isset($STORE) || !isset($NAVBAR) || !isset($HEADER)) {
    http_response_code(500);
    return;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (array_key_exists("username", $_SESSION)) {
    $tempUsername = $_SESSION["username"];
    $isAdmin = $STORE->getIsAdminByUsername($tempUsername);
} else {
    $isAdmin = false;
}

$id = $_GET["s"];
// $data = file_get_contents("http://rest/song");
$data = '[{"song_id":1,"judul":"exampleName", "penyanyi_id":1, "audio_path":"ada la tuh"}]';
$artistPremiumSongList = json_decode($data);



function make_tabel($artistPremiumSongList){
    $tbl_array = [];
    $tbl_array[] = "<table class=\"styled-table\">";
    $tbl_array[] = "<tr><th>Judul</th><th>Action</th></tr>";
    foreach ($artistPremiumSongList as $song){
        $tbl_array[] = "<tr>";
        $judul = $song->judul;
        // $playBar = template("components/listen/play-bar.html")->bind([
        //     "cover" => $song->getImagePath(),
        //     "cover_alt" => $song->getTitle(),
        //     "title" => $song->getTitle(),
        //     "artist" => $song->getArtist(),
        //     "duration" => $song->getDurationString()
        // ]);
        $tbl_array[] = "<td>$judul</td>";
        // $tbl_array[] = "<td>$playBar</td>";
        $tbl_array[] = "</tr>";
    }
    $tbl_array[] = "</table>";
    
    return implode('', $tbl_array);
}

$header = html("components/shared/header.html");
$main = template("components/user_list/main.html")->bind([
    "header" => $HEADER,
    "user_list" => make_tabel($artistPremiumSongList)
]);

css("css/user_list.css");
css("css/styles.css");
css("css/shared.css");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
js("js/auth.js");

template("components/user_list.html")->bind([
    "title" => "Premium Song",
    "navbar" => $NAVBAR,
    "main" => $main
])->render();