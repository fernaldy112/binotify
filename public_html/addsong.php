<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

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
    $second = $duration[0]*3600 + $duration[1]*60 + $duration[2];
    return $second;
}

function checkErrorMsg($msg){
    if (strlen($msg) !==0){
        $msg = "<p class='songAdditionError'>".$msg."</p>";
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

if (isset($_GET["back"])){
    header("Location:/");
}

if (isset($_POST["addSong"])){
    $title = $_POST["songTitle"];
    $singer = $_POST["songSinger"];
    $date = $_POST["songDate"];
    $genre = $_POST["songGenre"];
    $albumId = $_POST["songAlbum"];

    $file = $_FILES['songFile'];
    $image = $_FILES['songImage'];

    checkInputLength($title, "titleError", "You need to enter the title.", $addSongError);
    checkInputLength($singer, "singerError", "You need to enter the singer.", $addSongError);
    checkInputLength($date, "dateError", "You need to enter the date.", $addSongError);
    checkInputLength($genre, "genreError", "You need to enter the genre.", $addSongError);
    checkInputLength($albumId, "albumError", "You need to enter the album id.", $addSongError);

    if ($file['error']===4){
        $addSongError["fileError"] = "You need to upload the new file.";
        $addSongError["valid"] = false;
    } else {
        $arrOfFileName = explode('.', $file["name"]);
        $fileExtension = strtolower(end($arrOfFileName));
        if ($fileExtension !== "mp3"){
            $addSongError["fileError"] = "File extension should be mp3";
            $addSongError["valid"] = false;
        } else if ($file['error']!==UPLOAD_ERR_OK) {
            if ($file['error']===UPLOAD_ERR_INI_SIZE || $file['error']===UPLOAD_ERR_FORM_SIZE){
                $addSongError["fileError"] = "File size is too big. Upload is limited to 8MB";
                $addSongError["valid"] = false;
            }
        } else {
            $fileName = strval(time())."_".str_replace(' ', '_', $file["name"]);
            $filePath = __DIR__."/../assets/music/".$fileName;
        }
    }

    if ($image['error']===4){
        $addSongError["imageError"] = "You need to upload the image file.";
        $addSongError["valid"] = false;
    } else {
        $arrOfImgName = explode('.', $image["name"]);
        $imgExtension = strtolower(end($arrOfImgName));
        if ($imgExtension !== "jpg" && $imgExtension !== "jpeg" && $imgExtension !== "png"){
            $addSongError["imageError"] = "Image extension should be jpg, jpeg, or png";
            $addSongError["valid"] = false;
        } else if ($image['error']!==UPLOAD_ERR_OK) {
            if ($image['error']===UPLOAD_ERR_INI_SIZE || $image['error']===UPLOAD_ERR_FORM_SIZE){
                $addSongError["imageError"] = "Image size is too big. Upload is limited to 8MB";
                $addSongError["valid"] = false;
            }
        } else {
            $imageName = strval(time())."_".str_replace(' ', '_', $image["name"]);
            $imgPath = __DIR__."/../assets/image/".$imageName;
        }
    }

    $album = NULL;
    if (strlen(trim($albumId))!==0){
        $album = $STORE->getAlbumById($albumId);
    }
    if (!$album){
        $addSongError["albumError"] = "Invalid album id.";
        $addSongError["valid"] = false;
    }

    if ($addSongError["valid"]){
        move_uploaded_file($file["tmp_name"], $filePath);
        move_uploaded_file($image["tmp_name"], $imgPath);
        if (strlen($addSongError["fileError"])===0){
            $duration = shell_exec("cd music ; ffmpeg -i '$fileName' 2>&1 | grep Duration | awk '{print $2}' | tr -d ,");
        }
        $duration = countSeconds($duration);
        $fileLoc = "music/".$fileName;
        $imageLoc = "image/".$imageName;
        $STORE->addSong($title, $singer, $date, $genre, $duration, $fileLoc, $imageLoc, $albumId);
        $addDuration = $STORE->addAlbumTotalDuration($albumId, $duration);
        $successMsg = "Song addition is successful";
    }
}

$addSongError["titleError"] = checkErrorMsg($addSongError["titleError"]);
$addSongError["singerError"] = checkErrorMsg($addSongError["singerError"]);
$addSongError["dateError"] = checkErrorMsg($addSongError["dateError"]);
$addSongError["genreError"] = checkErrorMsg($addSongError["genreError"]);
$addSongError["albumError"] = checkErrorMsg($addSongError["albumError"]);
$addSongError["fileError"] = checkErrorMsg($addSongError["fileError"]);
$addSongError["imageError"] = checkErrorMsg($addSongError["imageError"]);
if (strlen($successMsg) !==0){
    $successMsg = "<p class='songAdditionSuccess'>".$successMsg."</p>";
}

css("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
css("http://fonts.cdnfonts.com/css/gotham");
css("css/form.css");
css("css/adddata.css");

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
