<?php

require_once 'header.php';

$msg = "Please input your login data:";
User::activate_user();
login();
?>

<div class="container">
    <div class="row mt-3">
        <div class="col-sm-6 m-auto">
           <p><?= show_session_alert() ?></p>
            <h3>Please log in</h3>
            <form method="POST" action='login.php'>
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

<?php require_once 'footer.php'; ?>
