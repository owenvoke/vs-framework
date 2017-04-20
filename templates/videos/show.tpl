{include file='include/header.tpl'}
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>{$data->video->title}</h1>
        </div>
        <div class="panel-body">
            <div class="panel-group">
                <video controls src="/videos/{$data->video->hash}">
                    Sorry, your browser doesn't support HTML5 videos.
                </video>
            </div>
            <div class="panel-group">
                <h5>Description:</h5>
                <p>{$data->video->description}</p>
            </div>
        </div>
    </div>
</div>
{include file='include/footer.tpl'}