<?php

namespace Binotify\Store;

require_once(__DIR__."/../Model/Album.php");
use Binotify\Model\Album;
use mysqli;

class DataStore {

    private mysqli $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli("db", "user", "password", "db");
    }

    function getAlbumById($id): Album|null
    {

        $result = $this->mysqli->query("SELECT * FROM album WHERE album_id = $id");
        $rawData = $result->fetch_all(MYSQLI_ASSOC);

        if (!array_key_exists(0, $rawData)) {
            return null;
        }

        $albumData = $rawData[0];

        return new Album(
            $albumData["album_id"],
            $albumData["judul"],
            $albumData["penyanyi"],
            $albumData["total duration"],
            $albumData["image_path"],
            $albumData["tanggal_terbit"],
            $albumData["genre"],
        );
    }

    function addAlbum($title, $singer, $date, $genre, $image)
    {
        $sql = "INSERT INTO album (judul, penyanyi, image_path, tanggal_terbit, genre) VALUES ('$title', '$singer', '$image', '$date', '$genre');";
        $result = $this->mysqli->query($sql);

        if ($result)
        {
            $msg = "Album addition is successful";
        }else{
            $msg = "Data not inserted";
        }

        return $msg;
    }
}

$STORE = new DataStore();
