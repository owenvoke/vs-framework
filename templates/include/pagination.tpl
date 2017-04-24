<div class="panel-group text-right">
    {$pages = ceil($total / $per_page)}
    {if $pages > 9}
        {assign var='pages' value=1}
    {/if}
    <a href="{$base_url}" class="btn btn-default">
        <span class="fa fa-fw fa-angle-double-left"></span>
    </a>
    {for $i = 1; $i < $pages + 1; $i++}
        <a href="{$base_url}{$i}" class="btn btn-default">{$i}</a>
    {/for}
    <a href="{$base_url}{$pages}" class="btn btn-default">
        <span class="fa fa-fw fa-angle-double-right"></span>
    </a>
</div>