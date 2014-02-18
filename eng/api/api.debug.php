<?php
/**
 * Class JF_Debug
 * Класс отладки
 *
 * User: Bargamut
 * Date: 16.02.14
 * Time: 18:32
 *
 * @name JF_Debug
 * @author Paul Petrov (bargamut [at] mail [dot] ru)
 */
class JF_Debug {
    public function __construct() {}

    /**
    * Выводим значение переменной или массива в отладочном блоке
    *
    * @param $expression
    * @param $header
    *
    * @return string
    */
    public function dump($expression, $header) {
        $result = '<div class="debug"><h2>' . '(' . gettype($expression) . ') ' . $header . '</h2>Длина: ' . count($expression) . ' <br /><pre class="dump">';

        if (is_array($expression))      { $result .= print_r($expression, true); }
        elseif (is_string($expression)) { $result .= $expression; }

        $result .= '</pre></div>';

        return $result;
    }
}