<?php

namespace Binotify\Template;

class TemplateEngine
{
    private string $template;
    private array $vars;
    private bool $bound;

    function __construct($template)
    {
        $this->template = $template;
        $this->vars = [];
        $this->bound = false;
    }

    function render($vars = []): void
    {
        if (!$this->bound) {
            $this->vars = $vars;
        }
        echo preg_replace_callback("/\{\{\s+(\w*)\s+}}/", array($this, "_getReplacement"), $this->template);
    }

    function _renderAsString(): array|string|null
    {
        return preg_replace_callback("/\{\{\s+(\w*)\s+}}/", array($this, "_getReplacement"), $this->template);
    }

    function bind($vars): static
    {
        $this->vars = $vars;
        $this->bound = true;
        return $this;
    }

    function _getReplacement($match) {

        $name = $match[1];

        if (array_key_exists($name, $this->vars)) {
            $replacement = $this->vars[$name];
            if ($replacement instanceof TemplateEngine) {
                return $replacement->_renderAsString();
            }
            return $replacement;
        }

        return "";
    }
}