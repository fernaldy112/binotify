<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

// TODO: check if user is logged in or has listened to 3 albums

$id = $_GET["s"];
$album = $STORE->getAlbumById($id);

$header = html("components/shared/header.html");
$Album_Bar = template("components/albumList/Album_Bar.html")->bind([
    "image" => $album->getImagePath(),
    "image_alt" => $album->getTitle(),
    "title" => $album->getTitle(),
    "artist" => $album->getArtist(),
    "date" => $album->getPublishDateString(),
    "duration" => $album->getTotalDurationString(),
    "genre" => $album->getGenre(),
]);

template("components/Album_List.html")->bind([
    "navbar" => html("components/shared/navbar.html"),
    "main" => template("components/albumList/main.html")->bind([
        "header" => $header,
        "hero" => $hero,
    ]),
])->render();