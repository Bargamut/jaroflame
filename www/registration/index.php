<?php include('../top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../include/css/default.css" />
    <link rel="stylesheet" type="text/css" href="../include/css/auth.css" />
    <link rel="stylesheet" type="text/css" href="../include/css/registration.css" />
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
    <?php if (!$userinfo['logined']) {?>
        <form id="fReg" name="fReg" action="/registration/action.php" method="post" enctype="multipart/form-data">
            <h2><?=REG_CAPTION?></h2>
            <label for="rEmail"><?=REG_EMAIL?>: </label><input id="rEmail" name="rEmail" type="text" value="" /><br />

            <label for="rLName"><?=REG_LASTNAME?>: </label><input id="rLName" name="rLName" type="text" value="" /><br />
            <label for="rName"><?=REG_FIRSTNAME?>: </label><input id="rName" name="rName" type="text" value="" /><br />
            <label for="rFName"><?=REG_FATHERNAME?>: </label><input id="rFName" name="rFName" type="text" value="" /><br />

            <label for="rPass"><?=REG_PASSWORD?>: </label><input id="rPass" name="rPass" type="password" value="" /><br />
            <label for="rPass2"><?=REG_CONFIRMPASS?>: </label><input id="rPass2" name="rPass2" type="password" value="" /><br />

            <label for="rLic"><input id="rLic" name="rLic" type="checkbox" value="ok" /> <?=REG_LICENSE?></label><br />

            <input id="rSubm" name="rSubm" class="button" type="submit" value="<?=REG_SUBMIT?>">
        </form>
    <?php } else { ?>
        <div class="error">
            <div><?=REG_CAPTION?></div>
            Вы уже зарегистрированы!
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