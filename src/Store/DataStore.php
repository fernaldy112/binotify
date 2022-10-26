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

    function getAllAlbum(): array{

        $result = $this->mysqli->query("SELECT * FROM album");
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        $albums = array();
        foreach($data as $row) {
            $album = new Album(
                $row["album_id"], 
                $row["judul"], 
                $row["penyanyi"], 
                $row["total_duration"], 
                $row["image_path"],
                $row["tanggal_terbit"],
                $row["genre"]
            );
            array_push($albums, $album);
         }

        return $albums;

    }


    function addAlbum($title, $singer, $date, $genre, $image)
    {
        $result = mysqli_query($this->mysqli, "INSERT INTO album (judul, penyanyi, image_path, tanggal_terbit, genre) VALUES ('$title', '$singer', '$image', '$date', '$genre')");
        return $result;

    }
}

$STORE = new DataStore();
