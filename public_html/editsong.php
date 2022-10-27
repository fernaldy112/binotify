<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");
    require_once(__DIR__."/../src/Model/Song.php");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (array_key_exists("username", $_SESSION)) {
        $tempUsername = $_SESSION["username"];
        $isAdmin = $STORE->getIsAdminByUsername($tempUsername);
    } else {
        $isAdmin = false;
    }

    if (!$isAdmin){
        header("Location: /");
        return;
    }

    function countSeconds($duration){
        $duration = explode(':', $duration);
        $second = (int)$duration[0]*3600 + (int)$duration[1]*60 + (int)$duration[2];
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

        $fileSuccess = 1; // 1 success; 2 song format error; 4 song size error; 6 no new audio file
        $imageSuccess = 1; // 1 success; 3 image format error; 5 image size error; 7 no new image file

        $newFileName = "";
        if ($newFile['error']===4){
            $newFilePath = $song->getAudioPath();
            $fileSuccess = 6;
        } else {
            $arrOfFileName = explode('.', $newFile["name"]);
            $fileExtension = strtolower(end($arrOfFileName));
            if ($fileExtension !== "mp3"){
                $fileSuccess = 2;
                $newFilePath = $song->getAudioPath();
            } else if ($newFile['error']!==UPLOAD_ERR_OK) {
                if ($newFile['error']===UPLOAD_ERR_INI_SIZE || $newFile['error']===UPLOAD_ERR_FORM_SIZE){
                    $fileSuccess = 4;
                    $newFilePath = $song->getAudioPath();
                }
            } else {
                $newFileName = strval(time())."_".str_replace(' ', '_', $newFile["name"]);
                $newAssetFilePath = __DIR__."/../assets/music/".$newFileName;
            }
        }

        if ($newImage['error']===4){
            $newImagePath = $song->getImagePath();
            $imageSuccess = 7;
        } else {
            $arrOfImgName = explode('.', $newImage["name"]);
            $imgExtension = strtolower(end($arrOfImgName));
            if ($imgExtension !== "jpg" && $imgExtension !== "jpeg" && $imgExtension !== "png"){
                $imageSuccess = 3;
                $newImagePath = $song->getImagePath();
            } else if ($newImage['error']!==UPLOAD_ERR_OK) {
                if ($newImage['error']===UPLOAD_ERR_INI_SIZE || $newImage['error']===UPLOAD_ERR_FORM_SIZE){
                    $imageSuccess = 5;
                    $newImagePath = $song->getImagePath();
                }
            } else {
                $newImageName = strval(time())."_".str_replace(' ', '_', $newImage["name"]);
                $newAssetImgPath = __DIR__."/../assets/image/".$newImageName;
            }
        }

        $duration = -1;
        if (strlen($newFile["tmp_name"]) !== 0 && $fileSuccess===1){
            move_uploaded_file($newFile["tmp_name"], $newAssetFilePath);
            $duration = shell_exec("cd music ; ffmpeg -i '$newFileName' 2>&1 | grep Duration | awk '{print $2}' | tr -d ,");
            $duration = countSeconds($duration);
            $newFilePath = "music/".$newFileName;
        }
        if (strlen($newImage["tmp_name"]) !== 0 && $imageSuccess===1){
            move_uploaded_file($newImage["tmp_name"], $newAssetImgPath);
            $newImagePath = "image/".$newImageName;
        }
        
        $singer = $song->getArtist();
        $albumId = $song->getAlbumId();

        $oldDuration = $song->getDuration();
        if ($duration == -1){
            $duration = $oldDuration;
        }

        $STORE->updateSong($songId, $newTitle, $singer, $newDate, $newGenre, $duration, $newFilePath, $newImagePath, $albumId);

        $STORE->addAlbumTotalDuration($albumId, -1*$oldDuration);
        $STORE->addAlbumTotalDuration($albumId, $duration);


        header("Location: /listen?s=$songId&fileSuccess=$fileSuccess&imageSuccess=$imageSuccess");
    }