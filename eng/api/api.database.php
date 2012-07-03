<?php
function db_connect($server, $username, $password) {
    $db_index = mysql_connect($server, $username, $password) or die('Ошибка подключения к базе данных!');
    return $db_index;
}
function db_close($db_index) {
    mysql_close($db_index);
}
function db_select_db($database, $db_index) {
    mysql_select_db($database, $db_index);
}
function db_create() {}
function db_drop() {}
function db_insert() {}
function db_update() {}
function db_delete() {}
function db_search() {}
?>