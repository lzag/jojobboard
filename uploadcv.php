<?php
$sitename = "Upload CV";
require_once 'header.php';
?>
<div class="container">
<div class="col-sm-9 m-auto">
<?php
if (isset($_SESSION['user'])) {
    if (isset($_FILES['CV'])) {
        $conn = new Database;
        $query = "SELECT user_id FROM jjb_users WHERE email='".$_SESSION['user']."'" ;
        $result = $conn->execute_query($query);
        if ($result->num_rows){
            $user_row = $result->fetch_array(MYSQLI_ASSOC);
            $user_id = $user_row['user_id'];
            $filename = $_FILES['CV']['name'];
            if (!move_uploaded_file($_FILES['CV']['tmp_name'], "./uploads/$user_id"."_"."$filename"))
            {

                echo "<span class='text-danger'>Couldn't upload the file</span>"; }
            else {
                $filepath = "./uploads/$user_id"."_"."$filename";
                $query_CV = "UPDATE jjb_users SET cv_file='$filepath' WHERE email='".$_SESSION['user']."'";
                $result_upl = $conn->execute_query($query_CV);
                if ($result_upl) echo "<span class='text-success'>File <a href='$filepath'>". $filename ."</a> uploaded successfully</span>";
                require_once 'footer.php';
                die;
                }
        }
        }

        } else die("You are not logged in");



?>


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
