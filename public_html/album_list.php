<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/header.php");
require_once(__DIR__."/../src/components/navbar.php");

if (!isset($STORE) || !isset($NAVBAR) || !isset($HEADER)) {
    http_response_code(500);
    return;
}

$albumList = $STORE->getAllAlbum();

if (isset($_GET["re"])){
    $x = $_GET["re"];
    header("Location: album_detail?s=$x");
}

function make_table ($albumList) {
    $tbl_array = [];
    // $tbl_array[] = "<table>";
    foreach ($albumList as $album){
        $album_id = $album->getId();
        $title = $album->getTitle();
        $artist = $album->getArtist();
        $tahun = $album->getPublishDate();
        $tahun= mb_substr($tahun, 0, 4);
        $image_path = $album->getImagePath();
        $genre = $album->getGenre();
        $tbl_array[]= "<div id=\"albumList_hero\" class=\"albumList_hero\" onclick=\"album_ClickHandler($album_id)\">";
        $tbl_array[]= "<img class=\"cover\" src=\"$image_path\" alt=\"Kosong\">";
        $tbl_array[]= "<div class=\"details\">";
        $tbl_array[]= "<h2 class=\"item\">Album</h2>";
        $tbl_array[]= "<h1 class=\"title\">$title</h1>";
        $tbl_array[]= "<span class=\"details-meta\">$artist</span>";
        $tbl_array[]= "<span class=\"details-meta\">$tahun • $genre</span>";
        $tbl_array[]= "</div>";
        $tbl_array[]= "</div>";
    }
    // $tbl_array[] = "</table>";
    
    return implode('', $tbl_array);

}

$main = template("components/album_list/main.html")->bind([
    "header" => $HEADER,
    "album_list" => make_table($albumList)
]);

css("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("http://fonts.cdnfonts.com/css/gotham");
css("css/styles.css");
css("css/shared.css");
css("css/album_list.css");
js_defer("js/album_list.js");

template("components/album_list.html")->bind([
    "title"=> "Album List - Binotify",
    "navbar" => $NAVBAR,
    "main" => $main
])->render();
    
