<div class="panel-group text-right">
    <ul class="pagination">
        {$pages = ceil($total / $per_page)}
        {if $pages > 9}
            {assign var='pages' value=1}
        {/if}
        <li>
            <a href="{$base_url}" class="btn btn-default">
                <span class="fa fa-fw fa-angle-double-left"></span>
            </a>
        </li>
        {for $i = 1; $i < $pages + 1; $i++}
            <li>
                <a href="{$base_url}{$i}" class="btn btn-default">{$i}</a>
            </li>
        {/for}
        <li>
            <a href="{$base_url}{$pages}" class="btn btn-default">
                <span class="fa fa-fw fa-angle-double-right"></span>
            </a>
        </li>
    </ul>
</div>