<?php

namespace Binotify\Template;

class TemplateEngine
{
    private string $template;
    private array $vars;
    private bool $bound;

    // Flags
    private bool $multiple;

    // Intermediates
    private array $replacements;

    function __construct($template)
    {
        $this->template = $template;
        $this->vars = [];
        $this->bound = false;
        $this->multiple = false;
        $this->replacements = [];
    }

    function render($vars = []): void
    {
        if (!$this->bound) {
            $this->vars = $vars;
        }
        echo $this->_renderAsString();
    }

    function _renderAsString(): array|string|null
    {
        if ($this->multiple) {
            return $this->_renderAsStringMultiple();
        }

        return $this->_renderAsStringSingle();
    }

    function _renderAsStringSingle(): array|string|null
    {
        $this->replacements = $this->vars;
        return preg_replace_callback("/\{\{\s+(\w*)\s+}}/", array($this, "_getReplacement"), $this->template);
    }

    function _renderAsStringMultiple(): string
    {
        $components = [];

        foreach ($this->vars as $vars) {
            $this->replacements = $vars;
            $components[] = preg_replace_callback("/\{\{\s+(\w*)\s+}}/", array($this, "_getReplacement"), $this->template);
        }

        return join("\n", $components);
    }

    function bind($vars): static
    {
        $this->vars = $vars;
        $this->bound = true;
        return $this;
    }

    function bindEach($arr): static
    {
        $this->multiple = true;
        return $this->bind($arr);
    }

    function _getReplacement($match) {

        $name = $match[1];

        if ($name === "css") {
            $replacement = "";

            global $CSS;

            foreach ($CSS as $path) {
                $replacement = $replacement."\n<link rel=\"stylesheet\" href=\"$path\" />";
            }
            return $replacement;
        }

        if ($name === "js") {
            $replacement = "";

            global $JS;
            global $JS_DEFER;

            foreach ($JS as $path) {
                $replacement = $replacement."\n<script src=\"$path\"></script>";
            }

            foreach ($JS_DEFER as $path) {
                $replacement = $replacement."\n<script src=\"$path\" defer></script>";
            }

            return $replacement;
        }

        if (array_key_exists($name, $this->replacements)) {
            $replacement = $this->replacements[$name];
            if ($replacement instanceof TemplateEngine) {
                return $replacement->_renderAsString();
            }
            return $replacement;
        }

        return "";
    }
}