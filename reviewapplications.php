<?php
$sitename = 'Application Review';
require_once 'header.php';

$employer = new Employer();
$pid=$_GET['posting'];
if (isset($_GET['review']) && isset($_GET['appid']) ) {
    $status = $_GET['review'];
    $appid= $_GET['appid'];
    $employer->reviewApp($pid,$status,$appid);
    echo "Application reviewed. Status: {$_GET['review']}<br>";
    echo "<a href='reviewapplications.php?posting=$pid'> Go back</a>";
}
else {
$result = $employer->getApplications($pid);
for ($i = 0 ; $i < $result->num_rows; $i++) {
    $result->data_seek($i);
    $arr = $result->fetch_assoc();
        foreach ($arr as $key => $v) {
            if ($key == 'Download CV') echo "$key : <a href='$v'> Link</a> <br>";
            else echo "$key : $v <br>";

        }
    $appid=$arr['Application ID'];
    echo "Review: <a href='reviewapplications.php?posting=$pid&appid=$appid&review=IN%20PROCESS' style='color:green'>APPROVE</a> | <a href='reviewapplications.php?posting=$pid&appid=$appid&review=DENIED' style='color:red'>DENY</a>";
    echo "<br><br>";

}
}
require_once 'footer.php';
?>
