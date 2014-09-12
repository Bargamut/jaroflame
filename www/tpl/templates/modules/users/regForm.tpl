<form id="reg_form" name="reg_form" action="/modules/users/registration/action.php" method="post" enctype="multipart/form-data">
    <h2>{$reg_caption}</h2>
	<input id="reg_mail" name="email" type="text" value="" />
	<input id="reg_nickname" name="reg_nickname" type="text" value="{$reg_nickname}" /><br />
    <input id="reg_email" name="reg_email" type="text" value="{$reg_email}" /><br />
	<div id="reg_passinput">
		<input id="reg_pass" name="reg_pass" type="password" value="{$reg_password}" />
		<i id="reg_showpass" title="Показать / Скрыть"></i>
	</div>

    <label for="reg_accept"><input id="reg_accept" name="reg_accept" type="checkbox" value="ok" /> {$reg_accept}</label><br />

    <input id="reg_subm" name="reg_subm" class="button" type="submit" value="{$reg_submit}" />
</form>