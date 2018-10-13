<?php

require_once 'header.php';
?>

<div class="container">
<div class="row">
<div class="col-sm-6 m-auto">
<?php if(User::reset_password()) :; ?>

<form method="post" action='reset.php?email=<?php echo isset($_GET['email']) ? $_GET['email'] : ""; ?>'>
<form-group>
    <label for="password">New password</label>
    <input type="password" name="password" placeholder="Please input your new password" class="form-control">
</form-group>
<br>
<form-group>
    <label for="confirm_password">Confirm new password</label>
    <input type="password" name="confirm_password" placeholder="Please confirm your password" class="form-control">
</form-group>
<br>
<br>
<input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ""; ?>">
<input type="submit" name="reset" value="Reset password" class="btn btn-primary">
</form>

<?php endif; ?>

</div>
</div>
</div>

<?php
require_once 'footer.php';
?>
