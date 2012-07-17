<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 15.07.12
 * Time: 22:46
 */
class Users {
    /**
     * Регистрация пользователя
     * @param $subm - сабмит
     * @param $post - массив данных пользователя
     */
    function registration($subm, $post) {
        if (!empty($subm) && $this->registrationCorrect($post)) {
            $mail = htmlspecialchars($post['rEmail']);
            $salt = mt_rand(100, 999);
            $date_reg = date('Y-m-d H:i:s');
            $fio = array(
                'firstname' => $post['rName'],
                'lastname' => $post['rLName'],
                'fathername' => $post['rFName'],
            );
            $password = md5(md5($post['rPass']).$salt);
            $token = md5(uniqid(rand(), 1));

            mysql_query('
            DROP PROCEDURE IF EXISTS `create_user`;
            CREATE PROCEDURE `create_user`(
                IN m VARCHAR(255),
                IN p VARCHAR(255),
                IN s integer(3),
                IN d VARCHAR(255),
                IN v VARCHAR(255),
                IN u VARCHAR(255),
                IN n VARCHAR(255),
                IN ln VARCHAR(255),
                IN fn VARCHAR(255)
            )
            NOT DETERMINISTIC
            SQL SECURITY INVOKER
            COMMENT ""
            BEGIN
                INSERT INTO users_site (`email`, `password`, `salt`, `date_reg`, `date_lastvisit`, `uid`) VALUES (m, p, s, d, v, u);
                INSERT INTO users_bio (`firstname`, `lastname`, `fathername`) VALUES (n, ln, fn);
                INSERT INTO users_doc () VALUES ();
                INSERT INTO users_club () VALUES ();
            END');
            $db_query = 'CALL `create_user`("'.$mail.'", "'.$password.'", "'.$salt.'", "'.$date_reg.'", "'.$date_reg.'", "'.$token.'", "'.$fio['firstname'].'", "'.$fio['lastname'].'", "'.$fio['fathername'].'")';

            if (mysql_query($db_query) or die(mysql_error())) {
                return $this->auth($subm, $post['rEmail'], $post['rPass']);
            }
        } else {
//            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
    }

    /**
     * Авторизация пользователя
     */
    function auth($subm, $mail, $pass) {
        $auth_correct = $this->authCorrect($mail, $pass);

        // Если был сабмит авторизации и все данные введены верно
        if (!empty($subm) && $auth_correct) {
            $mail   = htmlspecialchars($mail);
            $query  = 'SELECT us.`email`, us.`uid`, us.`level`, ub.`firstname`, ub.`lastname`, ub.`fathername` ' .
                      'FROM users_site us ' .
                      'LEFT OUTER JOIN users_bio ub ' .
                      'ON ub.`id` = us.`id`' .
                      'WHERE us.`email`="' . $mail . '" ' .
                      'LIMIT 1';

            $rez = mysql_query($query) or die(mysql_error());
            @$user = mysql_fetch_assoc($rez);
            $user['UNAME'] = $user['lastname'].' '.$user['firstname'].' '.$user['fathername'];

            // Устанавливаем coockie с данными пользователя
            setcookie ("UID", $user['uid'], time() + 50000, '/');
            setcookie ("email", $user['email'], time() + 50000, '/');

            // Меняем дату последнего посещения
            mysql_query('UPDATE users_site SET `date_lastvisit`="' . date('Y-m-d H:i:s') . '" WHERE `email`="' . $mail . '" LIMIT 1');
            // И перенаправляем на главную
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        } else {
            // Перенаправляем на главную
            // header('Location: http://'.$_SERVER['SERVER_NAME']);
        }

        return $user;
    }

    /**
     * Выход
     */
    function logout() {
        setcookie ("UID", '', time() - 50000, '/');
        setcookie ("email", '', time() - 50000, '/');

        session_destroy();

        header('Location: http://'.$_SERVER['SERVER_NAME']);
    }

    /**
     * Проверка на авторизованность пользователя
     * @return bool
     */
    function already_login() {
        return (isset($_SESSION['USER']['uid']) || (isset($_COOKIE['UID']) && isset($_COOKIE['email'])));
    }

    function check_level($lvl, $userlvl) {
        $res        = false;
        $lvl        = explode(',', $lvl);
        $userlvl    = explode(',', $userlvl);

        foreach($lvl as $key => $val){
            if (in_array($val, $userlvl)) { $res = true; }
        }

        return $res;
    }

    /**
     * Функция проверки корректности введённых данных
     * @return bool
     */
    private function authCorrect($mail, $pass) {
        $result = '';

        if ($mail == "") $result .= 'Пустой E-Mail|';     // не пусто ли поле логина
        if ($pass == "") $result .= 'Пустой пароль';      // не пусто ли поле пароля
        // не меньше ли 5 символов длина пароля
        if (strlen($pass) < 5 && empty($path)) $result .= 'pass < 5|';
        $rez = mysql_query('SELECT `password`, `salt` FROM users_site WHERE `email`="' . $mail . '" AND `block`="1" LIMIT 1');
        // проверка на существование в БД такого же логина
        if (@mysql_num_rows($rez) == 0) $result .= 'Такого пользователя нет';
        while ($user = mysql_fetch_array($rez, MYSQL_ASSOC)) {
            if (md5(md5($pass).$user['salt']) != $user['password']) $result .= 'Невереная пара Логин/Пароль';
        }
        return ($result == ''); // если выполнение функции дошло до этого места, возвращаем true
    }

    /**
     * Функция проверки корректности введённых данных
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
        if (md5($_POST['rPass']) != md5($_POST['rPass2'])) $result = 'not_confirm_pass|';    // равен ли пароль его подтверждению
        $mail = htmlspecialchars($_POST['rMail']);
        $rez = mysql_query('SELECT * FROM users_site WHERE `email`="'.$mail.'" limit 1');
        if (@mysql_num_rows($rez) != 0) $result = 'already_exist|';                   // проверка на существование в БД такого же логина

        echo $result;
        return ($result == '');                                                    //если выполнение функции дошло до этого места, возвращаем true
    }
}