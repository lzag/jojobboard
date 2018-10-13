<?php

/** Files that are required to setting the website **/
require_once 'header.php';

?>
<br>
<br>

<div align="center">
Please provide the details of the job posting.<br><br><br>
<form method="post" action="postjob.php" enctype="multipart/form-data">
    Title:<br> <input type="text" name="title"><br><br>
    Description: <br><textarea name="description" rows="10" columns="100"></textarea><br><br>
    <input type="submit" value="Submit Job Posting"><br><br>

</form>
</div>

<div align="center">

<?php
    echo "<br>";
    echo "<br>";
    if ($_POST) {
        if (isset($_POST['title'],$_POST['description']) &&
            !empty($_POST['title']) && !empty($_POST['description'])) {

                        $conn = new Database();
                        # if($conn->connect_error) die("Can't connect");
                        print_r(get_object_vars($conn));
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $employer = new Employer();
                        $employerid = $employer->employer_id;
                        $query = "INSERT INTO jjb_postings (title,description,employer_id) VALUES ('$title','$description','$employerid')";
                        $result = $conn->execute_query($query);
                        print_r(get_object_vars($conn));
                            if (!$result) die("<br>Database update failed :".$conn->error);
                        } else {
            echo "Please fill in all the information";

        } /*else {
        echo "Nothing submitted";
    }*/
        }
require_once 'footer.php';


?>
  </div>
