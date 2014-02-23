<form id="mfAuth" name="mfAuth" action="/auth/action.php" method="post" enctype="multipart/form-data">
    <input id="maEmail" name="aEmail" type="text" value="{AUTH_EMAIL}" />
    <input id="maPass" name="aPass" type="password" value="{AUTH_PASSWORD}" />

    <input id="maSubm" name="aSubm" class="button" type="submit" value="{AUTH_SUBMIT}">
    <a id="maReg" class="button" href="/registration/" target="_blank">{AUTH_REGISTRATION}</a>
</form>