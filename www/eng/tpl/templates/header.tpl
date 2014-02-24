<div class="header">
    <img src="{$logo}" align="top" />
    {if $logined}
        {include file="userTab.tpl"}
    {else}
        {include file="mAuthForm.tpl"}
    {/if}
</div>