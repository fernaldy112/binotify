<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

if (!array_key_exists("q", $_GET)) {
    // TODO: redirect
}

$query = $_GET["q"];
$page = $_GET["p"] ?? 1;
$sortBy = $_GET["s"] ?? null;
if ($sortBy !== null) {
    if ($sortBy != "year" || $sortBy != "title") {
        $sortBy = null;
    }
}
$order = $_GET["o"] ?? "asc";
if ($order !== null) {
    if ($order != "asc" || $order != "desc") {
        $order = "asc";
    }
}

$dataOnly = array_key_exists("d", $_GET) && $_GET["d"] === 1;

if (!isset($STORE)) {
//    TODO: display 500
    return;
}

$musics = $sortBy
    ? $STORE->getSongBySimilarName($query, $page)
    : $STORE->getSongBySimilarNameSorted($query, $page, $sortBy, $order);
$hasResult = sizeof($musics) !== 0;

if ($dataOnly) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($musics);
    return;
}

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
    "json_result" => json_encode($musics),
    "page" => $page
])->render();
