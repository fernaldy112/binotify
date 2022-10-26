<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

$albumList = $STORE->getAllAlbum();

function make_table ($albumList) {
    $tbl_array = [];
    // $tbl_array[] = "<table>";
    foreach ($albumList as $album){
        $title = $album->getTitle();
        $artist = $album->getArtist();
        $tahun = $album->getPublishDate();
        $tahun= mb_substr($tahun, 0, 4);
        $image_path = $album->getImagePath();
        $path = "/assets/";
        $image_path = $path . $image_path;
        $genre = $album->getGenre();
        $tbl_array[]= "<div id=\"albumList_hero\">";
        $tbl_array[]= "<img class=\"cover\" src=\"$image_path\" alt=\"Kosong\">";
        $tbl_array[]= "<div class=\"details\">";
        $tbl_array[]= "<h2 class=\"item\">Album</h2>";
        $tbl_array[]= "<h1 class=\"title\">$title</h1>";
        
        // $tbl_array[]= "<div class=\"dropdown\">";
            
        // $tbl_array[]= "<ul class=\"dropbtn icons btn-right showLeft\" onclick=\"showDropdown()\">";
        // $tbl_array[]= "<li></li>";
        // $tbl_array[]= "<li></li>";
        // $tbl_array[]= "<li></li>";
        // $tbl_array[]= "</ul>";
            
        // $tbl_array[]= "<div id=\"myDropdown\" class=\"dropdown-content\">";
        // $tbl_array[]= "<a href=\"#home\">Open</a>";
        // $tbl_array[]= "<a href=\"#about\">Edit</a>";
        // $tbl_array[]= "</div>";
        // $tbl_array[]= "</div>";
        $tbl_array[]= "<span class=\"details-meta\">$artist</span>";
        $tbl_array[]= "<span class=\"details-meta\">$tahun • $genre</span>";
        $tbl_array[]= "</div>";
        $tbl_array[]= "</div>";
    }
    // $tbl_array[] = "</table>";
    
    return implode('', $tbl_array);

}

template("components/album_list.html")->render(
    [
        "title"=> "Album List - Binotify",
        "album_list" => make_table($albumList),
    ]
    );
