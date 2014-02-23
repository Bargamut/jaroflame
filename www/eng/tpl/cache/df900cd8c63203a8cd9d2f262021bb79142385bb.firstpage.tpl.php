<?php /*%%SmartyHeaderCode:25028530978c7e67073-48539043%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df900cd8c63203a8cd9d2f262021bb79142385bb' => 
    array (
      0 => 'E:\\OpenServer\\domains\\jaroflame\\www\\eng\\tpl\\templates\\firstpage.tpl',
      1 => 1393130670,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25028530978c7e67073-48539043',
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_53097cb1aca694_74431592',
  'variables' => 
  array (
    'title' => 0,
    'favicon' => 0,
    'logo' => 0,
    'user_panel' => 0,
    'debug' => 0,
    'credits' => 0,
    'developers' => 0,
  ),
  'has_nocache_code' => false,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53097cb1aca694_74431592')) {function content_53097cb1aca694_74431592($_smarty_tpl) {?>
<!DOCTYPE html>
<html>
<head>
    <title>КИР "Яро Пламя"</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/auth.css" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <script src="/include/jslib/jq/core/min.js"></script>
    <script src="/include/js/auth.js"></script>
</head>

<body>
    <div class="main ">
        <div class="header">
            <img src="/img/default/logo3.png" align="top" />
            <div id="login_auth">
                <form id="mfAuth" name="mfAuth" action="/auth/action.php" method="post" enctype="multipart/form-data">
    <input id="maEmail" name="aEmail" type="text" value="E-Mail" />
    <input id="maPass" name="aPass" type="password" value="Пароль" />

    <input id="maSubm" name="aSubm" class="button" type="submit" value="Войти">
    <a id="maReg" class="button" href="/registration/" target="_blank">Вступить</a>
</form>
            </div>
        </div>
        <div class="content">
            Сайт на реконструкции, скоро вернёмся!
        </div>
        <div class="push"></div>
    </div>
    <div class="footer">
        <hr />
        Клуб Исторической Реконструкции "Яро Пламя"<br />&copy; 2008 - 2014
        Разработка Bargamut.RU
    </div>
</body>
</html><?php }} ?>
