<?php


require_once 'header.php';



?>

    <div class="container">
        <div class="col w-50 m-auto">
           <?php User::register_user(); ?>
           <?php User::activate_user(); ?>
            <form method="post" action='registeruser.php'>
            <h3 class="form-header">Please provide us with your data to register a new user: </h3>
                <div class="form-group">
                    <label for="first_name">Name:</label>
                    <input type="text" name="first_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="second_name">Surname:</label>
                    <input type="text" name="second_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="pass" class="form-control">
                </div>
                <input type="hidden" name="IP" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" class="form-control">
                <input type='submit' value="Create User" class="btn btn-primary form-control">
            </form>
        </div>
    </div>

<?php require_once 'footer.php'; ?>
