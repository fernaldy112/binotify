<?php

    require_once(__DIR__."/../src/Template/util.php");
    require_once(__DIR__."/../src/Store/DataStore.php");

    template("components/authentication.html")->render(
        [
            "title" => "Sign up - Binotify",
            "form" => template("components/authentication/register.html")->bind([
                "invalidLogin" => "",
            ]),
        ]
    );
