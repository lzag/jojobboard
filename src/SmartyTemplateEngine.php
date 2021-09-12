<?php
namespace App;

use Smarty;
require_once( APP_DIR . '/includes/user.php' );
use User;

class SmartyTemplateEngine implements ITemplateEngine {

    private $smarty;

    public function __construct() {
        $this->smarty = new Smarty;
    }
    public function configure() {
        $this->smarty->setTemplateDir(APP_DIR . '/views/');
        $this->smarty->setCompileDir(APP_DIR . '/views_c/');
        // $this->smarty->setConfigDir(APP_DIR . '/includes/smarty/');
        // $this->smarty->setCacheDir(APP_DIR . '/cache/');
    }

    public function displayView(string $template, array $vars = null) {
        $template_path = implode('/', explode('.', $template));
        if (file_exists($this->smarty->getTemplateDir()[0] . $template_path . '.tpl')) {
            $this->smarty->assign($vars);
            $this->smarty->display($template_path . '.tpl');
            // $this->smarty->display('userprofile.tpl', ['user' => new User]);
        } else {
            require_once APP_DIR . '/' . $template . '.php';        }
    }
}
