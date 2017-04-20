<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><span class="fa fa-fw fa-play"></span> {VS\Config::APP_NAME}</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="/browse"><span class="fa fa-fw fa-video-camera"></span> Browse</a></li>
                <li><a href="/upload"><span class="fa fa-fw fa-upload"></span> Upload</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {if VS\User\Account::auth()}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {VS\User\Account::user('username')}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/profile"><span class="fa fa-fw fa-user"></span> My Channel</a></li>
                            <li><a href="/account"><span class="fa fa-fw fa-cogs"></span> Settings</a></li>
                            <li><a href="/logout"><span class="fa fa-fw fa-sign-out"></span> Logout</a></li>
                        </ul>
                    </li>
                {else}
                    <li><a href="/register">Sign Up</a></li>
                    <li><a href="/login">Log In</a></li>
                {/if}
            </ul>
        </div>
    </div>
</nav>