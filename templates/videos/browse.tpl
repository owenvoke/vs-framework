{include file='include/header.tpl'}
<div class="container">
    <div class="panel">
        <div class="panel-heading">
            <h1>Browse</h1>
        </div>
        <div class="panel-body">
            {include file='include/pagination.tpl' per_page='20' total=$data->videos->count base_url='/browse/'}
            <div class="video-block home-videos">
                <div class="row">
                    {foreach $data->videos->results as $video name="videos"}
                        {if $smarty.foreach.videos.iteration %3 == 0}
                            <div class="row">
                        {/if}
                        <div class="col-orient-ls col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <div class="preview">
                                    <a href="/v/{$video->hash}">
                                        <img class="img-responsive" width="100%" height="130"
                                             src="/thumbs/{$video->hash}"
                                             alt="{$video->title}">
                                    </a>
                                </div>
                                <div class="pull-right btn btn-xs btn-default btn-no-click margin-top-05">
                                    {$video->file_type|strtolower}
                                </div>
                                <div class="caption">
                                    <h5 class="padding-top-1" title="{$video->title}">
                                        <a href="/v/{$video->hash}">{$video->title}</a>
                                    </h5>
                                    <p class="text-muted small">
                                        {if $video->views}{$video->views}{else}0{/if} views,
                                        {$video->date|absolute_time}
                                    </p>
                                </div>
                            </div>
                        </div>
                        {if $smarty.foreach.videos.iteration %3 == 0}
                            </div>
                        {/if}
                    {/foreach}
                </div>
            </div>
            {include file='include/pagination.tpl' per_page='20' total=$data->videos->count base_url='/browse/'}
        </div>
    </div>
</div>
{include file='include/footer.tpl'}