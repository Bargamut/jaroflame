{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/auth.css" />
    <link rel="stylesheet" href="/include/css/registration.css" />
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon" />

    <script src="/include/jslib/jq/core/min.js"></script>
    <script src="/include/js/auth.js"></script>
</head>

<body>
    <div class="main ">
        {include "header.tpl"}
        <div class="content">
            {if !$logined}
                {include "regForm.tpl"}
            {else}
                {include "error_msg.tpl"}
            {/if}
        </div>
        <div class="push"></div>
    </div>
    {include "footer.tpl"}
</body>
</html>