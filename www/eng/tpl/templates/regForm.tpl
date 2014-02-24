<form id="fReg" name="fReg" action="/registration/action.php" method="post" enctype="multipart/form-data">
    <h2>{$reg_caption}</h2>
    <label for="rEmail">{$reg_email}: </label><input id="rEmail" name="rEmail" type="text" value="" /><br />

    <label for="rLName">{$reg_lastname}: </label><input id="rLName" name="rLName" type="text" value="" /><br />
    <label for="rName">{$reg_firstname}: </label><input id="rName" name="rName" type="text" value="" /><br />
    <label for="rFName">{$reg_fathername}: </label><input id="rFName" name="rFName" type="text" value="" /><br />

    <label for="rPass">{$reg_password}: </label><input id="rPass" name="rPass" type="password" value="" /><br />
    <label for="rPass2">{$reg_confirmpass}: </label><input id="rPass2" name="rPass2" type="password" value="" /><br />

    <label for="rLic"><input id="rLic" name="rLic" type="checkbox" value="ok" /> {$reg_license}</label><br />

    <input id="rSubm" name="rSubm" class="button" type="submit" value="{$reg_submit}" />
</form>