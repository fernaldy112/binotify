<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

$albumList = $STORE->getAllAlbum();

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

$header = html("components/shared/header.html");
$main = template("components/album_list/main.html")->bind([
    "header" => $header,
    "album_list" => make_table($albumList)
]);



template("components/album_list.html")->bind([
    "title"=> "Album List - Binotify",
    "navbar" => html("components/shared/navbar.html"),
    "main" => $main
])->render();
    
