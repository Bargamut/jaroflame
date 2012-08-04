<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 04.08.12
 * Time: 17:25
 */

class Site{
    public $err = array();
    /**
     * Функция проверки и экранирования значения переменной
     * @param $var - переменная
     * @param $reg - регулярное выражение
     * @param $vname - соответствующее имя в форме
     * @return string
     */
    function var2send_pm($var, $reg, $vname) {
        if (!empty($var)) {
            preg_match($reg, $var) ?
                $var = htmlspecialchars($var)
            :   $this->err['send'][] = $vname;
        }
        return $var;
    }

    /**
     * Функция проверки и экранирования значения переменной
     * @param $var - переменная
     * @return string
     */
    function var2send($var){
        (!empty($var)) ?
            $var = htmlspecialchars($var)
        :   null;
        return $var;
    }
}