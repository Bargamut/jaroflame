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
    /**
     * Регистрация пользователя
     * @param $subm - сабмит
     * @param $post - массив данных пользователя
     */
    function registration($subm, $post) {
        if (!empty($subm) && $this->registrationCorrect($post)) {
            $mail       = htmlspecialchars($post['rEmail']);
            $salt       = $this->generateRandString(250);
            $date_reg   = date('Y-m-d H:i:s');
            $fio        = array('firstname'     => $post['rName'],
                                'lastname'      => $post['rLName'],
                                'fathername'    => $post['rFName']);
            $password   = hash('sha512', hash('sha512', $post['rPass']) . $salt);
            $token      = hash('sha512', uniqid(rand(), 1)); // uid

            $db_query = 'CALL `create_user`("' . $mail . '", "' .
                $password . '", "' .
                $salt . '", "' .
                $date_reg . '", "' .
                $date_reg . '", "' .
                $token . '", "' .
                $fio['firstname'] . '", "' .
                $fio['lastname'] . '", "' .
                $fio['fathername'] . '")';

            if (mysql_query($db_query) or die(mysql_error())) {
                return $this->auth($subm, $post['rEmail'], $post['rPass']);
            }
        } else {
            // header('Location: http://' . $_SERVER['SERVER_NAME']);
        }
    }

    /**
     * Авторизация пользователя
     */
    function auth($subm, $mail, $pass) {
        // Если был сабмит авторизации и все данные введены верно
        if (!empty($subm) && $this->authCorrect($mail, $pass)) {
            $user = $this->getUserInfo($mail);
            $user['UNAME'] = $user['lastname'] . ' ' . $user['firstname'] . ' ' . $user['fathername'];

            // Устанавливаем coockie с данными пользователя
            setcookie("UID", $user['uid'], time() + 50000, '/');
            setcookie("email", $user['email'], time() + 50000, '/');

            // Меняем дату последнего посещения
            $mail = htmlspecialchars($mail);
            mysql_query('UPDATE users_site SET `date_lastvisit`="' . date('Y-m-d H:i:s') . '" WHERE `email`="' . $mail . '" LIMIT 1');
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
    function logout() {
        setcookie("UID", '', time() - 50000, '/');
        setcookie("email", '', time() - 50000, '/');

        session_destroy();

        header('Location: http://' . $_SERVER['SERVER_NAME']);
    }

    /**
     * Проверка на авторизованность пользователя
     * @return bool
     */
    function already_login() {
        return (isset($_SESSION['USER']['uid']) || (isset($_COOKIE['UID']) && isset($_COOKIE['email'])));
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
    function userinfo($mail) {
        return $this->getUserInfo($mail);
    }

    /**
     * Функция данных профиля
     * @param $nickname
     * @return array
     */
    function profile($nickname) {
        return $this->getProfileInfo($nickname);
    }

    /**
     * Функция данных профилей
     * @return array
     */
    function profiles() {
        return $this->getProfilesInfo();
    }

    /**
     * Функция проверки UID на соответствие необходимому
     * @param $uid          - пользовательский UID
     * @param $needleUID    - необходимый UID
     * @return bool
     */
    function isyoUID($uid, $needleUID) {
        return ($uid == $needleUID);
    }

    /**
     * Фукция обновления данных
     */
    function updProfile($tbl, $post, $uid) {
        $sets = array();

        foreach($post as $k => $v) { $sets[] = '`'.$k.'`="'.$v.'"'; }
        $sets = implode(',', $sets);

        $rez = mysql_query('SELECT `id` FROM users_site WHERE `uid`="'.$uid.'" LIMIT 1');
        @$result = mysql_fetch_assoc($rez);

        mysql_query('UPDATE '.$tbl.' SET '.$sets.' WHERE `id`="'.$result['id'].'" LIMIT 1') or die(mysql_error());
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
        $mail = htmlspecialchars($mail);

        if ($mail == "") $result .= 'Пустой E-Mail|';     // не пусто ли поле логина
        if ($pass == "") $result .= 'Пустой пароль';      // не пусто ли поле пароля
        // не меньше ли 5 символов длина пароля
        if (strlen($pass) < 5 && empty($pass)) $result .= 'pass < 5|';
        $rez = mysql_query('SELECT `password`, `salt` FROM users_site WHERE `email`="' . $mail . '" AND `block`="0" LIMIT 1');
        // проверка на существование в БД такого же логина
        if (@mysql_num_rows($rez) == 0) $result .= 'Такого пользователя нет';
        while ($user = mysql_fetch_array($rez, MYSQL_ASSOC)) {
            if (hash('sha512', hash('sha512', $pass).$user['salt']) != $user['password']) $result .= 'Невереная пара Логин/Пароль';
        }
        return ($result == ''); // если выполнение функции дошло до этого места, возвращаем true
    }

    /**
     * Функция проверки корректности введённых данных регистрации
     * @return bool
     */
    private function registrationCorrect() {
        $result = '';

        if ($_POST['rEmail'] == "") $result = 'email|';                       // не пусто ли поле логина
        if ($_POST['rPass'] == "") $result = 'pass|';                        // не пусто ли поле пароля
        if ($_POST['rPass2'] == "") $result = 'pass2|';                       // не пусто ли поле подтверждения пароля
        if ($_POST['rLic'] != "ok") $result = 'lic|';                       // приняты ли правила
        if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $_POST['rEmail'])) $result = 'preg_email|'; // соответствует ли поле e-mail регулярному выражению
//    if (!preg_match('/^([а-яА-a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'   , $_POST['rLName'])) return false;  // соответствует ли Фамилия регулярному выражению
//    if (!preg_match('/^([а-яА-a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'   , $_POST['rName'])) return false;   // соответствует ли Имя регулярному выражению
//    if (!preg_match('/^([а-яА-Яa-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'  , $_POST['rFName'])) return false;  // соответствует ли Отчество регулярному выражению
        if (strlen($_POST['rPass']) < 5 && empty($_POST['rPass'])) $result = 'pass < 5|';               // не меньше ли 5 символов длина пароля
        if (hash('512', $_POST['rPass']) != hash('sha512', $_POST['rPass2'])) $result = 'not_confirm_pass|';    // равен ли пароль его подтверждению
        $mail = htmlspecialchars($_POST['rMail']);
        $rez = mysql_query('SELECT * FROM users_site WHERE `email`="'.$mail.'" limit 1');
        if (@mysql_num_rows($rez) != 0) $result = 'already_exist|';                   // проверка на существование в БД такого же логина

        echo $result;
        return ($result == '');                                                    // если выполнение функции дошло до этого места, возвращаем true
    }

    /**
     * Функция запроса данных пользователя
     */
    private function getUserInfo($mail) {
        $mail   = htmlspecialchars($mail);
        $query  = 'SELECT'.
            ' us.`email`, us.`nickname`, us.`uid`, us.`date_reg`, us.`date_lastvisit`, us.`level`, us.`block`, us.`block_reason`,'.
            ' uc.`rank`, uc.`borndate`, uc.`wards`, uc.`fests`, uc.`awards`,'.
            ' ub.`firstname`, ub.`lastname`, ub.`fathername`,'.
            ' ul.`rights`, ul.`lvlname` ' .
            'FROM users_site us ' .
            'LEFT OUTER JOIN users_club uc ' .
            'ON uc.`id` = us.`id`' .
            'LEFT OUTER JOIN users_bio ub ' .
            'ON ub.`id` = us.`id`' .
            'LEFT OUTER JOIN users_lvl ul ' .
            'ON ul.`lvl` = us.`level`' .
            'WHERE us.`email`="' . $mail . '" ' .
            'LIMIT 1';

        $rez = mysql_query($query) or die(mysql_error());
        @$user = mysql_fetch_assoc($rez);
        return $user;
    }

    /**
     * Функция запроса данных профиля, кроме гостевого
     */
    private function getProfileInfo($nickname) {
        $nickname = htmlspecialchars($nickname);
        $query = 'SELECT'.
            ' us.`email`, us.`uid`, us.`block`, us.`block_reason`,'.
            ' uc.`rank`, uc.`borndate`, uc.`wards`, uc.`fests`, uc.`awards`,'.
            ' ub.`firstname`, ub.`lastname`, ub.`fathername`, ub.`birthday`,'.
            ' ud.`p_seria`, ud.`p_number`, ud.`p_issuance`, ud.`p_date`, ud.`studies`, ud.`work`, ud.`medicine`, ud.`reg_address`,'.
            ' ul.`lvlname`'.
            ' FROM users_site us'.
            ' LEFT OUTER JOIN users_club uc ON uc.`id` = us.`id`'.
            ' LEFT OUTER JOIN users_bio ub ON ub.`id` = us.`id`'.
            ' LEFT OUTER JOIN users_doc ud ON ud.`id` = us.`id`'.
            ' LEFT OUTER JOIN users_lvl ul ON ul.`lvl` = us.`level`'.
            ' WHERE us.`nickname`="' . $nickname . '" AND us.`level` != "G"'.
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
        $query  = 'SELECT us.`nickname`, us.`block`, ub.`firstname`, ub.`lastname`, ub.`fathername` FROM users_site us LEFT OUTER JOIN users_bio ub ON ub.`id` = us.`id` WHERE us.`level`!="G"';

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