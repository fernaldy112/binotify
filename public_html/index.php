<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/navbar.php");

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
js("js/table.js");
js("js/auth.js");
js("js/searchbar.js");

template("components/index.html")->bind([
    "navbar" => $NAVBAR,
    "main" => $main
])->render();
