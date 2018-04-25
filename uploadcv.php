<?php
$sitename = "Upload CV";
require_once 'header.php';
if (isset($_SESSION['user'])) {
    if (isset($_FILES['CV'])) {
        $conn = new Database;
        print_r(get_class_methods('Database'));
        $query = "SELECT user_id FROM jjb_users WHERE email='".$_SESSION['user']."'" ;
        $result = $conn->execute_query($query);
        if ($result->num_rows){
            $user_row = $result->fetch_array(MYSQLI_ASSOC);
            $user_id = $user_row['user_id'];
            $filename = $_FILES['CV']['name'];
            if (!move_uploaded_file($_FILES['CV']['tmp_name'], "./uploads/$user_id"."_"."$filename"))
            {

                echo "Couldn't upload the file"; }
            else {
                $filepath = "./uploads/$user_id"."_"."$filename";
                $query_CV = "UPDATE jjb_users SET cv_file='$filepath' WHERE email='".$_SESSION['user']."'";
                $result_upl = $conn->execute_query($query_CV);
                if ($result_upl) echo "Filename: ".$filename." uploaded";//  <a href='./uploads/$user_id"."_".$filename."'> here</a>";
                }
        }
        }

        } else die("You are not logged in");



?>
<form method="post" action="uploadcv.php" enctype="multipart/form-data">
    <input type="file" name="CV">
    <input type="submit" value="Upload CV">
</form>








<?php
    require_once 'footer.php';
?>
