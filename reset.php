<?php
$sitename = "Index";

require_once 'header.php';
?>

<div class="container">
<div class="row">
<div class="col-sm-6 m-auto">
<?php if(User::reset_password()) :; ?>

<form method="post" action='login.php'>
<form-group>
    <label for="password">New password</label>
    <input type="password" name="password" placeholder="Please input your new password" class="form-control">
</form-group>
<br>
<form-group>
    <label for="confirm_password">Confirm new password</label>
    <input type="password" name="confirm_password" placeholder="Please confirm your password" class="form-control">
    <span class="text-info"><a href="recover.php">Forgot your password? </a></span>
</form-group>
<br>
<br>
<input type="submit" name="login" value="Log in" class="btn btn-primary">
</form>

<?php endif; ?>

</div>
</div>
</div>

<?
require_once 'footer.php';
?>
