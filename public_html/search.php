<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

$query = $_GET["q"];

if (!isset($STORE)) {
//    TODO: display 500
    return;
}

$musics = $STORE->getSongBySimilarName($query);
$hasResult = sizeof($musics) !== 0;

$header = html("components/shared/header.html");
$result = template("components/search/result.html")->bind(["query" => $query]);
$noResult = template("components/search/no-result.html")->bind(["query" => $query]);
$main = template("components/search/main.html")->bind([
    "search_result" => $hasResult ? $result : $noResult,
    "header" => $header
]);

template("components/search.html")->bind([
    "query" => $query,
    "navbar" => html("components/shared/navbar.html"),
    "main" => $main,
    "json_result" => json_encode($musics)
])->render();
