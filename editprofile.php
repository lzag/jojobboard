<?php require_once 'header.php'; ?>

<?php
if (isset($_FILES['photo'])) {
    if ($_FILES['photo']['error'] == 0 ) {
        if (getimagesize($_FILES['photo']['tmp_name'])) {
            $final_path = "users/images/photo_" . $user->getProperty('user_id');
            move_uploaded_file($_FILES['photo']['tmp_name'], $final_path );
            show_alert("Photo uploaded successfully", "success");
    } else {
        show_alert("The uploaded file is not an image, please upload a jpg/gif/png file.");
    }
    } elseif ($_FILES['photo']['error'] != 4 ) {
        show_alert("There has been an error uploading the file", "danger");
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    $query = "UPDATE users SET first_name= ?, second_name= ?, title= ?, bio= ?, email= ?";
    $query .= " WHERE user_id = ?";
    $stmt = $db->con->prepare($query);
    $stmt->execute(array($_POST['first_name'], $_POST['last_name'], $_POST['title'], $_POST['bio'], $_POST['email'], $_POST['user_id']));
    if ($stmt->rowCount()) {
        show_alert("Details updated", "success");
    }
}
$user = new User;
?>

<div class="container">
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <form method="POST" action="editprofile.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="userEmail">Email address</label>
                    <input name="email" type="email" class="form-control" id="userEmail" aria-describedby="emailHelp" value="<?= $user->getProperty('email') ?>">
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
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control" id="title" value="<?= $user->getProperty('title') ?>">
                </div>
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea name="bio" id="bio" cols="6" rows="5" class="form-control"><?= $user->getProperty('bio') ?></textarea>
                </div>
                <div class="form-group">
                    <label for="CV">CV</label>
                    <input type="text" class="form-control" id="CV" placeholder="<?= $user->getProperty('cv_file') ?>">
                </div>
                Current photo: <br>
                <img class="img-fluid" width="140px" src="users/images/photo_<?= $user->getProperty('user_id') ?>">
                <div class="form-group">
                    <label for="photo">Upload new photo:</label>
                    <input name="photo" type="file" class="form-control" id="photo">
                </div>
                <input name="user_id" type="hidden" value="<?= $user->getProperty('user_id') ?>">
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
