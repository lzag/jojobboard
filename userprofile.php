<?php
$sitename = "User profile";
require_once 'header.php';
$user = new User();
$email = $_SESSION['user'];
$first_name = $user->getFirstName($email);
$second_name = $user->getSecondName($email);
$email = $user->getEmail($email);
$cvfile = $user->getCV($email);



echo <<<_END
Name: $first_name <br>
Surname: $second_name <br>
Email address: $email <br>
CV file: <a href='$cvfile'> Link </a> <br>
<a href='removeaccount.php' style='color:red'> Remove Account </a>
<br>
<br>
Applications: <br><br>
_END;

$result = $user->fetchApplications($email);
for ($i = 0 ; $i < $result->num_rows ; $i++) {
    $result->data_seek($i);
    $array = $result->fetch_assoc();
    foreach ($array as $key => $value) {
        echo "$key : $value <br>";

    }
    echo "<a href='jobpostings.php?posting_id={$array['ID']}'>See posting details</a><br>";
    echo "<a href='withdraw.php?posting={$array['ID']}'>Withdraw application</a>";
    echo "<br><br>";
}

    ?>
<?php
require_once 'footer.php';
?>
