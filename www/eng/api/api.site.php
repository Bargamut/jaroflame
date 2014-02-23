<?php
/**
 * Class JF_Site
 *
 * User: Bargamut
 * Date: 04.08.12
 * Time: 17:25
 */
class JF_Site {
    public $err = array();

    public function __construct() {}

    /**
     * Проверка и экранирование значения переменной
     *
     * @param $var - переменная
     * @param $reg - регулярное выражение
     * @param $vname - соответствующее имя в форме
     * @return string
     */
    public function var2send_pm($var, $reg, $vname) {
        if (!empty($var)) { preg_match($reg, $var) ? $var = htmlspecialchars($var) : $this->err['send'][] = $vname; }

        return $var;
    }

    /**
     * Проверка и экранирование значения переменной
     *
     * @param $var - переменная
     * @return string
     */
    public function var2send($var) { (!empty($var)) ? $var = htmlspecialchars($var) : null; return $var; }
}