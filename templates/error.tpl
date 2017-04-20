{include file='include/header.tpl'}
<div class="container">
    <h1>{if $error->text !== ''}{$error->text}{else}An unknown error occurred.{/if}</h1>
    <h4>Error Code: {if $error->code !== ''}{$error->code}{else}500{/if}</h4>
    {if $error->data}
        <pre>{$error->data|print_r:false}</pre>
    {/if}
</div>
{include file='include/footer.tpl'}