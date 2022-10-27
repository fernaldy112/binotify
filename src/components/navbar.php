<?php

require_once(__DIR__."/../Template/util.php");
require_once(__DIR__."/../Store/DataStore.php");

// if (!isset($STORE)) {
//     http_response_code(500);
//     return;
// }

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = false;

if (array_key_exists("username", $_SESSION)) {
    $user = $STORE->getUserByUsername($_SESSION["username"]);

//    Guard
    if (isset($user)) {
        $isAdmin = $user->getIsAdmin();
    }
}

$bindings = [];
if ($isAdmin) {
    $bindings["admin_controls"] = html("components/shared/navbar-admin.html");
}

$NAVBAR = template("components/shared/navbar.html")->bind($bindings);