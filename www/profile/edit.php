<?php
/**
 * User: Bargamut
 * Date: 22.07.12
 * Time: 18:58
 */
include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../include/css/default.css" />
    <link rel="stylesheet" type="text/css" href="../include/css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../include/css/user.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../include/jslib/jq/core/min.js"></script>
    <script type="text/javascript" src="../include/js/auth.js"></script>
</head>

<body>
<div class="main ">
    <div class="header">
        <?=SITE_LOGO?>
        <div id="login_auth">
            <?php
            $userinfo['logined'] ?
                $htmlMAuth = $USER->userTab($userinfo['nickname'])
            :   $htmlMAuth = $USER->mAuthForm();
            echo $htmlMAuth;
            ?>
        </div>
    </div>
    <div class="content">
        <?php
        if ($USER->check_rights('P:w', $userinfo['rights'])) {
            $profile = $USER->profile($userinfo['nickname']);
            ?>
            <div class="profile">
                <div id="site" class="info">
                    <h2>Аккаунт</h2>
                    <form action="/profile/action.php" method="post" enctype="multipart/form-data">
                        <span>Уровень:</span> <?=$profile['lvlname'];?><br />
                        <span>E-Mail:</span> <input name="email" type="text" value="<?=$profile['email'];?>" /><br />
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
                        <span>Фамилия:</span> <input name="lastname" type="text" value="<?=$profile['lastname'];?>" /><br />
                        <span>Имя:</span> <input name="firstname" type="text" value="<?=$profile['firstname'];?>" /><br />
                        <span>Отчество:</span> <input name="fathername" type="text" value="<?=$profile['fathername'];?>" /><br />
                        <span>ДР:</span> <input name="birthday" type="text" value="<?=$profile['birthday'];?>" />
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
                        <span>Паспорт (серия):</span> <input name="p_seria" type="text" size="4" value="<?=$profile['p_seria'];?>" />
                        <span>(номер):</span> <input name="p_number" type="text" size="6" value="<?=$profile['p_number'];?>" /><br />
                        <span>Дата выдачи:</span> <input name="p_date" type="text" value="<?=$profile['p_date'];?>" /><br />
                        <span>Выдан:</span> <textarea name="p_issuance"><?=$profile['p_issuance'];?></textarea><br />
                        <span>Учёба:</span> <textarea name="studies"><?=$profile['studies'];?></textarea><br />
                        <span>Работа:</span> <input name="work" type="text" value="<?=$profile['work'];?>" /><br />
                        <span>Мед.рекомендации:</span> <textarea name="medicine"><?=$profile['medicine'];?></textarea><br />
                        <span>Адрес прописки:</span> <textarea name="reg_address"><?=$profile['reg_address'];?></textarea>
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
                        <span>Дата прихода в Клуб:</span> <input name="borndate" type="text" value="<?=$profile['borndate'];?>" /><br />
                        <span>Звание:</span> <input name="rank" type="text" value="<?=$profile['rank'];?>" /><br />
                        <span>Подопечные:</span> <textarea name="wards"><?=$profile['wards'];?></textarea><br />
                        <span>Фестивали:</span> <textarea name="fests"><?=$profile['fests'];?></textarea><br />
                        <span>Награды:</span> <textarea name="awards"><?=$profile['awards'];?></textarea>
                        <div class="tool">
                            <span>Старый пароль:</span> <input name="password" type="password" value="" />
                            <input name="type" type="hidden" value="club" />
                            <input name="btnSubm" type="submit" value="Ок" />
                        </div>
                    </form>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="error">
                Нет доступа
            </div>
        <?php
        }
        ?>
    </div>
    <div class="push"></div>
</div>
<div class="footer">
    <hr />
    <?=CREDITS?>
    <?=DEVELOPERS?>
</div>
</body>
</html>
<?php include('../bottom.php');?>