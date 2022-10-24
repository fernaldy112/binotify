<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");

    function checkMsg($msg){
        if (strlen($msg) !==0){
            $msg = "<p class='songAddition'>".$msg."</p>";
        }
        return $msg;
    }


    $addSongError = [
        "titleError" => "",
        "singerError" => "",
        "dateError" => "",
        "genreError" => "",
        "fileError" => "",
        "imageError" => "",
        "albumError" => "",
        "valid" => true
    ];
    $successMsg = "";

    if (isset($_POST["addSong"])){
        $title = $_POST["songTitle"];
        $singer = $_POST["songSinger"];
        $date = $_POST["songDate"];
        $genre = $_POST["songGenre"];
        $file = $_POST["songFile"];
        $image = $_POST["songImage"];
        $albumId = $_POST["songAlbum"];

        $date = date("Y-m-d");

        if (strlen(trim($title))===0){
            $addSongError["titleError"] = "You need to enter the title.";
            $addSongError["valid"] = false;
        }
        if (strlen(trim($singer))===0){
            $addSongError["singerError"] = "You need to enter the singer.";
            $addSongError["valid"] = false;
        }
        if (strlen(trim($date))===0){
            $addSongError["dateError"] = "You need to enter the date.";
            $addSongError["valid"] = false;
        }
        if (strlen(trim($genre))===0){
            $addSongError["genreError"] = "You need to enter the genre.";
            $addSongError["valid"] = false;
        }
        if (strlen(trim($albumId))===0){
            $addSongError["albumError"] = "You need to enter the album id.";
            $addSongError["valid"] = false;
        }

        // TODO: check file and image uploaded
        // TODO: check extension file dan image

        // TODO: count song duration
        // ffmpeg

        // TODO: change album total duration
        // $addDuration = $STORE->addAlbumTotalDuration($albumId, $duration);

        $album = $STORE->getAlbumById($albumId);
        if (!$album){
            $addSongError["albumError"] = "Invalid album id.";
            $addSongError["valid"] = false;
        }

        // TODO: kalau valid upload
        // if ($addSongError["valid"]){
        //     $STORE->addSong($title, $singer, $date, $genre, $file, $image, $albumId);
        //     $successMsg = "Song addition is successful";
        // }
    }

    $addSongError["titleError"] = checkMsg($addSongError["titleError"]);
    $addSongError["singerError"] = checkMsg($addSongError["singerError"]);
    $addSongError["dateError"] = checkMsg($addSongError["dateError"]);
    $addSongError["genreError"] = checkMsg($addSongError["genreError"]);
    $addSongError["albumError"] = checkMsg($addSongError["albumError"]);
    $successMsg = checkMsg($successMsg);

    template("components/addsong.html")->render(
        [
            "title" => "Add song - Binotify",
            "titleError" => $addSongError["titleError"],
            "singerError" => $addSongError["singerError"],
            "dateError" => $addSongError["dateError"],
            "genreError" => $addSongError["genreError"],
            "albumError" => $addSongError["albumError"],
            "success" => $successMsg,
        ]
    );
