<?php
namespace App;

use SmartyBC;

class SmartyTemplateEngine implements ITemplateEngine {

    private $smarty;

    public function __construct() {
        $this->smarty = new SmartyBC;
    }
    public function configure() {
        $this->smarty->setTemplateDir(APP_DIR . '/views/');
        $this->smarty->setCompileDir(APP_DIR . '/views_c/');
        // $this->smarty->setConfigDir(APP_DIR . '/includes/smarty/');
        // $this->smarty->setCacheDir(APP_DIR . '/cache/');
    }

    public function displayView(string $template, array $vars = null) {
        if (file_exists($this->smarty->getTemplateDir()[0] . $template . '.tpl')) {
            $this->smarty->assign($vars);
            $this->smarty->display($template . '.tpl');
        } else {
            require_once APP_DIR . '/' . $template . '.php';        }
    }
}
?>
