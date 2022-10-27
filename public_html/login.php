<?php

require_once(__DIR__."/../src/Template/util.php");
require_once(__DIR__."/../src/Store/DataStore.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (array_key_exists("username", $_SESSION)) {
    header("Location: /");
    return;
}

$invalidLogin = "";

if (isset($_POST["login"])){
    $identity = $_POST["userIdentityLogin"];
    $password = $_POST["userPasswordLogin"];

    $user = $STORE->getUserByEmail($identity) ?? $STORE->getUserByUsername($identity);

    if (strlen(trim($identity))===0 || strlen(trim($password))===0){
        $invalidLogin = "Every input must be filled.";
    } else if (!$user || md5($password) !== $user->getPassword()){
        $invalidLogin = "Incorrect credential.";
    } else {
        session_start();
        $_SESSION["username"] = $user->getUsername();
        header("Location: index.php");
    }
}

if (isset($_POST["redirectSignUp"])){
    header("Location: register.php");
}

if (strlen($invalidLogin) !==0){
    $invalidLogin = "<p class='loginError'>".$invalidLogin."</p>";
}

css("css/form.css");
css("css/login.css");
css("css/register.css");
css("http://fonts.cdnfonts.com/css/gotham");

template("components/authentication.html")->render(
    [
        "title" => "Log in - Binotify",
        "form" => template("components/authentication/login.html")->bind([
            "invalidLogin" => $invalidLogin,
        ]),
    ]
);
