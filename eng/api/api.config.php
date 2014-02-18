<?php
/**
 * Class JF_Config
 * Класс конфига типа Singleton
 *
 * User: Bargamut
 * Date: 15.02.14
 * Time: 21:54
 *
 * @name JF_Config
 * @author Paul Petrov (bargamut [at] mail [dot] ru)
 */
class JF_Config {
    protected static $_instance;
    private $settings;

    /**
     * При создании объекта парсим все доступные конфиги
     */
    private function __construct() {
        // TODO: подумать над подключением неизвестного числа конфигов
        // TODO: сделать установщик движка, с первоначальной генерацией Конфига
        $this->settings = parse_ini_file("./eng/conf/core.ini", true);
    }

    /**
     * Создаём и возвращаем объект класса, если его ещё нет.
     * Если объект уже есть, то возвращаем его.
     *
     * @return JF_Config
     */
    public static function getInstance() {
        if (null === self::$_instance) { self::$_instance = new self(); }

        return self::$_instance;
    }

    /**
     * Ищем запрашиваемое свойство в конфиге и возвращаем его.
     * Если не находим, то возвращаем NULL.
     *
     * @return array|null
     */
    private function search() {
        $result = null;

        if (func_num_args() > 0) { $option = func_get_arg(0); } else { return $result; }

        if (func_num_args() == 1 && $option == '*') { $result = $this->settings; }
        elseif (func_num_args() == 2) {
            $section = func_get_arg(1);

            if (array_key_exists($section, $this->settings)) {
                if ($option == '*') { $result = $this->settings[$section]; }
                else                { $result = array_key_exists($option, $this->settings[$section]) ? $this->settings[$section][$option] : null; }
            }
        }

        return $result;
    }

    /**
     * Запрос значений конфигов
     *
     * Варианты запроса:
     * $CONF->get('*');                                                 // Взять все значения
     * $CONF->get('*', $section);                                       // Взять все значения из секции
     * $CONF->get('one', $section);                                     // Взять одно значение из секции
     * $CONF->get('*', array('section', 'section2'));                   // Взять все значения из нескольких секций
     * $CONF->get('one', array('section', 'section2'));                 // Взять одно значение из нескольких секций
     * $CONF->get(array('one', 'two'), $section);                       // Взять один набор значений из секции
     * $CONF->get(array('one', 'two'), array('section', 'section2'));   // Взять один набор значений из нескольких секций
     * $CONF->get(array('section'  => array('one', 'two'),              // Взять несколько значений из нескольких секций
     *                  'section2' => 'three',
     *                  'section3' => '*'));
     *
     * @return array|null
     */
    public function get() {
        $result = null;

        if (func_num_args() > 0) { $options = func_get_arg(0); } else { return $result; }

        if (func_num_args() == 1) {
            if (is_string($options))    { $result = self::search($options); }
            elseif (is_array($options)) {
                foreach ($options as $section => $option) {
                    if (is_array($option))  { $result[$section]             = $this->get($option, $section); }
                    else {
                        if ($option == '*') { $result[$section]             = $this->get($option, $section); }
                        else                { $result[$section][$option]    = $this->get($option, $section); }
                    }
                }
            }
        } elseif (func_num_args() == 2) {
            $sections = func_get_arg(1);

            if (is_array($options)) {
                if (is_string($sections)) {
                    foreach ($options as $option)       { $result[$option]              = self::search($option, $sections); }
                } elseif (is_array($sections)) {
                    foreach ($sections as $section) {
                        foreach ($options as $option)   { $result[$section][$option]    = self::search($option, $section); }
                    }
                }
            } elseif (is_string($options)) {
                if (is_string($sections))       { $result                       = self::search($options, $sections); }
                elseif (is_array($sections)) {
                    foreach ($sections as $section) {
                        if ($options == '*')    { $result[$section]             = self::search($options, $section); }
                        else                    { $result[$section][$options]   = self::search($options, $section); }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Редактируем свойства конфига
     *
     * @param $options
     */
    public function import($options) {
        $this->sanitize($options);

        foreach ($options as $section => $opts) {
            // TODO: подумать над добавлением, если нет секции
            // TODO: подумать над неприкосновенностью опредедённых настроек конфига
            if (!array_key_exists($section, $this->settings)) { continue; }

            foreach ($opts as $k => $v) {
                $this->settings[$section][$k] = $v;
            }
        }
    }

    /**
     * Чистим данные под определённый формат
     *
     * @param $options
     *
     * @return mixed
     */
    private function sanitize(&$options) {
        // TODO: подумать над фильтрацией данных
        return $options;
    }

    private function __clone() {}
    private function __wakeup() {}
}