<?php
/**
 * Class JF_Database - класс работы с базой данных
 */
class JF_Database {
    public $dbhost;  // сервер БД
    public $dbname;    // имя БД
    public $dbuser;  // имя пользователя БД
    public $dbpass;  // пароль пользователя БД
    public $index;     // индекс соединения с БД

    /**
     * Подключаемся к БД
     *
     * @param $dbhost - сервер БД
     * @param $dbuser - имя пользователя БД
     * @param $dbpass - пароль пользователя БД
     * @return bool     - при успешном выполнении возвращает true
     */
    function __construct() {
        if (func_num_args() == 3) {
            $this->dbhost   = func_get_arg(0);
            $this->dbuser   = func_get_arg(1);
            $this->dbpass   = func_get_arg(2);
            $this->index    = mysql_connect($this->dbhost, $this->dbuser, $this->dbpass) or die('Ошибка подключения к базе данных!');
        }
    }

    /**
     * Закрываем соединение с БД
     */
    public function close() { mysql_close($this->index); return true; }

    /**
     * Выбираем базу данных
     *
     * @param $database - имя БД
     * @return bool     - при успешном выполнении возвращает true
     */
    public function select_db($dbname, $charset = 'utf8') {
        $this->dbname = $dbname;
        mysql_select_db($this->dbname, $this->index) or die('Не удалось найти нужную базу данных!');

        mysql_set_charset($charset, $this->index);

        return true;
    }

    /**
     * Делаем запрос к БД
     *
     * db_query('SQL-запрос', [значение 1, значение 2, ...])
     *
     * %s[:in|:like] - строковое значение
     * %d[:in|:like] - целочисленное значение
     *
     * @return array|bool|string
     */
    public function query() {
        $args = func_get_args();                                // Забираем переданные аргументы

        if (func_num_args() >= 1) {                             // Если есть хоть один аргумент
            $q = array_shift($args);                            // Вытаскиваем строку запроса

            if (count($args) == 1) { $p = array_shift($args); } // Проверяем наличие подставляемых параметров
            // и вытаскиваем, если нашли

            if (isset($p)) {                                    // Если есть подставляемые параметры
                if (!is_array($p)) { $p = (array)$p; }
                if (count($p) > 0) {
                    $this->quoteSet($q);                        // Квотируем запрос
                    $this->strFormat($p);                       // Форматируем возможнве стррочные значения
                    $q = vsprintf($q, $p);                      // Заменяем плейсхолдеры на значения
                }
            }

            if (!$q) { return false; }

            $r = mysql_query($q) or die(mysql_error());         // Делаем запрос к БД
            $r = $this->make_result($r, $q);                    // Возвращаем результат запроса
        } else {
            $r = 'Нет нужных данных!';
        }

        return $r;
    }

    /**
     * Фкнкция квотирования
     *
     * @param $q    - ссылка на строку запроса
     * @return bool - при успешном выполнении возвращает true
     */
    private function quoteSet(&$q) { $q = preg_replace_callback('/(%?)(%[sd])(:\w+)?(%?)/i', "self::placeHolder", $q); return true; }

    /**
     * Обрамляем в кавычки, если нужно
     *
     * @param $m            - массив совпадений в RegExp выражении
     * @return bool|string  - при успешном выполнении возвращает отредактированную строку запроса
     */
    private function placeHolder($m) {
        switch ($m[2]) {
            case '%s': return ($m[3] == ':in')      ? $m[1].$m[1].$m[2].$m[4].$m[4] : "'" . $m[1].$m[1].$m[2].$m[4].$m[4] . "'"; break;
            case '%d': return ($m[3] == ':like')    ? "'" . $m[1].$m[1].$m[2].$m[4].$m[4] . "'" : $m[1].$m[1].$m[2].$m[4].$m[4]; break;
            default: return false; break;
        }
    }

    /**
     * Форматирования значений (для строчных)
     *
     * @param $p      - ссылка на значение/массив значений
     * @return bool   - при успешном выполнении возвращает true
     */
    private function strFormat(&$p) {
        if (!is_array($p)) { $p = array($p); }
        foreach ($p as $k => $v) { $p[$k] = htmlspecialchars(mysql_real_escape_string($v)); }
        return true;
    }

    /**
     * Функция компоновки результата запроса
     *
     * @param $r        - результат запроса
     * @param $q        - запрос
     * @return array    - возвращаемый массив
     */
    private function make_result($r, $q) {
        $result = array();

        if (preg_match('/^SELECT/i', $q)) {
            if (mysql_num_rows($r) == 1) {
                $result = mysql_fetch_assoc($r);
            } else if (mysql_num_rows($r) > 1) {
                while ($row = mysql_fetch_assoc($r)) {
                    $result[] = $row;
                }
            }
        }

        return $result;
    }

    /**
     * Бекап БД
     */
    public function makeDump() {
        $backupFile = $this->dbname . '.' . date("Y-m-d-H-i-s") . '.gz';

        $command = "mysqldump --opt -h $this->dbhost -u $this->dbuser -p$this->dbpass $this->dbname --add-drop-table --default-character-set=utf8 | gzip > $backupFile";
        system($command);
    }

    /**
     * Восстанавливаем БД из бекапа
     */
    public function takeDump($date) {
        $filename = $this->dbname.$date.'gz';

        system("gunzip $filename -c > backupnow.sql");
        system("mysql -h $this->dbhost -u $this->dbuser -p$this->dbpass $this->dbname < backupnow.sql");
        system("rm backupnow.sql");

        return true;
    }
}