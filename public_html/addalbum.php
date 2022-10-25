<?php
    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");
    function checkMsg($msg){
        if (strlen($msg) !==0){
            $msg = "<p class='albumAdditionError'>".$msg."</p>";
        }
        return $msg;
    }
    function checkInputLength($var, $errorkey, $msg, &$addAlbumError){
        if (strlen(trim($var))===0){
            $addAlbumError[$errorkey] = $msg;
            $addAlbumError["valid"] = false;
        }
    }
    $addAlbumError = [
        "titleError" => "",
        "singerError" => "",
        "imageError" => "",
        "dateError" => "",
        "genreError" => "",
        "valid" => true
    ];
    $successMsg = "";
    if (isset($_POST["addAlbum"])){
        $title = $_POST["albumTitle"];
        $singer = $_POST["albumSinger"];
        $date = $_POST["albumDate"];
        $genre = $_POST["albumGenre"];
        $image = $_FILES['albumImage'];

        checkInputLength($title, "titleError", "You need to enter the title.", $addAlbumError);
        checkInputLength($singer, "singerError", "You need to enter the singer.", $addAlbumError);
        checkInputLength($date, "dateError", "You need to enter the date.", $addAlbumError);
        checkInputLength($genre, "genreError", "You need to enter the genre.", $addAlbumError);
        // TODO: check file and image uploaded

        if ($image['error']===4){
            $addAlbumError["imageError"] = "You need to upload the image file.";
        } else {
            $arrOfImgName = explode('.', $image["name"]);
            $imgExtension = strtolower(end($arrOfImgName));
            if ($imgExtension !== "jpg" && $imgExtension !== "jpeg" && $imgExtension !== "png"){
                $addAlbumError["imageError"] = "Image extension should be jpg, jpeg, or png";
                $addAlbumError["valid"] = false;
            } else if ($image['size'] > 2000000) {
                $addAlbumError["imgError"] = "Image size is too big.";
                $addAlbumError["valid"] = false;
            } else {
                $imageName = strval(time())."_".str_replace(' ', '_', $image["name"]);
                $imgPath = __DIR__."/../assets/image/".$imageName;

            }

            if ($addAlbumError["valid"]){
                move_uploaded_file($image["tmp_name"], $imgPath);
                $imageLoc = "image/".$imageName;
                $STORE->addAlbum($title, $singer, $date, $genre, $imageLoc);
                $successMsg = "Album addition is successful";
            }
    
        }

        }

    
    $addAlbumError["titleError"] = checkMsg($addAlbumError["titleError"]);
    $addAlbumError["singerError"] = checkMsg($addAlbumError["singerError"]);
    $addAlbumError["dateError"] = checkMsg($addAlbumError["dateError"]);
    $addAlbumError["genreError"] = checkMsg($addAlbumError["genreError"]);
    $addAlbumError["imageError"] = checkMsg($addAlbumError["imageError"]);
    if (strlen($successMsg) !==0){
        $successMsg = "<p class='albumAdditionSuccess'>".$successMsg."</p>";
    }

    template("components/addAlbum.html")->render(
        [
            "title" => "Add Album - Binotify",
            "titleError" => $addAlbumError["titleError"],
            "singerError" => $addAlbumError["singerError"],
            "dateError" => $addAlbumError["dateError"],
            "genreError" => $addAlbumError["genreError"],
            "imageError" => $addAlbumError["imageError"],
            "success" => $successMsg,
        ]
    );
