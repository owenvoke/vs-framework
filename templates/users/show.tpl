{include file='include/header.tpl'}
<div class="container">
    {if $data->user}
        <div class="col-md-12">
            <div class="panel panel-default clearfix">
                <img align="left" class="avatar margin-right-05" src="{$data->user->info->avatar}"
                     alt="{$data->user->username}">
                <div class="panel-group">
                    <div class="user-title">
                        <span class="username">{$data->user->username}</span>
                        <div class="pull-right btn-group">
                            <a class="btn btn-primary btn-sm margin-right-05 margin-top-05"
                               href="{if VS\User\Account::auth()}/subscribe/{$data->user->username}{else}/login{/if}">
                                {if VS\User\Account::auth()}
                                    <span class="fa fa-fw fa-plus"></span>
                                    Subscribe
                                {else}
                                    <span class="fa fa-fw fa-sign-in"></span>
                                    Login to subscribe
                                {/if}
                            </a>
                            {if VS\User\Account::auth()}
                                <a class="btn btn-warning btn-sm margin-right-05 margin-top-05"
                                   href="/actions/report/{$data->user->username}">
                                    <span class="fa fa-fw fa-flag"></span>
                                    Report
                                </a>
                            {/if}
                        </div>
                        <p>{$data->user->acl->name}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-fw fa-bars" aria-hidden="true"></i>
                        <b>About {$data->user->username}</b>
                    </h3>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="fa fa-fw fa-clock-o"></span> Joined: <span
                                class="pull-right">{$data->user->joined|absolute_time:'jS M Y'}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="fa fa-fw fa-film"></span> Videos: <span class="pull-right">20</span
                    </li>
                    {if !VS\User\Account::auth()}
                        <li class="list-group-item">
                            <a href="/register">Sign up</a> or
                            <a href="/login">log in</a> to add {$data->user->username} as a contact!
                        </li>
                    {/if}
                </ul>

            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-fw fa-id-card" aria-hidden="true"></i>
                        <b>Connect with {$data->user->username}</b>
                    </h3>
                </div>

                <div class="panel-body">
                    {if VS\User\Account::auth()}
                        <div class="btn-group btn-group-justified">
                            <a class="btn btn-default" href="/actions/friend/{$data->user->username}">
                                <span class="fa fa-fw fa-address-book"></span>
                                Add Contact
                            </a>
                            <a class="btn btn-default" href="/messenger/{$data->user->username}">
                                <span class="fa fa-fw fa-envelope" aria-hidden="true"></span>
                                Send Message
                            </a>
                        </div>
                        <div class="btn-group btn-group-justified">
                            <a class="btn btn-default" href="/actions/block/{$data->user->username}">
                                <span class="fa fa-fw fa-ban" aria-hidden="true"></span>
                                Block User
                            </a>
                        </div>
                    {else}
                        <div class="panel-group">
                            <a href="/register">Sign up</a> or
                            <a href="/login">log in</a> to connect with {$data->user->username}!
                        </div>
                    {/if}
                    <hr>
                    <strong>
                        Profile URL:
                    </strong>
                    <a href="/profile/{$data->user->username}">{"profile/`$data->user->username`"|url}</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="fa fa-fw fa-film"></span>
                        <b>New Videos</b>
                        <span class="pull-right">
                    <a href="/profile/{$data->user->username}/videos" class="unstyled">
                        <span class="fa fa-fw fa-video-camera"></span>
                        All videos
                    </a>
                </span>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="video-block home-videos">
                        <div class="row">
                            <div class="col-orient-ls col-sm-6 col-md-4">
                                {foreach $data->user->videos as $video}
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
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {else}
        <div class="panel-heading">
            <h1>User not found 😞</h1>
        </div>
        <div class="panel-body">
            <div class="panel-group">
                Sorry, this user doesn't seem to exist.
            </div>
        </div>
    {/if}
</div>
{include file='include/footer.tpl'}