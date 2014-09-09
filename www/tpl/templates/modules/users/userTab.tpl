<div id="user_tools">
	{if $logined}
		{$nickname}
		<a id="user_profile" class="button" href="/profile.php?u={$nickname}">{$auth_profile}</a>
		<a id="user_logout" class="button" href="/modules/users/auth/logout.php">{$auth_exit}</a>
	{else}
		<form id="auth_form_mini" name="auth_form_mini" action="/modules/users/auth/action.php" method="post" enctype="multipart/form-data">
			<input id="auth_email" name="auth_email" type="text" value="{$auth_email}" />
			<input id="auth_pass" name="auth_pass" type="password" value="{$auth_password}" />

			<input id="auth_subm" name="auth_subm" class="button" type="submit" value="{$auth_submit}">
			<a id="auth_reg" class="button" href="/registration.php" target="_parent">{$auth_registration}</a>
		</form>
	{/if}
</div>