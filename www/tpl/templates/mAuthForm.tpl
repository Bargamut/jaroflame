<div id="login_auth">
    <form id="auth_form_mini" name="mfAuth" action="/modules/auth/action.php" method="post" enctype="multipart/form-data">
        <input id="auth_email" name="auth_email" type="text" value="{$auth_email}" />
        <input id="auth_pass" name="auth_pass" type="password" value="{$auth_password}" />

        <input id="auth_subm" name="auth_subm" class="button" type="submit" value="{$auth_submit}">
        <a id="auth_reg" class="button" href="/registration.php" target="_blank">{$auth_registration}</a>
    </form>
</div>