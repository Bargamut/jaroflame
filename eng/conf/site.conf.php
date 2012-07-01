<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 29.06.12
 * Time: 4:07
 */

// TODO: продолжить формирование конфига сайта
// TODO: формирование конфига админ-панели
// TODO: проектирование Регистрации / Входа / Выхода, Профиля пользователя

define('SITE_TITLE' ,   'КИР "Яро Пламя"');
define('SITE_ROOT'  ,   $_SERVER['DOCUMENT_ROOT']);
define('SITE_ICON'  ,   SITE_ROOT . '/favicon.ico');


define('DEBUG'      ,   '<img src="/img/default/logo3.png" align="top" /><br />
                        Сайт на реконструкции, скоро вернёмся!');

define('CREDITS'    ,   'Клуб Исторической Реконструкции "Яро Пламя" &copy; 2008 - ' . date('Y'));
define('DEVELOPERS' ,   'Разработка Bargamut.RU');
 ?>