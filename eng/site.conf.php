<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 29.06.12
 * Time: 4:07
 */
session_start();

// TODO: продолжить формирование конфига сайта
// TODO: формирование конфига админ-панели
// TODO: проектирование Регистрации / Входа / Выхода, Профиля пользователя

include_once('lang/ru/default.php');        // Общий языковой файл RU
include_once('lang/ru/registration.php');   // Языковой файл для регистрации RU
include_once('lang/ru/auth.php');           // Языковой файл для авторизации RU

include_once('api/api.database.php');       // API Базы Данных
 ?>