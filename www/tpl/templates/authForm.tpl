<form id="auth_form" name="fAuth" action="/eng/modules/auth/action.php" method="post" enctype="multipart/form-data">
    <h2>{$auth_caption}</h2>
    <input id="auth_email" name="auth_email" type="text" value="{$auth_email}" />
    <input id="auth_pass" name="auth_pass" type="password" value="{$auth_password}" />

    <input id="auth_subm" name="auth_subm" class="button" type="submit" value="{$auth_submit}"><br />
    <a href="/registration.php">{$auth_registration}</a>
</form>