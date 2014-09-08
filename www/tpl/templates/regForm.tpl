<form id="reg_form" name="reg_form" action="/modules/registration/action.php" method="post" enctype="multipart/form-data">
    <h2>{$reg_caption}</h2>
	<label for="reg_nickname">{$reg_nickname}: </label><input id="reg_nickname" name="reg_nickname" type="text" value="" /><br />
    <label for="reg_email">{$reg_email}: </label><input id="reg_email" name="reg_email" type="text" value="" /><br />

    <label for="reg_pass">{$reg_password}: </label><input id="reg_pass" name="reg_pass" type="password" value="" /><br />
    <label for="reg_pass2">{$reg_confirmpass}: </label><input id="reg_pass2" name="reg_pass2" type="password" value="" /><br />

    <label for="reg_accept"><input id="reg_accept" name="reg_accept" type="checkbox" value="ok" /> {$reg_accept}</label><br />

    <input id="reg_subm" name="reg_subm" class="button" type="submit" value="{$reg_submit}" />
</form>