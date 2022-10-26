<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

$id = $_GET["s"];
$album = $STORE->getAlbumById($id);
$songList = $STORE->getAllSongByAlbumId($id);
$tempUsername = "admin1";

function make_table ($songList) {
    $tbl_array = [];
    $tbl_array[] = "<div class=\"top_div\"><span class=\"span_row_num\">#</span><span class=\"span_title\">Title</span><span class=\"span_duration\">Duration</span></div>";
    $tbl_array[] = "<div class=\"header_div\"><p></div>";
    $tbl_array[] = "<br>";
    $tbl_array[] = "<table>";
    $num = 1;
    foreach ($songList as $song){
        $song_id = $song->getId();
        $title = $song->getTitle();
        $artist = $song->getArtist();
        $duration = $song->getDuration();
        $tbl_array[] = "<tr onclick=\"album_detail_ClickHandler($song_id)\">";
        $tbl_array[] = "<td class=\"row_num\">$num</td>";
        $tbl_array[] = "<td>$title • $artist</td>";
        $tbl_array[] = "<td class=\"song_duration\">$duration</td>";
        $tbl_array[] = "</tr>";
        $num++;
    }
    $tbl_array[] = "</table>";
    
    return implode('', $tbl_array);
}

$editButtonHolder = "";
$fileUpload = "";
if ($STORE->getIsAdminByUsername($tempUsername)){
    $editButtonHolder = "<button name='editAlbum' id='editButton'>Edit Album<i class='fa fa-external-link'></i></button>";
    $fileUpload = "<div id='fileUploadContainer'></div>";
}
$deleteButtonHolder = "";
if ($STORE->getIsAdminByUsername($tempUsername)){
    $deleteButtonHolder = "<button name='deleteAlbum' id='deleteButton'>Delete Album<i class='fa fa-external-link'></i></button>";
}


$header = html("components/shared/header.html");
$hero = template("components/album_detail/hero.html")->bind([
    "image" => $album->getImagePath(),
    "image_alt" => $album->getTitle(),
    "title" => $album->getTitle(),
    "editButton" => $editButtonHolder,
    "deleteButton" => $deleteButtonHolder,
    "artist" => $album->getArtist(),
    "date" => $album->getPublishDateString(),
    "duration" => $album->getTotalDurationString(),
    "genre" => $album->getGenre(),
    "fileUpload" => $fileUpload
]);

template("components/album_detail.html")->bind([
    "navbar" => html("components/shared/navbar.html"),
    "main" => template("components/album_detail/main.html")->bind([
        "header" => $header,
        "hero" => $hero,
        "song_list" =>make_table($songList)
    ]),
    
])->render();