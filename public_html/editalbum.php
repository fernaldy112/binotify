<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");
    require_once(__DIR__."/../src/Model/Album.php");

    if (isset($_POST["submitAlbumChange"])){
        $newTitle = $_POST["inputTitle"];
        $newArtist = $_POST["inputArtist"];
        $newImage = $_FILES["inputImage"];

        $newImagePath = "";

        $albumId = $_POST["albumId"];
        $album = $STORE->getAlbumById($albumId);
        
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

        if ($newImage['error']===4){
            $newImagePath = $album->getImagePath();
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
                    $newImagePath = $album->getImagePath();
                }
            } else {
                $newImageName = strval(time())."_".str_replace(' ', '_', $newImage["name"]);
                $newAssetImgPath = __DIR__."/../assets/image/".$newImageName;
            }
        }

        move_uploaded_file($newImage["tmp_name"], $newAssetImgPath);
        $imageLoc = "image/".$newImageName;
        $STORE->updateAlbum($albumId, $title, $artist, $imageLoc);

        header("Location: /album_detail?s=$albumId&success=$success");
    }
