<?php include('top.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/default.css" />
    <link rel="stylesheet" type="text/css" href="css/auth.css" />
    <link rel="shortcut icon" href="<?=SITE_ICON?>" type="image/x-icon">
    <title><?=SITE_TITLE?></title>
</head>

<body>
<div class="main header">
    <?=SITE_LOGO?>
</div>
<div class="main content">
    <h2><?=AUTH_CAPTION?></h2>
    <form id="fAuth" name="fAuth" action="auth_action.php" method="post" enctype="multipart/form-data">
        <label for="aEmail"><?=AUTH_EMAIL?>: </label><input id="aEmail" name="aEmail" type="text" value="" /><br />

        <label for="aPass"><?=AUTH_PASSWORD?>: </label><input id="aPass" name="aPass" type="password" value="" /><br />

        <input id="aSubm" name="aSubm" type="submit" value="<?=AUTH_SUBMIT?>">
    </form>
</div>
<div class="main footer">
    <?=CREDITS?>
    <?=DEVELOPERS?>
</div>
</body>
</html>
<?php include('bottom.php');?>