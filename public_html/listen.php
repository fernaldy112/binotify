<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

use const Binotify\Store\STORE;

// TODO: check if user is logged in & has listened to 3 songs

$id = $_GET["s"];
$song = STORE->getSongById($id);

if ($song === null) {
//    TODO: display 404
}

$header = html("components/shared/header.html");
$hero = template("components/listen/hero.html")->bind([
    "image" => $song->getImagePath(),
    "image_alt" => $song->getTitle(),
    "title" => $song->getTitle(),
    "artist" => $song->getArtist(),
    "date" => $song->getPublishDateString(),
    "duration" => $song->getDurationString()
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
    "playBar" => $playBar
])->render();
