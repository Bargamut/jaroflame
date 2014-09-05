{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/auth.css" />
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon">

    <script type="text/javascript" src="/include/jslib/jq/core/min.js"></script>
    <script type="text/javascript" src="/include/js/auth.js"></script>
</head>

<body>
    <div class="main ">
        {include file="header.tpl"}
        <div class="content">
            {include file="error_msg.tpl"}
        </div>
        <div class="push"></div>
    </div>
    {include file="footer.tpl"}
</body>
</html>