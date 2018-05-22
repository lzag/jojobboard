<?php
$sitename = "Upload CV";
require_once 'header.php';
?>

<?php $user->uploadCV(); ?>

    <div class="container">
        <div class="col-sm-9 m-auto">
                <form method="post" action="uploadcv.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file_upload">Please select your CV file</label>
                        <input type="file" name="CV" class="form-control" id="file_upload">
                    </div>
                    <input type="submit" value="Upload CV" class="btn btn-primary">
                </form>
        </div>
    </div>








    <?php
    require_once 'footer.php';
?>
