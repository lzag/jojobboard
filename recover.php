<?php
$sitename = "Recover password";

require_once 'header.php';

?>

<div class="container">
<div class="row">
<div class="col-sm-6 m-auto">
<?php User::recover_password(); ?>
<form method="post" action='recover.php'>
<form-group>
    <label for="email">Please introduce your email. The reset link will be sent there.</label>
    <input type="text" name="email" placeholder="Your email address" class="form-control">
</form-group>
<br>
<input type="hidden" name="token" value="<?php echo generate_token(); ?>">
<input type="submit" name="reset" value="Reset Password" class="btn btn-primary">
</form>

</div>
</div>
</div>
<?php
require_once 'footer.php';
?>
