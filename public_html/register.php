<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");

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
