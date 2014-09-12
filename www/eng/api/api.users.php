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
        if (!empty($subm) && empty($post['faked_email']) && $this->registrationCorrect($post)) {
            $salt       = $this->generateRandString(250);                               // Генерим "соль"
            $date_reg   = date('Y-m-d H:i:s');                                          // Дата регистрации
            $date_exp   = date('Y-m-d H:i:s', strtotime('+7 days'));                    // Дата автоудаления неподтверждённого аккаунта - 7 дней
            $password   = hash('sha512', hash('sha512', $post['reg_pass']) . $salt);    // Шифруем пароль
            $token      = hash('sha512', uniqid(rand(), 1));                            // UID
            $token_act  = hash('sha512', uniqid(rand(), 1));                            // Код активации

            $user_created = $this->db_instance->query(
                "INSERT INTO users_site (nickname, email, password, salt, date_reg, date_expires, uid, activate_hash) VALUE (%s, %s, %s, %s, %s, %s, %s, %s)",
                array(
                    $post['reg_nickname'],
                    $post['reg_email'],
                    $password,
                    $salt,
                    $date_reg,
                    $date_exp,
                    $token,
                    $token_act
                )
            );

            // Если запись в БД создана, логиним
            if ($user_created) {
                // TODO: Добавить напоминание за 3 и за 1 день, если ещё не активировано.
                self::activationSend($post['reg_email']);

                //$_SESSION['USER'] = $this->auth($subm, $post['reg_email'], $post['reg_pass']);

                // Перенаправляем на главную
                //header('Location: http://' . $_SERVER['SERVER_NAME']);
            }
        }
    }

    /**
     * Авторизация пользователя
     *
     * @param $subm - был ли сабмит?
     * @param $mail - email пользователя
     * @param $pass - пароль
     *
     * @return array - ассоциативный массив данных пользователя
     */
    public function auth($subm, $mail, $pass) {
        $user = array();

        // Если был сабмит авторизации и все данные введены верно
        if (!empty($subm) && $this->authCorrect($mail, $pass)) {
            $user           = $this->getUserInfo($mail);
            $user['UNAME']  = $user['lastname'] . ' ' . $user['firstname'] . ' ' . $user['patronymic'];

            // Устанавливаем coockie с данными пользователя
            setcookie("UID",    $user['uid'],   time() + 50000, '/');
            setcookie("email",  $user['email'], time() + 50000, '/');

            // Меняем дату последнего посещения
            $this->db_instance->query(
                    'UPDATE users_site SET date_lastvisit=%s WHERE email=%s LIMIT 1',
                    array(date('Y-m-d H:i:s'), $mail)
            );
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
            $rez = mysql_query('SELECT `password`, `salt` FROM users_site WHERE `email`="' . $mail . '" AND `blocked`="0" LIMIT 1');
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

        $rez = $this->db_instance->query('SELECT password, salt FROM users_site WHERE email=%s AND blocked="0" LIMIT 1', $mail);

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
        if ($post['reg_accept'] != "ok")    { $result .= 'Не приняты условия регистрации<br />'; }   // приняты ли правила

        // соответствует ли поле e-mail регулярному выражению
        if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $post['reg_email']))   { $result .= 'Некорректный e-mail<br />'; }
        // соответствует ли Фамилия регулярному выражению
        if (!preg_match('/^([а-яА-Яa-zA-Z0-9\w-_.\\/ \'"]+)$/is', $post['reg_nickname']))   { $result .= 'Некорректный логин<br />'; }

        if (strlen($post['reg_pass']) < 5 && empty($post['reg_pass']))                  { $result .= 'Длина пароля менее 5 символов<br />'; }  // не меньше ли 5 символов длина пароля

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
        $user = $this->db_instance->query('SELECT us.email, us.nickname, us.uid, us.date_reg, us.date_lastvisit, us.blocked, us.block_reason, uc.rank, uc.borndate, ub.firstname, ub.lastname, ub.patronymic FROM users_site us LEFT OUTER JOIN users_club uc ON uc.id = us.id LEFT OUTER JOIN users_bio ub ON ub.id = us.id WHERE us.email=%s LIMIT 1', $mail);

        return $user;
    }

    /**
     * Функция запроса данных профиля, кроме гостевого
     */
    private function getProfileInfo($nickname) {
        $profile = $this->db_instance->query('SELECT us.email, us.uid, us.blocked, us.block_reason, uc.rank, ub.firstname, ub.lastname, ub.patronymic, ub.birthday, ud.passport_serial, ud.passport_number, ud.passport_issuance, ud.passport_date, ud.reg_address FROM users_site us LEFT OUTER JOIN users_club uc ON uc.id = us.id LEFT OUTER JOIN users_bio ub ON ub.id = us.id LEFT OUTER JOIN users_docs ud ON ud.id = us.id WHERE us.nickname=%s LIMIT 1', $nickname);

        return $profile;
    }

    /**
     * Функция выбора профилей всех пользовтелей
     * @return array
     */
    private function getProfilesInfo() {
        $profiles = $this->db_instance->query('SELECT us.nickname, us.blocked, ub.firstname, ub.lastname, ub.patronymic FROM users_site us LEFT OUTER JOIN users_bio ub ON ub.id = us.id');

        return $profiles;
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
     * Функция отправки письма активации аккаунта
     *
     * @param $mail
     */
    private function activationSend($mail) {
        $user = $this->db_instance->query('SELECT us.email, us.activate_hash, us.activated, us.date_expires, us.nickname, us.blocked FROM users_site us WHERE us.email=%s LIMIT 1', func_get_arg(0));

        if ($user['blocked'] == 0) {
            $from       = 'activation@jaroflame.ru';
            $subject    = "Подтверждение регистрации";
            $message    = $user['nickname'] . '<br />' .
                'Вы зарегистрировались на сайте КИР "Яро пламя"!<br />' .
                'По ссылке вы можете подтвердить свой аккаунт: http://jaroflame/modules/users/activation/action.php?hash=' . $user['activate_hash'];

            // отправляем письмо
            if (!mail($user['email'], $subject, $message, 'From: ' . $from)) {
                echo '<a href="../registration_form.php">Вы не правильно указали почту.</a>';
            } else {
                echo '<a href="/">На указанный почтовый ящик отправлено письмо с ссылкой для активации вашего личного кабинета.</a>';
            }
        }
    }

    public function activation($hash) {
        // получаем хеш код и чистим его от лишних символов
        // $hash = $this->CheckUserNumber($_GET['hash']);

        // TODO: Дописать мдуль автоудаления. CRON?

        if (!empty($hash)) {
            $result = $this->db_instance->query('SELECT id FROM users_site WHERE activate_hash=%s LIMIT 1', $hash);

            // если хеш код найден, то активируем пользователя - set user_status = true и очищаем его user_hash
            if (count($result) > 0) {
                $date_exp = new DateTime;
                $date_exp->modify('+100 years');
                $date_exp = $date_exp->format('Y-m-d H:i:s');

                $this->db_instance->query('UPDATE users_site SET activated = 1, activate_hash = "", date_expires = %s WHERE activate_hash = %s', array($date_exp, $hash));
                echo '<a href="../index.php">Учетная запись активирована. Вернуться на главную.</a>';
            } else {
                echo '<a href="../index.php">Ошибка. Вернуться на главную.</a>';
            }
        } else {
            echo '<a href="../index.php">Неправильная ссылка. Вернуться на главную.</a>';
        }
    }

    /**
     * Функция генерации случайной строки
     * @param int $length
     * @return string
     */
    function generateRandString($length = 35){
        $chars      = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789._:;';
        $numChars   = strlen($chars);
        $string     = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, mt_rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}