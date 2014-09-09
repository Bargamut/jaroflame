{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/users.css" />
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon">

    <script src="/include/jslib/jq/core/min.js"></script>
    <script src="/include/js/users.js"></script>
</head>

<body>
    <div class="main ">
        {include "../commons/header.tpl"}
        <div class="content">
            {$debug}
        </div>
        <div class="push"></div>
    </div>
    {include "../commons/footer.tpl"}
</body>
</html>