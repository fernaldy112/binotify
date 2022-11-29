<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/header.php");
require_once(__DIR__."/../src/components/navbar.php");

$xml = file_get_contents("http://rest/artistList");
echo($xml);

if (!isset($STORE) || !isset($NAVBAR) || !isset($HEADER)) {
    http_response_code(500);
    return;
}

$header = html("components/shared/header.html");
$result = template("components/search/result.html")->bind(["query" => $query]);
$noResult = template("components/search/no-result.html")->bind(["query" => $query]);
$main = template("components/search/main.html")->bind([
    "search_result" => $hasResult ? $result : $noResult,
    "header" => $HEADER
]);

css("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap");
css("css/styles.css");
css("css/shared.css");
css("css/search.css");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
js("js/table.js");
js("js/search.js");
js("js/util.js");
js("js/searchbar.js");
js("js/auth.js");

template("components/premiumsinger.html")->bind([
    "query" => $query,
    "navbar" => $NAVBAR,
    "main" => $main,
    "json_result" => json_encode($res),
    "genres" => json_encode($genres),
    "page" => $page
])->render();
