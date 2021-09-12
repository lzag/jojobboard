{extends file='layouts/main.tpl'}
{if $alert}
{block name=alert}
<div class="alert alert-{$alert->type} alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{$alert->message}</strong>
</div>
{/block}
{/if}
{block name=content}

<div class="container">
    <div class="row mt-3">
        <div class="col-sm-6 m-auto">
           <p>{show_session_alert()}</p>
            <h3>Please log in</h3>
            <form method="POST" action='/login'>
                <form-group>
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Your email address" class="form-control">
                </form-group>
                <br>
                <form-group>
                    <label for="password">Password</label>
                    <input type="password" name="pass" placeholder="Your password" class="form-control">
                    <small><span class="text-info"><a href="recover.php">Forgot your password? </a></span></small>
                </form-group>
                <div class="form-group form-check">
                    <input name="rememberMe" type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Keep me logged in on this machine</label>
                </div>
                <input type="submit" name="login" value="Log in" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

{/block}