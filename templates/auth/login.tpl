{include file='include/header.tpl'}
<div class="container">
    <h1>Login</h1>
    <form action="" method="post">
        <p class="help-block">Need an account? Try <a href="/register">signing up</a>.</p>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" id="password" name="password">
            <p class="help-block"><a href="/request_password">Request password?</a></p>
        </div>
        <input class="btn btn-default" type="submit" value="Log In">
    </form>
</div>
{include file='include/footer.tpl'}