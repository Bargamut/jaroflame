{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/users.css" />
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon" />

    <script src="/include/jslib/jq/core/min.js"></script>
    <script src="/include/js/users.js"></script>
</head>

<body>
    <div class="main">
        {include file="../commons/header.tpl"}
        <div class="content">
            {if !$logined}
                {include "../modules/users/authForm.tpl"}
            {else}
                {include "../commons/error_msg.tpl"}
            {/if}
        </div>
        <div class="push"></div>
    </div>
    {include file="../commons/footer.tpl"}
</body>
</html>