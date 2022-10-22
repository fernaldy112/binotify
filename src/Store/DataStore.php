<?php

namespace Binotify\Store;

// require_once(__DIR__."/../Model/Song.php");
require_once(__DIR__."/../Model/User.php");
// use Binotify\Model\Song;
use Binotify\Model\User;
use mysqli;

class DataStore {

    private mysqli $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli("db", "user", "password", "db");
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

        $result = $this->mysqli->query("SELECT * FROM user WHERE email='$email'");

        if($result){
            $rawData = $result->fetch_all(MYSQLI_ASSOC);
            if (!array_key_exists(0, $rawData)) {
                return null;
            }    
        } else {
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

        $result = $this->mysqli->query("SELECT * FROM user WHERE username='$username'");

        if($result){
            $rawData = $result->fetch_all(MYSQLI_ASSOC);
            if (!array_key_exists(0, $rawData)) {
                return null;
            }    
        } else {
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
        
        $users = array();
        foreach($data as $row) {
            $user = new User(
                $row["user_id"], 
                $row["email"], 
                $row["password"], 
                $row["username"], 
                $row["isAdmin"]
            );
            array_push($users, $user);
         }

        return $users;

    }

    function insertUser($email, $username, $password){
        
        $isAdmin = 0;
        $result = mysqli_query($this->mysqli, "INSERT INTO user (email, password, username, isAdmin) VALUES ('$email', '$password', '$username', $isAdmin)");
        return $this->getUserByEmail($email);

    }

}

$STORE = new DataStore();
