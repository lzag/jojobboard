 <?php
$sitename = "User profile";
require_once 'header.php';
$user = new User();
$email = $_SESSION['user'];
$first_name = $user->getFirstName($email);
$second_name = $user->getSecondName($email);
$email = $user->getEmail($email);
$cvfile = $user->getCV($email);

?>
<div class="container">
    <div class="col w-75 m-auto">
        <p class="text-dark">Name: <?php echo $first_name; ?></p>
        <p class="text-dark">Last Name: <?php echo $second_name; ?></p>
        <p class="text-dark">Email address: <?php echo $email; ?></p>
        <p class="text-dark">CV file:<a href="<?php echo $cvfile; ?>"> Link </a></p>
        <p ><a href='removeaccount.php' class="text-danger"> Remove Account </a></p>
    </div>
</div>
<div class="container">
    <div class="col w-75 m-auto">

    <h3>Applications:</h3>
<?php
$result = $user->fetchApplications($email);
for ($i = 0 ; $i < $result->num_rows ; $i++) :
    $result->data_seek($i);
    $array = $result->fetch_assoc();
    foreach ($array as $key => $value) :
    ?>

    <h6 class="text-dark"><?php echo $key. " : " . $value ; ?> </h6>

    <?php endforeach; ?>

    <?php
    echo "<a href='jobpostings.php?posting_id={$array['ID']}'>See posting details</a><br>";
    echo "<a href='withdraw.php?posting={$array['ID']}'>Withdraw application</a>";
    echo "<br><br>";

endfor; ?>

    </div>
</div>
<?php
require_once 'footer.php';
?>
