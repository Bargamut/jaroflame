<?php
/**
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');

$post = array(
    'faked_email'   => $_POST['email'],
    'reg_nickname'  => $_POST['reg_nickname'],
    'reg_email'     => $_POST['reg_email'],
    'reg_pass'      => $_POST['reg_pass'],
    'reg_accept'    => $_POST['reg_accept']
);

$USER->registration($_POST['reg_subm'], $post);