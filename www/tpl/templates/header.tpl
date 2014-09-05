<div class="header">
    <a href="/"><img src="{$logo}" align="top" /></a>
    {if $logined}
        {include file="userTab.tpl"}
    {else}
        {include file="mAuthForm.tpl"}
    {/if}
</div>