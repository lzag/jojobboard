{extends file='layouts/main.tpl'}
{block name=content}
{if $user }
{show_session_alert() }
{include file='userprofile.tpl' }

{elseif $employer }
{show_session_alert() }
{include file='employerprofile.tpl' }
{else}

<div class="row p-3 justify-content-center">

    <div class="col-md-3">

        <h3><strong>Welcome to JoJobBoard!</strong></h3>

        Please sign in to your account to access thousands of job offers!

    </div>
    <div class="col-md-3">
        <form action="/login" method="POST">
            <div class="form-group">
                <label for="userEmail">Email address</label>
                <input type="email" name="email" class="form-control" id="userEmail" aria-describedby="emailHelp" placeholder="Enter your email">
                <small id="emailHelp" class="form-text text-muted">You don't have an account? Go on and <a href="registeruser.php">create one</a>!</small>
            </div>
            <div class="form-group">
                <label for="userPassword">Password</label>
                <input type="password" name="pass" class="form-control" id="userPassword" placeholder="Password">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="stayLoggedIn">
                <label class="form-check-label" for="stayLoggedIn">Keep me logged in</label>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Log in</button>
        </form>
    </div>

</div>

{/if}
{/block}
