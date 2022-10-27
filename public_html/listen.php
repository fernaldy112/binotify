<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");
require_once(__DIR__."/../src/components/header.php");
require_once(__DIR__."/../src/components/navbar.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!array_key_exists("username", $_SESSION)) {
    if (!array_key_exists("last_listen_date", $_SESSION) ||
        date_diff(date_create(), $_SESSION["last_listen_date"])->d !== 0
    ) {
        $_SESSION["last_listen_date"] = date_create();
        $_SESSION["listened"] = 0;
    }

    if ($_SESSION["listened"] >= 3) {
        header("Location: /login");
        return;
    }

    $_SESSION["listened"]++;
}

$id = $_GET["s"];
$hiddenInput = "<input type='hidden' name='songId' value=$id />";

if (!isset($STORE) || !isset($NAVBAR) || !isset($HEADER)) {
    http_response_code(500);
    return;
}

$song = $STORE->getSongById($id);

if ($song === null) {
    http_response_code(404);
    return;
}

function deleteSong($STORE, $songId){
    $song = $STORE->getSongById($songId);
    $albumId = $song->getAlbumId();
    $album = $STORE->getAlbumById($albumId);
    $duration = $song->getDuration();
    $duration = $duration * -1;
    $STORE->addAlbumTotalDuration($albumId, $duration);
    $STORE->deleteSong($songId);
    echo '<script language="javascript">';
    echo 'alert("Album Deleted!")';
    echo '</script>';
    
}

function showCancel(){
    echo '<script language="javascript">';
    echo 'alert("You Canceled")';
    echo '</script>';
}

$buttonHolder = "";
$fileUpload = "";
$isAdmin = $STORE->getIsAdminByUsername($_SESSION["username"]);
if ($isAdmin) {
    $buttonHolder = "<button name='editSong' id='editButton'>Edit<i class='fa fa-external-link'></i></button>";
    $fileUpload = "<div id='fileUploadContainer'></div>";
}

$deleteButtonHolder = "";
if ($STORE->getIsAdminByUsername($_SESSION["username"])){
    $deleteButtonHolder = "<button name='deleteSong' id='deleteButton'>Delete<i class='fa fa-trash-o'></i></button>";
    if (isset($_COOKIE["result"])) {
        if ($_COOKIE["result"]=="true"){
            deleteSong($STORE, $id);
        }else{
            showCancel();
        }
    }

}

$changeMessage = "";
if (isset($_GET["fileSuccess"]) && isset($_GET["imageSuccess"]) &&$isAdmin){
    if ($_GET["fileSuccess"] == 2){
        $changeMessage = "<p id='editmsg'>Audio file format should be mp3. <span class='red'>Editing failed.</span></p>";
    } else if ($_GET["imageSuccess"] == 3){
        $changeMessage = "<p id='editmsg'>Image file format should be jpg, jpeg, or png. <span class='red'>Editing failed.</span></p>";
    } else if ($_GET["fileSuccess"] == 4){
        $changeMessage = "<p id='editmsg'>Audio file size is too big. Upload size is limited to 8MB. <span class='red'>Editing failed.</span></p>";
    } else if ($_GET["imageSuccess"] == 5){
        $changeMessage = "<p id='editmsg'>Image file size is too big. Upload size is limited to 8MB. <span class='red'>Editing failed.</span></p>";
    } else if ($_GET["fileSuccess"] == 1 || $_GET["imageSuccess"] == 1){
        $changeMessage = "<p id='editmsg'><span class='green'>Song is successfully edited.</span></p>";
    } else if ($_GET["fileSuccess"] == 6 && $_GET["imageSuccess"] == 7){
        $changeMessage = "<p id='editmsg'><span class='green'>Song is successfully edited.</span></p>";
    }
}

css("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap");
css("css/styles.css");
css("css/listen.css");
css("css/shared.css");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200");
css("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
js("js/util.js");
js("js/player.js");
js("js/searchbar.js");
js("js/listen.js");
js("js/editsong.js");

$hero = template("components/listen/hero.html")->bind([
    "image" => $song->getImagePath(),
    "image_alt" => $song->getTitle(),
    "title" => $song->getTitle(),
    "editButton" => $buttonHolder,
    "deleteButton" => $deleteButtonHolder,
    "artist" => $song->getArtist(),
    "date" => $song->getPublishDateString(),
    "duration" => $song->getDurationString(),
    "genre" => $song->getGenre(),
    "album_name" => $song->getAlbumTitle(),
    "fileUpload" => $fileUpload,
    "hiddenInput" => $hiddenInput,
    "album_url" => "/album_detail?s=".$song->getAlbumId(),
    "changeMessage" => $changeMessage,
]);
$playBar = template("components/listen/play-bar.html")->bind([
    "cover" => $song->getImagePath(),
    "cover_alt" => $song->getTitle(),
    "title" => $song->getTitle(),
    "artist" => $song->getArtist(),
    "duration" => $song->getDurationString()
]);

template("components/listen.html")->bind([
    "song" => $song->getArtist()." - ".$song->getTitle(),
    "navbar" => $NAVBAR,
    "main" => template("components/listen/main.html")->bind([
        "header" => $HEADER,
        "hero" => $hero,
    ]),
    "playBar" => $playBar,
    "source" => $song->getAudioPath()
])->render();
