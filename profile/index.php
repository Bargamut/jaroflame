<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 03.07.12
 * Time: 3:31
 */
include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../css/user.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="../js/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../js/auth.js"></script>
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
        if ($USER->check_rights('P:r', $userinfo['rights'])) {
            if (isset($_GET['u'])) {
                $profile = $USER->profile($_GET['u']);
                if ($profile != '') {
                    if ($profile['block']) {?>
                        <div class="blocked">
                            <div>Блокирован!</div>
                            Причина: <?=$profile['block_reason'];?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="profile">
                        <div id="site" class="info">
                            <h2>Аккаунт</h2>
                            <span>Уровень:</span> <?=$profile['lvlname'];?>
                        <?php if ($USER->isyoUID($userinfo['uid'], $profile['uid'])) {?>
                            <br />
                            <span>E-Mail:</span> <?=$profile['email'];?>
                            <div class="tool">
                                <a href="/profile/edit.php">Редактировать</a>
                            </div>
                        <?php }?>
                        </div>
                        <div id="bio" class="info">
                            <h2>БИО</h2>
                            <span>ФИО:</span> <?=$profile['lastname'].' '.$profile['firstname'].' '.$profile['fathername'];?>
                        <?php if ($USER->isyoUID($userinfo['uid'], $profile['uid'])) {?>
                            <br />
                            <span>ДР:</span> <?=$profile['birthday'];?>
                        <?php }?>
                        </div>
                    <?php if ($USER->isyoUID($userinfo['uid'], $profile['uid'])) {?>
                        <div id="doc" class="info">
                            <h2>Документы</h2>
                            <span>Паспорт:</span> <?=$profile['p_seria'];?> <?=$profile['p_number'];?><br />
                            <span>Выдан:</span> <?=$profile['p_issuance'];?> <?=$profile['p_date'];?><br />
                            <span>Учёба:</span> <?=$profile['studies'];?><br />
                            <span>Работа:</span> <?=$profile['work'];?><br />
                            <span>Мед.рекомендации:</span> <?=$profile['medicine'];?><br />
                            <span>Адрес прописки:</span> <?=$profile['reg_address'];?>
                        </div>
                    <?php }?>
                        <div id="club" class="info">
                            <h2>Клуб</h2>
                            <span>Дата прихода в Клуб:</span> <?=$profile['borndate'];?><br />
                            <span>Звание:</span> <?=$profile['rank'];?><br />
                            <span>Подопечные:</span> <?=$profile['wards'];?><br />
                            <span>Фестивали:</span> <?=$profile['fests'];?><br />
                            <span>Награды:</span> <?=$profile['awards'];?>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="error">
                        Нет такого пользователя!
                    </div>
                <?php
                }
            } else {
                foreach($USER->profiles() as $k => $v) {
                    $v['block'] ? $cl = ' miniblocked' : $cl = '';
                ?>
                    <div class="miniprofile<?=$cl?>">
                        <a href="/profile/?u=<?=$v['nickname']?>">
                        <?=$v['nickname']?><br />
                        <?=$v['lastname']?>
                        <?=$v['firstname']?>
                        <?=$v['fathername']?>
                        </a>
                    </div>
                <?php
                }
            }
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