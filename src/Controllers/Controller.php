<?php
namespace App\Controllers;

use App\SmartyTemplateEngine;

abstract class Controller {
    private $template_engine;

    public function __construct() {
        $this->template_engine = new SmartyTemplateEngine;
        $this->template_engine->configure();
    }

    public function view($template, $params) {
        $this->template_engine->displayView($template, $params);
    }
    
}