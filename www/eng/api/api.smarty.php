<?php
/**
 * User: Bargamut
 * Date: 23.02.14
 * Time: 7:35
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/eng/smarty/Smarty.class.php');

/**
 * Class JF_Smarty
 */
class JF_Smarty extends Smarty {
    private $doc_root;

    public function JF_Smarty() {
        // Конструктор класса.
        // Он автоматически вызывается при создании нового экземпляра.
        $this->doc_root = $_SERVER['DOCUMENT_ROOT'];

        parent::__construct();

        //** раскомментируйте следующую строку для отображения отладочной консоли
        //$smarty->debugging = true;

        $this->setTemplateDir($this->doc_root . '/eng/tpl/templates/');
        $this->setCompileDir($this->doc_root . '/eng/tpl/templates_c/');
        $this->setConfigDir($this->doc_root . '/eng/tpl/configs/');
        $this->setCacheDir($this->doc_root . '/eng/tpl/cache/');

        $this->caching = Smarty::CACHING_LIFETIME_CURRENT;

        $this->assign('app_name', 'Сайт КИР "Яро Пламя"');
    }
}