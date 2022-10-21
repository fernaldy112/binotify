<?php

require_once(__DIR__."/../src/Template/util.php");

template("components/listen.html")->bind([
    "song" => "Test",
    "navbar" => html("components/shared/navbar.html"),
    "main" => template("components/listen/main.html")->bind([
        "header" => html("components/shared/header.html")
    ])
])->render();
