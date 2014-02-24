<form id="fAuth" name="fAuth" action="/eng/modules/auth/action.php" method="post" enctype="multipart/form-data">
    <h2>{$auth_caption}</h2>
    <input id="aEmail" name="aEmail" type="text" value="{$auth_email}" />
    <input id="aPass" name="aPass" type="password" value="{$auth_password}" />

    <input id="aSubm" name="aSubm" class="button" type="submit" value="{$auth_submit}"><br />
    <a href="/registration.php">{$auth_registration}</a>
</form>