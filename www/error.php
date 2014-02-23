<?php include('top.php');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="include/css/default.css" />
<link rel="stylesheet" type="text/css" href="include/css/auth.css" />
<link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
<title><?=SITE_TITLE?></title>
<script type="text/javascript" src="include/jslib/jq/core/min.js"></script>
<script type="text/javascript" src="include/js/auth.js"></script>
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
        <div class="error">
            <?=$ERRORS[$_GET['t']]?>
        </div>
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