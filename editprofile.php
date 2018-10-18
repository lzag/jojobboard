<?php require_once 'header.php'; ?>

<?php
if (isset($_FILES['photo'])) {
    if (getimagesize($_FILES['photo']['tmp_name'])) {
        $final_path = "users/images/photo_" . $user->getProperty('user_id');
        move_uploaded_file($_FILES['photo']['tmp_name'], $final_path );
    } else {
        echo "The uploaded file is not an image, please upload a jpg/gif/png file.";
    }
}
if (isset($_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['password'])) {
    $query = "UPDATE users SET first_name= ?, second_name= ?, email= ?, password= ?";
    $query .= " WHERE user_id = ?";
    $stmt = $db->con->prepare($query);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->execute(array($_POST['first_name'], $_POST['last_name'], $_POST['email'], $pass, $_POST['user_id']));
    if ($stmt->rowCount()) {
        echo "Details updated";
        $user = new User;
    }
}

?>

<div class="container">
    <form method="POST" action="editprofile.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="userEmail">Email address</label>
            <input name="email" type="email" class="form-control" id="userEmail" aria-describedby="emailHelp" value="<?= $user->getProperty('email') ?>">
        </div>
        <div class="form-group">
            <label for="userPassword">Password</label>
            <input name="password" type="password" class="form-control" id="userPassword" value="<?= $user->getProperty('password') ?>">
        </div>
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input name="first_name" type="text" class="form-control" id="firstName" value="<?= $user->getProperty('first_name') ?>">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input name="last_name" type="text" class="form-control" id="lastName" value="<?= $user->getProperty('second_name') ?>">
        </div>
        <div class="form-group">
            <label for="CV">CV</label>
            <!--            <input type="file" class="form-control" id="CV" placeholder="<?= $user->getProperty('cv_file') ?>">-->
        </div>
        Current photo:
        <img class="img-fluid" width="140px" src="users/images/photo_<?= $user->getProperty('user_id') ?>">
        <div class="form-group">
            <label for="photo">Upload new Photo</label>
            <input name="photo" type="file" class="form-control" id="photo">
        </div>
        <input name="user_id" type="hidden" value="<?= $user->getProperty('user_id') ?>">
        <button type="submit" class="btn btn-primary">Update</button>
    </form>


</div>

<?php require_once 'footer.php'; ?>
