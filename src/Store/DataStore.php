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

    function get(): DataStore
    {
        return new DataStore();
    }

    function getSongById($id): Song|null
    {

        $result = $this->mysqli->query("SELECT * FROM song WHERE song_id = $id");
        $rawData = $result->fetch_all(MYSQLI_ASSOC);

        if (!array_key_exists(0, $rawData)) {
            return null;
        }

        $songData = $rawData[0];

        $albumId = $songData["album_id"];
        $albumData = $this->getAlbumById($albumId);

        return Song::deserialize($songData, $albumData["judul"]);
    }

    function getSongBySimilarName($query): array
    {
        $res = [];

        $names = preg_replace("/\s+/", "|", $query);
        $result = $this->mysqli->query("SELECT * FROM song WHERE judul REGEXP '$names'");
        $rawData = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($rawData as $songData) {
            $albumData = $this->getAlbumById($songData["album_id"]);
            $res[] = Song::deserialize($songData, $albumData["judul"]);
        }

        return $res;
    }

    function getAlbumById($albumId) {
        $result = $this->mysqli->query("SELECT * FROM album WHERE album_id = $albumId");
        $rawData = $result->fetch_all(MYSQLI_ASSOC);
        return $rawData[0];
    }
}

$STORE = new DataStore();
