<?php

require_once 'header.php';

$msg = "Please input your login data:";


?>

<div class="container">
<div class="row">
<div class="col-sm-6 m-auto">
<?php User::activate_user(); ?>
<h4><?php login(); ?></h4>

<form method="post" action='login.php'>
<form-group>
    <label for="email">Email</label>
    <input type="text" name="email" placeholder="Your email address" class="form-control">
</form-group>
<br>
<form-group>
    <label for="password">Password</label>
    <input type="password" name="pass" placeholder="Your password" class="form-control">
    <span class="text-info"><a href="recover.php">Forgot your password? </a></span>
</form-group>
<br>
<br>
<input type="submit" name="login" value="Log in" class="btn btn-primary">
</form>

</div>
</div>
</div>

<?php
require_once 'footer.php';
?>
