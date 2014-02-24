{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/auth.css" />
    <link rel="stylesheet" href="/include/css/user.css" />
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon">

    <script type="text/javascript" src="/include/jslib/jq/core/min.js"></script>
    <script type="text/javascript" src="/include/js/auth.js"></script>
</head>

<body>
    <div class="main">
        {include file="header.tpl"}
        <div class="content">
            {if $check_rights}
                <div class="profile">
                    <div id="site" class="info">
                        <h2>Аккаунт</h2>
                        <form action="/profile/action.php" method="post" enctype="multipart/form-data">
                            <span>Уровень:</span> {$lvlname}<br />
                            <span>E-Mail:</span> <input name="email" type="text" value="{$email}" /><br />
                            <span>Новый пароль:</span> <input name="newpass" type="password" value="" /><br />
                            <span>Подтверждение:</span> <input name="newpass2" type="password" value="" />
                            <div class="tool">
                                <span>Старый пароль:</span> <input name="password" type="password" value="" />
                                <input name="type" type="hidden" value="site" />
                                <input name="btnSubm" type="submit" value="Ок" />
                            </div>
                        </form>
                    </div>
                    <div id="bio" class="info">
                        <h2>БИО</h2>
                        <form action="/profile/action.php" method="post" enctype="multipart/form-data">
                            <span>Фамилия:</span> <input name="lastname" type="text" value="{$lastname}" /><br />
                            <span>Имя:</span> <input name="firstname" type="text" value="{$firstname}" /><br />
                            <span>Отчество:</span> <input name="fathername" type="text" value="{$fathername}" /><br />
                            <span>ДР:</span> <input name="birthday" type="text" value="{$birthday}" />
                            <div class="tool">
                                <span>Старый пароль:</span> <input name="password" type="password" value="" />
                                <input name="type" type="hidden" value="bio" />
                                <input name="btnSubm" type="submit" value="Ок" />
                            </div>
                        </form>
                    </div>
                    <div id="doc" class="info">
                        <h2>Документы</h2>
                        <form action="/profile/action.php" method="post" enctype="multipart/form-data">
                            <span>Паспорт (серия):</span> <input name="p_seria" type="text" size="4" value="{$p_seria}" />
                            <span>(номер):</span> <input name="p_number" type="text" size="6" value="{$p_number}" /><br />
                            <span>Дата выдачи:</span> <input name="p_date" type="text" value="{$p_date}" /><br />
                            <span>Выдан:</span> <textarea name="p_issuance">{$p_issuance}</textarea><br />
                            <span>Учёба:</span> <textarea name="studies">{$studies}</textarea><br />
                            <span>Работа:</span> <input name="work" type="text" value="{$work}" /><br />
                            <span>Мед.рекомендации:</span> <textarea name="medicine">{$medicine}</textarea><br />
                            <span>Адрес прописки:</span> <textarea name="reg_address">{$reg_address}</textarea>
                            <div class="tool">
                                <span>Старый пароль:</span> <input name="password" type="password" value="" />
                                <input name="type" type="hidden" value="doc" />
                                <input name="btnSubm" type="submit" value="Ок" />
                            </div>
                        </form>
                    </div>
                    <div id="club" class="info">
                        <h2>Клуб</h2>
                        <form action="/profile/action.php" method="post" enctype="multipart/form-data">
                            <span>Дата прихода в Клуб:</span> <input name="borndate" type="text" value="{$borndate}" /><br />
                            <span>Звание:</span> <input name="rank" type="text" value="{$rank}" /><br />
                            <span>Подопечные:</span> <textarea name="wards">{$wards}</textarea><br />
                            <span>Фестивали:</span> <textarea name="fests">{$fests}</textarea><br />
                            <span>Награды:</span> <textarea name="awards">{$awards}</textarea>
                            <div class="tool">
                                <span>Старый пароль:</span> <input name="password" type="password" value="" />
                                <input name="type" type="hidden" value="club" />
                                <input name="btnSubm" type="submit" value="Ок" />
                            </div>
                        </form>
                    </div>
                </div>
            {else}
                {include file="error_msg.tpl"}
            {/if}
        </div>
        <div class="push"></div>
    </div>
    {include file="footer.tpl"}
</body>
</html>