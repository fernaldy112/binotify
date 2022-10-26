<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

$id = $_GET["s"];
$album = $STORE->getAlbumById($id);
$songList = $STORE->getAllSongByAlbumId($id);

function make_table ($songList) {
    $tbl_array = [];
    $tbl_array[] = "<div class=\"top_div\"><span class=\"span_row_num\">#</span><span class=\"span_title\">Title</span><span class=\"span_duration\">Duration</span></div>";
    $tbl_array[] = "<div class=\"header_div\"><p></div>";
    $tbl_array[] = "<table>";
    
    $tbl_array[] = "<tr><td></td></tr>";
    foreach ($songList as $song){
        $num = 1;
        $title = $song->getTitle();
        $artist = $song->getArtist();
        $duration = $song->getDuration();
        $tbl_array[] = "<tr>";
        $tbl_array[] = "<td class=\"row_num\">$num</td>";
        $tbl_array[] = "<td>$title • $artist</td>";
        $tbl_array[] = "<td class=\"song_duration\">$duration</td>";
        $tbl_array[] = "</tr>";
        $num = $num +1;
    }
    $tbl_array[] = "</table>";
    
    return implode('', $tbl_array);
}

$header = html("components/shared/header.html");
$Album_Bar = template("components/album_list/Album_Bar.html")->bind([
    "image" => $album->getImagePath(),
    "image_alt" => $album->getTitle(),
    "title" => $album->getTitle(),
    "artist" => $album->getArtist(),
    "date" => $album->getPublishDateString(),
    "duration" => $album->getTotalDurationString(),
    "genre" => $album->getGenre(),
]);

template("components/album_detail.html")->bind([
    "navbar" => html("components/shared/navbar.html"),
    "main" => template("components/album_list/main.html")->bind([
        "header" => $header,
        "hero" => $Album_Bar,
    ]),
    "song_list" =>make_table($songList),
])->render();