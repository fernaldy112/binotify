<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

session_start();
if (!isset($STORE)) {
    http_response_code(500);
    return;
}

$musics = $STORE->getRecentSongs();

$authControls = array_key_exists("username", $_SESSION)
    ? template("components/shared/auth.html")->bind($_SESSION)
    : html("components/shared/no-auth.html");

$header = template("components/shared/header.html")->bind([
    "auth_controls" => $authControls
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
