<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

if (!isset($STORE)) {
    http_response_code(500);
    return;
}

$musics = $STORE->getRecentSongs();

$header = template("components/shared/header.html")->bind([
    "auth_controls" => template("components/shared/no-auth.html")->bind([])
]);
$cards = template("components/home/music-card.html")->bindEach($musics);

$main = template("components/home/main.html")->bind([
    "header" => $header,
    "cards" => $cards
]);

template("components/index.html")->bind([
    "navbar" => html("components/shared/navbar.html"),
    "main" => $main
])->render();
