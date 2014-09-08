<?php
/**
 * User: Bargamut
 * Date: 15.07.12
 * Time: 22:46
 */

// TODO: преобразование дат
/**
 * Class JF_Users
 */
class JF_Users {
    private $db_instance;

    public function __construct() {
        if (func_num_args() == 1) { $this->db_instance = func_get_arg(0); }
    }

    /**
     * Регистрация пользователя
     * @param $subm - сабмит
     * @param $post - массив данных пользователя
     */
    public function registration($subm, $post) {
        // Если был сабмит и поля формы регистрации заполнены корректно
        if (!empty($subm) && $this->registrationCorrect($post)) {
            $salt       = $this->generateRandString(250);                               // Генерим "соль"
            $date_reg   = date('Y-m-d H:i:s');                                          // Дата регистрации
            $password   = hash('sha512', hash('sha512', $post['reg_pass']) . $salt);    // Шифруем пароль
            $token      = hash('sha512', uniqid(rand(), 1));                            // UID

            $user_created = $this->db_instance->query(
                "INSERT INTO users_site (nickname, email, password, salt, date_reg, uid) VALUE (%s, %s, %s, %s, %s, %s)",
                array(
                    $post['reg_nickname'],
                    $post['reg_email'],
                    $password,
                    $salt,
                    $date_reg,
                    $token
                )
            );

            // Если запись в БД создана, логиним
            if ($user_created) {
                //TODO: заменить автологин на подтверждение регистрации - отсылка контрольного кода на e-mail
                $_SESSION['USER'] = $this->auth($subm, $post['reg_email'], $post['reg_pass']);
            }
        } else {
            // header('Location: http://' . $_SERVER['SERVER_NAME']);
        }
    }

    /**
     * Авторизация пользователя
     */
    public function auth($subm, $mail, $pass) {
        // Если был сабмит авторизации и все данные введены верно
        if (!empty($subm) && $this->authCorrect($mail, $pass)) {
            $user = $this->getUserInfo($mail);
            $user['UNAME'] = $user['lastname'] . ' ' . $user['firstname'] . ' ' . $user['patronymic'];

            // Устанавливаем coockie с данными пользователя
            setcookie("UID", $user['uid'], time() + 50000, '/');
            setcookie("email", $user['email'], time() + 50000, '/');

            // Меняем дату последнего посещения
            $this->db_instance->query(
                    'UPDATE users_site SET date_lastvisit=%s WHERE email=%s LIMIT 1',
                    array(date('Y-m-d H:i:s'), $mail)
            );

            // И перенаправляем на главную
            header('Location: http://' . $_SERVER['SERVER_NAME']);
        } else {
            // Перенаправляем на главную
            // header('Location: http://' . $_SERVER['SERVER_NAME']);
        }

        return $user;
    }

    /**
     * Выход
     */
    public function logout() {
        setcookie("UID", '', time() - 50000, '/');
        setcookie("email", '', time() - 50000, '/');

        session_destroy();

        header('Location: http://' . $_SERVER['SERVER_NAME']);
    }

    /**
     * Проверка на авторизованность пользователя
     * @return bool
     */
    public function already_login() {
        return (isset($_SESSION['USER']['uid']) || (isset($_COOKIE['UID']) && isset($_COOKIE['email'])));
    }

    /**
     * Функция проверки наличия аккаунта в БД по определённой паре "поле -> значение"
     *
     * @param $field - поле
     * @param $value - значение
     *
     * @return bool
     */
    private function isAlreadyRegisteredBy($field, $value) {
        $rez = $this->db_instance->query('SELECT * FROM users_site WHERE ' . $field . '=%s limit 1', $value);

        // проверка на существование в БД такого же логина
        return (count($rez) != 0);
    }

    /**
     * Функция проверки полномочий пользователя
     * @param $lvl
     * @param $userlvl
     * @return bool
     */
    function check_rights($needed, $current) {
        $res = false;

        $current    = $this->parseRights($current);
        $needed     = $this->parseRights($needed);

        foreach($needed as $nk => $nv) {
            foreach($current as $ck => $cv) {
                if ($nk == $ck && preg_match('/[' . $nv . ']/', $cv)) { $res = true; }
            }
        }

        return $res;
    }

    /**
     * Функция данных пользователя
     * @param $mail
     * @return array
     */
    function userinfo($mail) { return $this->getUserInfo($mail); }

    /**
     * Функция данных профиля
     * @param $nickname
     * @return array
     */
    function profile($nickname) { return $this->getProfileInfo($nickname); }

    /**
     * Функция данных профилей
     * @return array
     */
    function profiles() { return $this->getProfilesInfo(); }

    /**
     * Функция проверки UID на соответствие необходимому
     * @param $uid          - пользовательский UID
     * @param $needleUID    - необходимый UID
     * @return bool
     */
    function isyoUID($uid, $needleUID) { return ($uid == $needleUID); }

    /**
     * Фукция обновления данных
     */
    function updProfile($tbl, $post, $uid) {
        $sets = array();

        foreach($post as $k => $v) { $sets[] = '`' . $k . '`="' . $v . '"'; }
        $sets = implode(',', $sets);

        $rez = mysql_query('SELECT `id` FROM users_site WHERE `uid`="' . $uid . '" LIMIT 1');
        @$result = mysql_fetch_assoc($rez);

        mysql_query('UPDATE ' . $tbl . ' SET ' . $sets . ' WHERE `id`="' . $result['id'] . '" LIMIT 1') or die(mysql_error());
        return true;
    }

    /**
     * Функция проверки пароля
     * @param $mail
     * @param $pass
     * @return bool
     */
    function check_pass($mail, $pass) {
        $result = '';
        // не меньше ли 5 символов длина пароля
        if (strlen($pass) >= 5) {
            $rez = mysql_query('SELECT `password`, `salt` FROM users_site WHERE `email`="' . $mail . '" AND `block`="0" LIMIT 1');
            while ($user = mysql_fetch_assoc($rez)) {
                if (hash('sha512', hash('sha512', $pass).$user['salt']) != $user['password']) {
                    $result .= 'Невереная пара Логин/Пароль';
                }
            }
        }
        return ($result == '');
    }

    /**
     * Функция проверки корректности введённых данных авторизации
     * @return bool
     */
    private function authCorrect($mail, $pass) {
        $result = '';

        if ($mail == "") { $result .= 'Пустой E-Mail<br />'; }   // не пусто ли поле логина
        if ($pass == "") { $result .= 'Пустой пароль<br />'; }    // не пусто ли поле пароля

        // не меньше ли 5 символов длина пароля
        if (strlen($pass) < 5 && empty($pass)) { $result .= 'Пароль меньше 5 символов<br />'; }

        $rez = $this->db_instance->query('SELECT password, salt FROM users_site WHERE email=%s AND block="0" LIMIT 1', $mail);

        // проверка на существование в БД такого же логина
        if (count($rez) == 0) { $result .= 'Такого пользователя нет<br />'; }

        foreach ($rez as $k => $v) {
            if (hash('sha512', hash('sha512', $pass) . $rez['salt']) != $rez['password']) { $result .= 'Невереная пара Логин/Пароль<br />'; }
        }

        return ($result == ''); // если выполнение функции дошло до этого места, возвращаем true
    }

    /**
     * Функция проверки корректности введённых данных регистрации
     * @param $post - ссылка на массив регистрационных данных
     *
     * @return bool
     */
    private function registrationCorrect(&$post) {
        $result = '';

        if ($post['reg_nickname'] == "")    { $result .= 'Пустое поле логина<br />'; }               // не пусто ли поле логина
        if ($post['reg_email'] == "")       { $result .= 'Пустое поле e-mail<br />'; }               // не пусто ли поле логина
        if ($post['reg_pass'] == "")        { $result .= 'Пустое поле пароля<br />'; }               // не пусто ли поле пароля
        if ($post['reg_pass2'] == "")       { $result .= 'Пустое поле подтверждения пароля<br />'; } // не пусто ли поле подтверждения пароля
        if ($post['reg_accept'] != "ok")    { $result .= 'Не приняты условия регистрации<br />'; }   // приняты ли правила

        // соответствует ли поле e-mail регулярному выражению
        if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $post['reg_email']))   { $result .= 'Некорректный e-mail<br />'; }
        // соответствует ли Фамилия регулярному выражению
        if (!preg_match('/^([а-яА-Яa-zA-Z0-9\w-_.\\/ \'"]+)$/is', $post['reg_nickname']))   { $result .= 'Некорректный логин<br />'; }

        if (strlen($post['reg_pass']) < 5 && empty($post['reg_pass']))                  { $result .= 'Длина пароля менее 5 символов<br />'; }  // не меньше ли 5 символов длина пароля
        if (hash('sha512', $post['reg_pass']) != hash('sha512', $post['reg_pass2']))    { $result .= 'Пароли не совпадают<br />'; }            // равен ли пароль его подтверждению

        if ($result == '') {
            if ($this->isAlreadyRegisteredBy('email', $post['reg_email']))          { $result .= 'Аккаунт с таким e-mail уже зарегистрирован!<br />'; }
            if ($this->isAlreadyRegisteredBy('nickname', $post['reg_nickname']))    { $result .= 'Аккаунт с таким логином уже зарегистрирован!<br />'; }
        }

        echo $result;
        return ($result == ''); // если выполнение функции дошло до этого места, возвращаем true
    }

    /**
     * Функция запроса данных пользователя
     */
    private function getUserInfo($mail) {
        $user = $this->db_instance->query(
                'SELECT us.`email`, us.`nickname`, us.`uid`, us.`date_reg`, us.`date_lastvisit`, us.`block`, us.`block_reason`,
                    uc.`rank`, uc.`borndate`,
                    ub.`firstname`, ub.`lastname`, ub.`patronymic`
                FROM users_site us
                LEFT OUTER JOIN users_club uc ON uc.`id` = us.`id`
                LEFT OUTER JOIN users_bio ub ON ub.`id` = us.`id`
                WHERE us.`email`=%s LIMIT 1',
            $mail);

        return $user;
    }

    /**
     * Функция запроса данных профиля, кроме гостевого
     */
    private function getProfileInfo($nickname) {
        $nickname = htmlspecialchars($nickname);
        $query = 'SELECT'.
            ' us.`email`, us.`uid`, us.`block`, us.`block_reason`,'.
            ' uc.`rank`,'.
            ' ub.`firstname`, ub.`lastname`, ub.`patronymic`, ub.`birthday`,'.
            ' ud.`p_seria`, ud.`p_number`, ud.`p_issuance`, ud.`p_date`, ud.`studies`, ud.`work`, ud.`medicine`, ud.`reg_address`'.
            ' FROM users_site us'.
            ' LEFT OUTER JOIN users_club uc ON uc.`id` = us.`id`'.
            ' LEFT OUTER JOIN users_bio ub ON ub.`id` = us.`id`'.
            ' LEFT OUTER JOIN users_doc ud ON ud.`id` = us.`id`'.
            ' WHERE us.`nickname`="' . $nickname . '"'.
            ' LIMIT 1';

        $rez = mysql_query($query) or die(mysql_error());
        @$profile = mysql_fetch_assoc($rez);
        return $profile;
    }

    /**
     * Функция выбора профилей всех пользовтелей
     * @return array
     */
    private function getProfilesInfo() {
        $query  = 'SELECT us.`nickname`, us.`block`, ub.`firstname`, ub.`lastname`, ub.`patronymic` FROM users_site us LEFT OUTER JOIN users_bio ub ON ub.`id` = us.`id`';

        $rez = mysql_query($query) or die(mysql_error());
        $i = 0;
        while(@$p = mysql_fetch_assoc($rez)) {
            $profile[$i++] = $p;
        };
        return $profile;
    }

    /**
     * Функция разбора полномочий
     */
    private function parseRights($rights) {
        $r = array();

        $arr = explode(', ', $rights);
        foreach($arr as $k => $val) {
            $a = explode(':', $val);
            $r[$a[0]] = $a[1];
        }
        return $r;
    }

    /**
     * Функция генерации случайной строки
     * @param int $length
     * @return string
     */
    function generateRandString($length = 35){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789._:;';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, mt_rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}