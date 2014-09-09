{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/users.css" />
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon">

    <script type="text/javascript" src="/include/jslib/jq/core/min.js"></script>
    <script type="text/javascript" src="/include/js/users.js"></script>
</head>

<body>
    <div class="main ">
        {include file="../commons/header.tpl"}
        <div class="content">
            {include file="../commons/error_msg.tpl"}
        </div>
        <div class="push"></div>
    </div>
    {include file="../commons/footer.tpl"}
</body>
</html>