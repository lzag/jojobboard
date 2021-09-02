<?php require_once 'header.php'; ?>
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
        if (!empty($_POST['title']) && !empty($_POST['description'])) {
            $conn = new App\Database();
            $title = $_POST['title'];
            $description = $_POST['description'];
            $employer = new Employer();
            $employerid = $employer->employer_id;
            $query = "INSERT INTO postings (title,description,employer_id) VALUES ('$title','$description','$employerid')";
            var_dump($query);
            $result = $conn->con->query($query);
            if($result->rowCount()) {
                $msg = "Job offer added";
                show_alert($msg, "success");
            } else {
                die("<br>Database update failed :".$conn->error);
            }
        } else {
            echo "Please fill in all the information";
        }
    }
?>

<?php require_once 'footer.php'; ?>
