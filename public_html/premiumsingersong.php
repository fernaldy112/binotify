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

if (!array_key_exists("username", $_SESSION)) {
    header("Location: /");
    return;
}

$singer_id = $_GET["artist"];
$user_id = $_SESSION["user_id"];
$data = file_get_contents("http://rest/songList/$user_id/$singer_id");
$restServiceIp = "localhost:8081";

$artistPremiumSongList = json_decode($data);

function make_tabel($artistPremiumSongList){
    global $restServiceIp;

    $tbl_array = [];
    $tbl_array[] = "<table class=\"styled-table\">";
    $tbl_array[] = "<tr><th>Judul</th><th>Action</th></tr>";
    foreach ($artistPremiumSongList as $song){
        $audioPath = "http://$restServiceIp/assets/".$song->audio_path;

        $tbl_array[] = "<tr>";
        $judul = $song->judul;
        $tbl_array[] = "<td>$judul</td>";
        $tbl_array[] = "<td>";
        $tbl_array[] = "<div class=\"bar\">";
        $tbl_array[] = "<button class=\"play-button\">";
        $tbl_array[] = "<span class=\"material-symbols-rounded icon\">";
        $tbl_array[] = "play_arrow";
        $tbl_array[] = "</span>";
        $tbl_array[] = "</button>";
        $tbl_array[] = "</div>";
        $tbl_array[] = "<audio hidden controls class=\"audio-playback\" src=\"$audioPath\" preload=\"auto\"></audio>";
        $tbl_array[] = "<td>";
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

$playBar = template("components/premium_song/play-bar.html")->bind([
    "title" => $song->judul,
]);

css("css/user_list.css");
css("css/styles.css");
css("css/listen.css");
css("css/shared.css");
css("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
js("js/auth.js");
js("js/util.js");
js("js/player.js");
js("js/listen.js");

template("components/premiumsingersong.html")->bind([
    "title" => "Premium Song",
    "navbar" => $NAVBAR,
    "main" => $main,
    "playBar" => $playBar,
])->render();