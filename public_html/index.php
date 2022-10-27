<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/navbar.php");
require_once(__DIR__."/../src/components/header.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($STORE) || !isset($NAVBAR) || !isset($HEADER)) {
    http_response_code(500);
    return;
}

$musics = $STORE->getRecentSongs();
usort($musics, function ($music1, $music2) {
    return strcasecmp($music1["title"], $music2["title"]);
});

$cards = template("components/home/music-card.html")->bindEach($musics);

$main = template("components/home/main.html")->bind([
    "header" => $HEADER,
    "cards" => $cards
]);

css("css/styles.css");
css("css/shared.css");
css("css/search.css");
css("css/home.css");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
js("js/table.js");
js("js/auth.js");
js("js/searchbar.js");

template("components/index.html")->bind([
    "navbar" => $NAVBAR,
    "main" => $main
])->render();
