<?php
    require_once(__DIR__."/../src/Template/util.php");

    template("components/index.html")->render(
        [
            "message" => "Hello, world!",
        ]
    );
