<?php include('top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/default.css" />
    <link rel="stylesheet" type="text/css" href="css/auth.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
    <script type="text/javascript" src="js/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/auth.js"></script>
</head>

<body>
<div class="main ">
    <div class="header">
        <?=SITE_LOGO?>
        <div id="login_auth">
        <?php
        if ($USER->already_login()) {?>
            <?=$_SESSION['USER']['UNAME']?>
            <a href="/logout.php">
                <input id="maExit" name="maExit" class="button" type="button" value="<?=AUTH_EXIT?>" />
            </a>
        <?php
        } else {
        ?>
            <form id="mfAuth" name="mfAuth" action="auth_action.php" method="post" enctype="multipart/form-data">
                <input id="maEmail" name="aEmail" type="text" value="<?=AUTH_EMAIL?>" />
                <input id="maPass" name="aPass" type="password" value="<?=AUTH_PASSWORD?>" />

                <input id="maSubm" name="aSubm" class="button" type="submit" value="<?=AUTH_SUBMIT?>">
                <a href="/registration.php" target="_blank">
                    <input id="maReg" name="maReg" class="button" type="button" value="<?=AUTH_REGISTRATION?>" />
                </a>
            </form>
        <?php
        }
        ?>
        </div>
    </div>
    <div class="content">
        <?=DEBUG?>
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
<?php include('bottom.php');?>