<?php
    require_once(__DIR__."/../src/Template/util.php");

    template("components/index.html")->render(
        [
            "app" => template("components/app.html")->bind([
                "greeting" => "Hello, ".$_SESSION["username"]."!"
            ]),
        ]
    );
