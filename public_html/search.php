<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/header.php");
require_once(__DIR__."/../src/components/navbar.php");

if (!isset($STORE) || !isset($NAVBAR) || !isset($HEADER)) {
    http_response_code(500);
    return;
}
$query = $_GET["q"];
$genre = $_GET["g"] ?? false;
$page = $_GET["p"] ?? 1;
$sortBy = $_GET["s"] ?? null;
if ($sortBy !== null) {
    if ($sortBy != "year" || $sortBy != "title") {
        $sortBy = null;
    }
}
$order = $_GET["o"] ?? "asc";
if ($order !== null) {
    if ($order != "asc" && $order != "desc") {
        $order = "asc";
    }
}

$dataOnly = array_key_exists("d", $_GET) && $_GET["d"] === "1";

$res = $sortBy
    ? $STORE->getSongBySimilarName($query, $page)
    : $STORE->getSongBySimilarNameSorted($query, $page, $sortBy, $order);
$genres = $STORE->getSongGenres();

$hasResult = sizeof($res["data"]) !== 0;

if ($genre) {
    $newRes = ["data" => [], "hasNext" => $res["hasNext"]];
    foreach ($res["data"] as $song) {
        if ($song->getGenre() === $genre) {
            $newRes["data"][] = $song;
        }
    }
    $res = $newRes;
}

if ($dataOnly) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($res);
    return;
} else {
    $header = html("components/shared/header.html");
    $result = template("components/search/result.html")->bind(["query" => $query]);
    $noResult = template("components/search/no-result.html")->bind(["query" => $query]);
    $main = template("components/search/main.html")->bind([
        "search_result" => $hasResult ? $result : $noResult,
        "header" => $HEADER
    ]);

    css("css/styles.css");
    css("css/shared.css");
    css("css/search.css");
    css("https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
    css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
    js("js/table.js");
    js("js/search.js");
    js("js/util.js");
    js("js/searchbar.js");

    template("components/search.html")->bind([
        "query" => $query,
        "navbar" => $NAVBAR,
        "main" => $main,
        "json_result" => json_encode($res),
        "genres" => json_encode($genres),
        "page" => $page
    ])->render();
}
