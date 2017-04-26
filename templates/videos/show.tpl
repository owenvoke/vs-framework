{include file='include/header.tpl'}
<div class="container">
    <div class="panel panel-default">
        {if $data->video}
            <div class="panel-heading">
                <h1>{$data->video->title}</h1>
            </div>
            <div class="panel-body">
                <div class="panel-group">
                    <video class="video" controls src="/videos/{$data->video->hash}">
                        Sorry, your browser doesn't support HTML5 videos.
                    </video>
                </div>
                <div class="panel-group">
                    <div class="btn-group pull-left">
                        <div class="btn btn-sm btn-default btn-inverse btn-no-click">
                            <span class="fa fa-fw fa-clock-o" title="Upload date"></span>
                            <span>{$data->video->date|absolute_time}</span>
                        </div>
                        <div class="btn btn-sm btn-default btn-inverse btn-no-click">
                            <span class="fa fa-fw fa-eye" title="Total views"></span>
                            <span>{$data->video->stats->views}</span>
                        </div>
                        <div class="btn btn-sm btn-default btn-inverse btn-no-click">
                            <span class="fa fa-fw fa-folder-open" title="Category"></span>
                            <a href="/category/{$data->video->category->id}/">
                                {$data->video->category->name}
                            </a>
                        </div>
                        <div class="btn btn-sm btn-default btn-inverse btn-no-click">
                            <span class="fa fa-fw fa-user" title="Uploader"></span>
                            <a href="/profile/{$data->video->uploader->username}">
                                {$data->video->uploader->username}
                            </a>
                        </div>
                    </div>
                    <div class="btn-group pull-right">
                        <a href="" class="btn btn-default btn-sm">
                            <span class="fa fa-fw fa-share-alt"></span>
                            Share
                        </a>
                        <a href="" class="btn btn-default btn-sm">
                            <span class="fa fa-fw fa-star"></span>
                            Feature this
                        </a>
                        <a href="" class="btn btn-default btn-sm">
                            <span class="fa fa-fw fa-flag"></span>
                            Report
                        </a>
                    </div>
                </div>
                {if $data->video->description}
                    <div class="panel-group">
                        <h5>Description:</h5>
                        <p>{$data->video->description}</p>
                    </div>
                {/if}
            </div>
        {else}
            <div class="panel-heading">
                <h1>Video not found 😞</h1>
            </div>
            <div class="panel-body">
                <div class="panel-group">
                    Sorry, this video doesn't seem to exist. Perhaps you got the wrong hash?
                </div>
            </div>
        {/if}
    </div>
</div>
{include file='include/footer.tpl'}