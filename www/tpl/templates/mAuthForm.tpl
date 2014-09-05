<div id="login_auth">
    <form id="mfAuth" name="mfAuth" action="/eng/modules/auth/action.php" method="post" enctype="multipart/form-data">
        <input id="maEmail" name="aEmail" type="text" value="{$auth_email}" />
        <input id="maPass" name="aPass" type="password" value="{$auth_password}" />

        <input id="maSubm" name="aSubm" class="button" type="submit" value="{$auth_submit}">
        <a id="maReg" class="button" href="/registration.php" target="_blank">{$auth_registration}</a>
    </form>
</div>