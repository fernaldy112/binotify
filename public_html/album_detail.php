<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

$id = $_GET["s"];

$hiddenInput = "<input type='hidden' name='albumId' value=$id />";
$album = $STORE->getAlbumById($id);
$songList = $STORE->getAllSongByAlbumId($id);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (array_key_exists("username", $_SESSION)) {
    $tempUsername = $_SESSION["username"];
    $isAdmin = $STORE->getIsAdminByUsername($tempUsername);
} else {
    $isAdmin = false;
}

function make_table ($songList) {
    $tbl_array = [];
    $tbl_array[] = "<div class=\"top_div\"><span></span><span class=\"span_row_num\">#</span><span class=\"span_title\">Title</span><span class=\"span_duration\">Duration</span></div>";
    $tbl_array[] = "<div class=\"header_div\"><p></div>";
    $tbl_array[] = "<br>";
    $tbl_array[] = "<table>";
    $num = 1;
    foreach ($songList as $song){
        $song_id = $song->getId();
        $title = $song->getTitle();
        $artist = $song->getArtist();
        $duration = $song->getDuration();
        $tbl_array[] = "<tr>";
        $tbl_array[] = "<td class=\"song-checkbox\"><input type=\"checkbox\" name=\"color\" class=\"song-check\" value=\"$song_id\" id=\"c1\"></td>";
        $tbl_array[] = "<td class=\"row_num\" onclick=\"album_detail_ClickHandler($song_id)\">$num</td>";
        $tbl_array[] = "<td onclick=\"album_detail_ClickHandler($song_id)\">$title • $artist</td>";
        $tbl_array[] = "<td class=\"song_duration\" onclick=\"album_detail_ClickHandler($song_id)\">$duration</td>";
        $tbl_array[] = "</tr>";
        $num++;
    }
    $tbl_array[] = "</table>";
    
    return implode('', $tbl_array);
}

function deleteAlbum($STORE, $albumId, $album, $songList){
    $countSong = count($songList);
    if ($countSong == 0){
        $STORE->deleteAlbum($albumId);
        echo '<script language="javascript">';
        echo 'alert("Album Deleted!")';
        echo '</script>';
        header("Location: /album_list");
    }else{
        echo '<script language="javascript">';
        echo 'alert("Cannot Delete Album!\nAlbum not Empty")';
        // echo 'Location.href = "/album_list"';
        echo '</script>';
    }
}

$editButtonHolder = ""; // edit
$fileUpload = "";
if ($isAdmin){
    $editButtonHolder = "<button name='editAlbum' id='editButton'>Edit Album<i class='fa fa-external-link'></i></button>";
    $fileUpload = "<div id='fileUploadContainer'></div>";
}

$changeMessage = ""; 
if (isset($_GET["success"]) && $isAdmin){
    if ($_GET["success"] == 1 || $_GET["success"] == 7){ 
        $changeMessage = "<p id='editmsg'><span class='green'>Album is successfully edited.</span></p>";
    } else if ($_GET["success"] == 3){
        $changeMessage = "<p id='editmsg'>Image file format should be jpg, jpeg, or png. <span class='red'>Editing failed.</span></p>";
    } else if ($_GET["success"] == 5){
        $changeMessage = "<p id='editmsg'>Image file size is too big. Upload size is limited to 8MB. <span class='red'>Editing failed.</span></p>";
    }
}

function showCancel(){ // alert cancel delete
    echo '<script language="javascript">';
    echo 'alert("You Canceled")';
    echo '</script>';
}

function showNoSong(){ // delete song
    echo '<script language="javascript">';
    echo 'alert("No Song In Album")';
    echo '</script>';
}

$deleteButtonHolder = ""; // delete
if ($STORE->getIsAdminByUsername($tempUsername)){
    $deleteButtonHolder = "<button name='deleteAlbum' id='deleteButton'>Delete Album<i class='fa fa-trash-o'></i></button>";
    if (isset($_COOKIE["result"])) {
        if ($_COOKIE["result"]=="true"){
            deleteAlbum($STORE, $id, $album, $songList);
        }else{
            showCancel();
        }
    } 
}

function deleteSong($STORE, $songId){ // delete selected song
    $song = $STORE->getSongById($songId);
    $albumId = $song->getAlbumId();
    $album = $STORE->getAlbumById($albumId);
    $duration = $song->getDuration();
    $duration = $duration * -1;
    $STORE->addAlbumTotalDuration($albumId, $duration);
    $STORE->deleteSong($songId);
    // echo '<script language="javascript">';
    // echo 'alert("Song Deleted!")';
    // echo '</script>';  
    header("Location: /album_list?re=$albumId");
}


$deleteSongButtonHolder = ""; // delete song
if ($STORE->getIsAdminByUsername($tempUsername)){
    $deleteSongButtonHolder = "<button name='deleteAlbumSong' id='deleteAlbumSongButton'>Delete Song<i class='fa fa-trash-o'></i></button>";
    if (isset($_POST["confirm_delete"])) {
        if ($_POST["confirm_delete"]=="true"){
            if($_POST["values"]==""){
                showNoSong();
            }else{
                $values = $_POST["values"];
                $array = explode(',', $values);
                foreach ($array as $sid){
                    $song_id = (int) $sid;
                    deleteSong($STORE, $song_id);
                }
            }
            
        }else{
            showCancel();
        }
    } 
}


$header = html("components/shared/header.html");
$hero = template("components/album_detail/hero.html")->bind([
    "image" => $album->getImagePath(),
    "image_alt" => $album->getTitle(),
    "title" => $album->getTitle(),
    "editButton" => $editButtonHolder,//
    "deleteButton" => $deleteButtonHolder,//
    "deleteSongButton" => $deleteSongButtonHolder,//
    "artist" => $album->getArtist(),
    "date" => $album->getPublishDateString(),
    "duration" => $album->getTotalDurationString(),
    "genre" => $album->getGenre(),
    "fileUpload" => $fileUpload,
    "hiddenInput" => $hiddenInput,
    "changeMessage" => $changeMessage
]);

template("components/album_detail.html")->bind([
    "navbar" => html("components/shared/navbar.html"),
    "main" => template("components/album_detail/main.html")->bind([
        "header" => $header,
        "hero" => $hero,
        "song_list" =>make_table($songList)
    ]),
    
])->render();