<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");

    $invalidLogin = "";

    if (isset($_POST["login"])){
        $identity = $_POST["userIdentityLogin"];
        $password = $_POST["userPasswordLogin"];
        
        $user = $STORE->getUserByEmail($identity) ?? $STORE->getUserByUsername($identity);

        if (!$user || md5($password) !== $user->getPassword()){
            $invalidLogin = "Incorrect credential.";
        } else {
            $_SESSION["username"] = $user->getUsername();
            header("Location: index.php");
        }
    } 
    
    if (isset($_POST["redirectSignUp"])){
        header("Location: register.php");
    }

    template("components/authentication.html")->render(
        [
            "title" => "Log in - Binotify",
            "form" => template("components/authentication/login.html")->bind([
                "invalidLogin" => $invalidLogin,
            ]),
        ]
    );
