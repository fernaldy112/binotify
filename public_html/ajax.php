<?php

    require_once(__DIR__."/../src/Store/DataStore.php");
    
    if (!empty($_POST["changed"])){
        if ($_POST["changed"]==="email" && !empty($_POST["email"])){
            $email = $_POST["email"];
            $user = $STORE->getUserByEmail($email);
        } else if ($_POST["changed"]==="username" && !empty($_POST["username"])){
            $username = $_POST["username"];
            $user = $STORE->getUserByUsername($username);
        }
        if ($user){
            echo false;
        } else {
            echo true;
        }
    }
    