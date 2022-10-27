<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$authControls = array_key_exists("username", $_SESSION)
    ? template("components/shared/auth.html")->bind($_SESSION)
    : html("components/shared/no-auth.html");

$HEADER = template("components/shared/header.html")->bind([
    "auth_controls" => $authControls
]);