<?php require_once 'header.php'; ?>

<?php $user->uploadCV(); ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-sm-8 m-auto">
            <form method="post" action="uploadcv.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file_upload">Please select your CV file</label>
                    <input type="file" name="CV" class="form-control" id="file_upload">
                    <small>Only files in PDF or DOC format allowed</small>
                </div>
                <input type="submit" value="Upload CV" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
