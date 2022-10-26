<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");
    require_once(__DIR__."/../src/Model/Song.php");

    function countSeconds($duration){ // TODO
        $duration = explode(':', $duration);
        $second = 0;
        foreach($duration as $x){
            $x = (int)$x;
            $second += $x;
        }
        return $second;
    }

    if (isset($_POST["submitSongChange"])){
        $newTitle = $_POST["inputTitle"];
        $newDate = $_POST["inputDate"];
        $newGenre = $_POST["inputGenre"];
        $newFile = $_FILES["inputFile"];
        $newImage = $_FILES["inputImage"];

        $newFilePath = "";
        $newImagePath = "";

        $songId = $_POST["songId"];
        $song = $STORE->getSongById($songId);
        
        // cek input kosong -> tetap -> ambil dari db
        if (strlen(trim($newTitle))===0){
            $newTitle = $song->getTitle();
        }
        if (strlen(trim($newDate))===0){
            $newDate = $song->getPublishDate();
        }
        if (strlen(trim($newGenre))===0){
            $newGenre = $song->getGenre();
        }

        $success = 1; // 1 success; 2 song format error; 3 image format error; 4 song size error; 5 image size error; 6 no new audio file; 7 no new image file

        if ($newFile['error']===4){
            $newFilePath = $song->getAudioPath();
            $success = 6;
        } else {
            $arrOfFileName = explode('.', $newFile["name"]);
            $fileExtension = strtolower(end($arrOfFileName));
            if ($fileExtension !== "mp3"){
                $success = 2;
                $newFilePath = $song->getAudioPath();
            } else if ($newFile['error']!==UPLOAD_ERR_OK) {
                if ($newFile['error']===UPLOAD_ERR_INI_SIZE || $newFile['error']===UPLOAD_ERR_FORM_SIZE){
                    $success = 4;
                    $newFilePath = $song->getAudioPath();
                }
            } else {
                $newFileName = strval(time())."_".str_replace(' ', '_', $newFile["name"]);
                $newAssetFilePath = __DIR__."/../assets/music/".$newFileName;
            }
        }

        if ($newImage['error']===4){
            $newImagePath = $song->getImagePath();
            $success = 7;
        } else {
            $arrOfImgName = explode('.', $image["name"]);
            $imgExtension = strtolower(end($arrOfImgName));
            if ($imgExtension !== "jpg" && $imgExtension !== "jpeg" && $imgExtension !== "png"){
                $success = 3;
                $newImagePath = $song->getImagePath();
            } else if ($newImage['error']!==UPLOAD_ERR_OK) {
                if ($newImage['error']===UPLOAD_ERR_INI_SIZE || $newImage['error']===UPLOAD_ERR_FORM_SIZE){
                    $success = 5;
                    $newImagePath = $song->getImagePath();
                }
            } else {
                $newImageName = strval(time())."_".str_replace(' ', '_', $newImage["name"]);
                $newAssetImgPath = __DIR__."/../assets/image/".$newImageName;
            }
        }

        move_uploaded_file($newFile["tmp_name"], $newAssetFilePath);
        move_uploaded_file($newImage["tmp_name"], $newAssetImgPath);
        if ($success!==2 && $success!==4 && $success!==6){
            $duration = shell_exec("cd music ; ffmpeg -i $newFileName 2>&1 | grep Duration | awk '{print $2}' | tr -d ,");
        }
        $duration = countSeconds($duration);
        $fileLoc = "music/".$newFileName;
        $imageLoc = "image/".$newImageName;
        // $STORE->addSong($title, $singer, $date, $genre, $duration, $fileLoc, $imageLoc, $albumId); // TODO: UPDATE song 
        // $addDuration = $STORE->addAlbumTotalDuration($albumId, $duration); // TODO: UPDATE album

        // header("Location: /listen?s=$songId&success=$success");
    }