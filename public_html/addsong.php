<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");

    function checkMsg($msg){
        if (strlen($msg) !==0){
            $msg = "<p class='songAddition'>".$msg."</p>";
        }
        return $msg;
    }

    function checkInputLength($var, $errorkey, $msg, &$addSongError){
        if (strlen(trim($var))===0){
            $addSongError[$errorkey] = $msg;
            $addSongError["valid"] = false;
        }
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
        var_dump($_FILES);
        $title = $_POST["songTitle"];
        $singer = $_POST["songSinger"];
        $date = $_POST["songDate"];
        $genre = $_POST["songGenre"];
        $albumId = $_POST["songAlbum"];

        $file = $_FILES['songFile'];
        $image = $_FILES['songImage'];

        // TODO
        // $date = date("Y-m-d");

        checkInputLength($title, "titleError", "You need to enter the title.", $addSongError);
        checkInputLength($singer, "singerError", "You need to enter the singer.", $addSongError);
        checkInputLength($date, "dateError", "You need to enter the date.", $addSongError);
        checkInputLength($genre, "genreError", "You need to enter the genre.", $addSongError);
        checkInputLength($albumId, "albumError", "You need to enter the album id.", $addSongError);

        // TODO: check file and image uploaded
        if ($file['error']===4){
            $addSongError["fileError"] = "You need to upload the new file.";
        } else {
            $arrOfFileName = explode('.', $file["name"]);
            $fileExtension = strtolower(end($arrOfFileName));
            if ($fileExtension !== "mp3"){
                $addSongError["fileError"] = "File extension should be mp3";
            } else if ($file['size'] > 2000000) {
                $addSongError["fileError"] = "File size is too big.";
            } else {
                $filePath = __DIR__."/../assets/music/".strval(time())."_".$file["name"];
                move_uploaded_file($file["tmp_name"], $filePath);
            }
        }

        if ($image['error']===4){
            $addSongError["imageError"] = "You need to upload the image file.";
        } else {
            $arrOfImgName = explode('.', $image["name"]);
            $imgExtension = strtolower(end($arrOfImgName));
            if ($imgExtension !== "jpg" && $imgExtension !== "jpeg" && $imgExtension !== "png"){
                $addSongError["imageError"] = "Image extension should be jpg, jpeg, or png";
            } else if ($file['size'] > 8000000) {
                $addSongError["imgError"] = "Image size is too big.";
            } else {
                $imgPath = "image/".strval(time())."_".$image["name"];
                move_uploaded_file($image["tmp_name"], $imgPath);
            }
        }

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
            "fileError" => $addSongError["fileError"],
            "imageError" => $addSongError["imageError"],
            "success" => $successMsg,
        ]
    );
