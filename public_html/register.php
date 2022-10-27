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

function checkMsg($msg){
    if (strlen($msg) !==0){
        $msg = "<p class='regError'>".$msg."</p>";
    }
    return $msg;
}

$emailError = "";
$usernameError = "";
$passwordError = "";
$password2Error = "";
$valid = true;

if (isset($_POST["register"])){
    $email = $_POST["userEmailRegister"];
    $username = $_POST["userNameRegister"];
    $password = $_POST["userPasswordRegister"];
    $password2 = $_POST["userPassword2Register"];

    $user = $STORE->getUserByEmail($email);
    if ($user){
        $emailError = "Email already exists.";
        $valid = false;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
        $valid = false;
    }

    $user = $STORE->getUserByUsername($username);
    if ($user){
        $usernameError = "Username already exists.";
        $valid = false;
    }

    if (preg_match("/\W/", $username)){
        $usernameError = "Invalid username format. Username can only consists of alphabets, numbers, and underscore.";
        $valid = false;
    }

    if ($password !== $password2){
        $password2Error = "Password doesn't match.";
        $valid = false;
    }

    if (strlen(trim($email))===0){
        $emailError = "You need to enter your email.";
        $valid = false;
    }
    if (strlen(trim($username))===0){
        $usernameError = "Enter a name for your profile.";
        $valid = false;
    }
    if (strlen(trim($password))===0){
        $passwordError = "You need to enter a password.";
        $valid = false;
    }
    if (strlen(trim($password2))===0){
        $password2Error = "You need to confirm your password.";
        $valid = false;
    }

    if ($valid){
        $password = md5($password);
        $user = $STORE->insertUser($email, $username, $password);
        $_SESSION["username"] = $user->getUsername();
        header("Location: index.php");
    }

}

if (isset($_POST["redirectLogIn"])){
    header("Location: login.php");
}

$emailError = checkMsg($emailError);
$usernameError = checkMsg($usernameError);
$passwordError = checkMsg($passwordError);
$password2Error = checkMsg($password2Error);

css("css/form.css");
css("css/login.css");
css("css/register.css");
css("http://fonts.cdnfonts.com/css/gotham");

template("components/authentication.html")->render(
    [
        "title" => "Sign up - Binotify",
        "form" => template("components/authentication/register.html")->bind([
            "emailError" => $emailError,
            "usernameError" => $usernameError,
            "passwordError" => $passwordError,
            "password2Error" => $password2Error
        ]),
    ]
);

