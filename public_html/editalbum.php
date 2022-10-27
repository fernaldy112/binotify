<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");
    require_once(__DIR__."/../src/Model/Album.php");

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

    if (isset($_POST["submitAlbumChange"])){
        $newTitle = $_POST["inputTitle"];
        $newArtist = $_POST["inputArtist"];
        $newImage = $_FILES["inputImage"];

        $newImagePath = "";

        var_dump($newImage);

        $albumId = $_POST["albumId"];
        $album = $STORE->getAlbumById($albumId); // handle null
        
        // cek input kosong -> tetap -> ambil dari db
        if (strlen(trim($newTitle))===0){
            $newTitle = $album->getTitle();
        }
        if (strlen(trim($newArtist))===0){
            $newArtist = $song->getArtist();
        }

        $success = 1; // 1 success; 3 image format error; 5 image size error; 7 no new image file

        if ($newImage['error']===4){
            $newImagePath = $album->getImagePath();
            $success = 7;
        } else {
            $arrOfImgName = explode('.', $newImage["name"]);
            $imgExtension = strtolower(end($arrOfImgName));
            if ($imgExtension !== "jpg" && $imgExtension !== "jpeg" && $imgExtension !== "png"){
                $success = 3;
                $newImagePath = $album->getImagePath();
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

        if (strlen($newImage["tmp_name"]) !== 0 && $success === 1){
            move_uploaded_file($newImage["tmp_name"], $newAssetImgPath);
            $newImagePath = "image/".$newImageName;
        }

        $STORE->updateAlbum($albumId, $newTitle, $newArtist, $newImagePath);

        header("Location: /album_detail?s=$albumId&success=$success");
    }
