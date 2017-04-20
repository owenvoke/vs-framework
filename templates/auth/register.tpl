{include file='include/header.tpl'}
<div class="container">
    <h1>Sign Up</h1>
    <form action="" method="post">
        <p class="help-block">Already have an account? Try <a href="/login">logging in</a>.</p>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{$data->username}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{$data->email}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm">
        </div>
        <div class="form-group">
            {if !$data->response}<p class="text-danger help-block">An error occurred, perhaps you already have an account?</p>{/if}
            <p class="help-block">By signing up you agree to the <a href="/tos" target="_blank">Terms of Service</a> and the <a href="/privacy" target="_blank">Privacy Policy</a>.</p>
        </div>
        <input class="btn btn-default" type="submit" value="Sign Up">
    </form>
</div>
{include file='include/footer.tpl'}