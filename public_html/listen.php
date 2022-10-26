<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

// DELETE
$tempUsername = "admin1";

// TODO: check if user is logged in or has listened to 3 songs

$id = $_GET["s"];
$hiddenInput = "<input type='hidden' name='songId' value=$id />";

if (!isset($STORE)) {
//    TODO: display 500
    return;
}

$song = $STORE->getSongById($id);

if ($song === null) {
//    TODO: display 404
    http_response_code(404);
    return;
}

$buttonHolder = "";
$fileUpload = "";
if ($STORE->getIsAdminByUsername($tempUsername)){
    $buttonHolder = "<button name='editSong' id='editButton'>Edit<i class='fa fa-external-link'></i></button>";
    $fileUpload = "<div id='fileUploadContainer'></div>";
}

$changeMessage = "";
if (isset($_GET["success"])){
    if ($_GET["success"] == 1){ // TODO
        $changeMessage = "<p id='editmsg'>Song is successfully edited.</p>"; // TODO: edit js
    } else {
        $changeMessage = "<p id='editmsg'>Audio or image format is wrong. Editing failed.</p>";
    }
}

$header = html("components/shared/header.html");
$hero = template("components/listen/hero.html")->bind([
    "image" => $song->getImagePath(),
    "image_alt" => $song->getTitle(),
    "title" => $song->getTitle(),
    "editButton" => $buttonHolder,
    "artist" => $song->getArtist(),
    "date" => $song->getPublishDateString(),
    "duration" => $song->getDurationString(),
    "genre" => $song->getGenre(),
    "album_name" => $song->getAlbumTitle(),
    "fileUpload" => $fileUpload,
    "hiddenInput" => $hiddenInput,
    "album_url" => "/album_detail?s=".$song->getAlbumId(),
    "changeMessage" => $changeMessage,
]);
$playBar = template("components/listen/play-bar.html")->bind([
    "cover" => $song->getImagePath(),
    "cover_alt" => $song->getTitle(),
    "title" => $song->getTitle(),
    "artist" => $song->getArtist(),
    "duration" => $song->getDurationString()
]);

template("components/listen.html")->bind([
    "song" => $song->getArtist()." - ".$song->getTitle(),
    "navbar" => html("components/shared/navbar.html"),
    "main" => template("components/listen/main.html")->bind([
        "header" => $header,
        "hero" => $hero,
    ]),
    "playBar" => $playBar,
    "source" => $song->getAudioPath()
])->render();
