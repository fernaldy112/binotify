<?php

require_once(__DIR__."/TemplateEngine.php");

use Binotify\Template\TemplateEngine;

$SRC = __DIR__."/../";

function html($fileName): TemplateEngine
{
    return template($fileName)->bind([]);
}

function template($fileName): TemplateEngine
{
    global $SRC;

    $text = file_get_contents($SRC.$fileName);

    if ($text) {
        return new TemplateEngine($text);
    }

    return new TemplateEngine("");
}