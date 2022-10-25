<?php
    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");
    function checkMsg($msg){
        if (strlen($msg) !==0){
            $msg = "<p class='songAddition'>".$msg."</p>";
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
        var_dump($_FILES);
        $title = $_POST["albumTitle"];
        $singer = $_POST["albumSinger"];
        $date = $_POST["albumDate"];
        $genre = $_POST["albumGenre"];
        $image = $_FILES['albumImage'];
        // TODO
        // $date = date("Y-m-d");
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
            } else if ($file['size'] > 8000000) {
                $addAlbumError["imgError"] = "Image size is too big.";
            } else {
                $imgPath = "image/".strval(time())."_".$image["name"];
                move_uploaded_file($image["tmp_name"], $imgPath);
            }
        }

        }
        // TODO: kalau valid upload
        // if ($addAlbumError["valid"]){
        //     $STORE->addAlbum($title, $singer, $date, $genre, $image);
        //     $successMsg = "Album addition is successful";
        // }
    
    $addAlbumError["titleError"] = checkMsg($addAlbumError["titleError"]);
    $addAlbumError["singerError"] = checkMsg($addAlbumError["singerError"]);
    $addAlbumError["dateError"] = checkMsg($addAlbumError["dateError"]);
    $addAlbumError["genreError"] = checkMsg($addAlbumError["genreError"]);
    $addAlbumError["imageError"] = checkMsg($addAlbumError["imageError"]);
    $successMsg = checkMsg($successMsg);
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
