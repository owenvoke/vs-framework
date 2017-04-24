<div class="panel-group text-right">
    {$pages = ceil($total / $per_page)}
    {if $pages > 9}
        {assign var='pages' value=1}
    {/if}
    {for $i = 1; $i < $pages + 1; $i++}
        <a href="/browse/{$i}" class="btn btn-default">{$i}</a>
    {/for}
</div>