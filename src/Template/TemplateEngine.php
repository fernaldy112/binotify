<?php

namespace Binotify\Template;

class TemplateEngine
{
    private $template;
    private $vars;

    function __construct($template)
    {
        $this->template = $template;
    }

    function render($vars) {
        $this->vars = $vars;
        echo preg_replace_callback("/\{\{\s+(\w*)\s+}}/", array($this, "_get_replacement"), $this->template);
    }

    function _get_replacement($match) {

        $name = $match[1];

        if (array_key_exists($name, $this->vars)) {
            return $this->vars[$name];
        } else if (isset($$name)) {
            return $$name;
        } else {
            return "";
        }
    }
}