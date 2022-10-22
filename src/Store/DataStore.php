<?php

namespace Binotify\Store;

require_once(__DIR__."/../Model/Song.php");
require_once(__DIR__."/../Model/User.php");
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

    function getUserByEmail($email): User|null{

        $result = $this->mysqli->query("SELECT * FROM user WHERE email=$email");
        $rawData = $result->fetch_all(MYSQLI_ASSOC);

        if (!array_key_exists(0, $rawData)) {
            return null;
        }

        $userData = $rawData[0];

        return new User(
            $userData["user_id"], 
            $userData["email"], 
            $userData["password"], 
            $userData["username"], 
            $userData["isAdmin"]
        );

    }

    function getUserByUsername($username): User|null{

        $result = $this->mysqli->query("SELECT * FROM user WHERE username=$username");
        $rawData = $result->fetch_all(MYSQLI_ASSOC);

        if (!array_key_exists(0, $rawData)) {
            return null;
        }

        $userData = $rawData[0];

        return new User(
            $userData["user_id"], 
            $userData["email"], 
            $userData["password"], 
            $userData["username"], 
            $userData["isAdmin"]
        );

    }

    function getAllUser(): array{

        $result = $this->mysqli->query("SELECT * FROM user");
        $data = $result->fetch_all(MYSQLI_ASSOC);

        for ($i=0; i<count($data); $i++){
            $data[i] = new User(
                $data[i]["user_id"], 
                $data[i]["email"], 
                $data[i]["password"], 
                $data[i]["username"], 
                $data[i]["isAdmin"]
            );
        }

        return $data;

    }

}

const STORE = new DataStore();
