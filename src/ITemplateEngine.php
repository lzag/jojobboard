<?php
namespace App;

interface ITemplateEngine {
    // loads necessary configuration for the template engine
    public function configure();

    // displays the actual view
    public function displayView(string $template, array $vars = null);
}
