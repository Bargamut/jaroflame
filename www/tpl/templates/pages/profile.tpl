{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>

    <meta charset="utf-8" />

    <link rel="stylesheet" href="/include/css/default.css" />
    <link rel="stylesheet" href="/include/css/users.css" />
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon" />

    <script type="text/javascript" src="/include/jslib/jq/core/min.js"></script>
    <script type="text/javascript" src="/include/js/users.js"></script>
</head>

<body>
    <div class="main">
        {include file="../commons/header.tpl"}
        <div class="content">
            {if $check_rights}
                {if $user_profile}
                    {if $profile}
                        {if $block}
                            {include file="../commons/block_msg.tpl"}
                        {/if}
                        <div class="profile">
                            <div id="site" class="info">
                                <h2>Аккаунт</h2>
                                <span>Уровень:</span> {$lvlname}
                                {if $current_user}
                                    <br />
                                    <span>E-Mail:</span> {$email}
                                    <div class="tool">
                                        <a href="/profileedit.php">Редактировать</a>
                                    </div>
                                {/if}
                            </div>
                            <div id="bio" class="info">
                                <h2>БИО</h2>
                                <span>ФИО:</span> {$lastname} {$firstname} {$patronymic}
                                {if $current_user}
                                    <br />
                                    <span>ДР:</span> {$birthday}
                                {/if}
                            </div>
                            {if $current_user}
                                <div id="doc" class="info">
                                    <h2>Документы</h2>
                                    <span>Паспорт:</span> {$p_seria} {$p_number}<br />
                                    <span>Выдан:</span> {$p_issuance} {$p_date}<br />
                                    <span>Учёба:</span> {$studies}<br />
                                    <span>Работа:</span> {$work}<br />
                                    <span>Мед.рекомендации:</span> {$medicine}<br />
                                    <span>Адрес прописки:</span> {$reg_address}
                                </div>
                            {/if}
                            <div id="club" class="info">
                                <h2>Клуб</h2>
                                <span>Дата прихода в Клуб:</span> {$borndate}<br />
                                <span>Звание:</span> {$rank}<br />
                                <span>Подопечные:</span> {$wards}<br />
                                <span>Фестивали:</span> {$fests}<br />
                                <span>Награды:</span> {$awards}
                            </div>
                        </div>
                    {else}
                        {include file="../commons/error_msg.tpl"}
                    {/if}
                {else}
                    {foreach from=$profiles key=k item=v}
                        {if $v.block}
                            <div class="miniprofile miniblocked">
                        {else}
                            <div class="miniprofile">
                        {/if}
                            <a href="/profile.php?u={$v.nickname}">
                                {$v.nickname}<br />
                                {$v.lastname}
                                {$v.firstname}
                                {$v.patronymic}
                            </a>
                        </div>
                    {/foreach}
                {/if}
            {else}
                {include file="../commons/error_msg.tpl"}
            {/if}
        </div>
        <div class="push"></div>
    </div>
    {include file="../commons/footer.tpl"}
</body>
</html>