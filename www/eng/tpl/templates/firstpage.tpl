{* Smarty *}

<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/auth.css" />
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon">

    <script src="/include/jslib/jq/core/min.js"></script>
    <script src="/include/js/auth.js"></script>
</head>

<body>
    <div class="main ">
        <div class="header">
            {$logo}
            <div id="login_auth">
                {$user_panel}
            </div>
        </div>
        <div class="content">
            {$debug}
        </div>
        <div class="push"></div>
    </div>
    <div class="footer">
        <hr />
        {$credits}
        {$developers}
    </div>
</body>
</html>