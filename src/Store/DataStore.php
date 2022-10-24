<?php

namespace Binotify\Store;

require_once(__DIR__."/../Model/Song.php");
use Binotify\Model\Song;
use mysqli;

class DataStore {

    private mysqli $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli("db", "user", "password", "db"); // localhost:3306
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

    function getSongBySimilarName($query, $page = 1, $ext = " ORDER BY judul ASC"): array
    {
        $res = [];
        $offset = ($page - 1) * 20;

        $names = preg_replace("/\s+/", "|", $query);
        $cond = "judul REGEXP '$names' OR penyanyi REGEXP '$names' OR YEAR(tanggal_terbit) REGEXP '$names'";
        $result = $this->mysqli->query(
            "SELECT * FROM song WHERE $cond$ext LIMIT 21 OFFSET $offset"
        );
        $rawData = $result->fetch_all(MYSQLI_ASSOC);

        $hasNext = false;
        if (array_key_exists(20, $rawData)) {
            $hasNext = true;
            array_pop($rawData);
        }

        foreach ($rawData as $songData) {
            $albumData = $this->getAlbumById($songData["album_id"]);
            $res[] = Song::deserialize($songData, $albumData["judul"]);
        }

        return [
            "data" => $res,
            "hasNext" => $hasNext
        ];
    }

    function getAlbumById($albumId) {
        $result = $this->mysqli->query("SELECT * FROM album WHERE album_id = '$albumId'");
        $rawData = $result->fetch_all(MYSQLI_ASSOC);
        if (!array_key_exists(0, $rawData)) {
            return null;
        }
        return $rawData[0];
    }

    function getSongBySimilarNameSorted($query, $page, $sortBy, $order): array
    {
        if ($sortBy === "title") {
            $sortAttr = "judul";
        } else {
            $sortAttr = "tanggal_terbit";
        }

        $order = strtoupper($order);

        $queryExt = " ORDER BY $sortAttr $order";

        return $this->getSongBySimilarName($query, $page, $queryExt);
    }

    function getSongGenres(): array
    {
        $result = $this->mysqli->query('SELECT DISTINCT genre FROM song;');
        $rawData = $result->fetch_all(MYSQLI_ASSOC);
        return array_map(array("self", "genreMap"), $rawData);
    }

    static function genreMap($genreRow) {
        return $genreRow["genre"];
    }

    function addAlbumTotalDuration($albumId, $extraDuration){
        $result = mysqli_query($this->mysqli, "UPDATE album SET duration = duration + $extraDuration WHERE album_id = '$albumId'");
        return $result;
    }

    function addSong($title, $singer, $releaseDate, $genre, $duration, $audioPath, $imgPath, $albumId){
        $result = mysqli_query($this->mysqli, "INSERT INTO song (judul, penyanyi, tanggal_terbit, genre, duration, audio_path, image_path, album_id) VALUES ('$title', '$singer', '$releaseDate', '$genre', '$duration', '$audioPath', '$imgPath', '$albumId')");
        return $result;
    }
}

$STORE = new DataStore();
