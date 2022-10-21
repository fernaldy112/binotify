<?php

namespace Binotify\Store;

require_once(__DIR__."/../Model/Song.php");
use Binotify\Model\Song;
use mysqli;

class DataStore {

    private mysqli $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli("localhost:3306", "user", "password", "db");
    }

    function getSongById($id): Song|null
    {

        $result = $this->mysqli->query("SELECT * FROM song WHERE song_id = $id");
        $rawData = $result->fetch_all(MYSQLI_ASSOC);

        if (!array_key_exists(0, $rawData)) {
            return null;
        }

        $songData = $rawData[0];

        return new Song(
            $songData["song_id"],
            $songData["judul"],
            $songData["penyanyi"],
            $songData["tanggal_terbit"],
            $songData["genre"],
            $songData["duration"],
            $songData["audio_path"],
            $songData["image_path"],
            $songData["album_id"],
        );
    }

}

const STORE = new DataStore();
