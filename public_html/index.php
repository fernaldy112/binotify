<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

$musics = $STORE->getRecentSongs();

foreach ($musics as $music) {
    $music["title"] = $music["judul"];
    $music["artist"] = $music["penyanyi"];

    // TODO: map model
}

$header = html("components/shared/header.html");
$cards = template("components/home/music-card.html")->bindEach([

]);

$main = template("components/home/main.html")->bind([
    "header" => $header,
    "cards" => $cards
]);

template("components/index.html")->bind([
    "navbar" => html("components/shared/navbar.html"),
    "main" => $main
])->render();