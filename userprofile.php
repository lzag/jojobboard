 <?php
$sitename = "User profile";
require_once 'header.php';
$user = new User();
$email = $_SESSION['user'];
$first_name = $user->getFirstName($email);
$second_name = $user->getSecondName($email);
$email = $user->getEmail($email);
$cvfile = $user->getCV($email);
$result = $user->fetchApplications($email);
print_r($result);

?>
<div class="container" id="userdata">
    <div class="col w-75 m-auto">
        <p class="text-dark">Name: <?php echo $first_name; ?></p>
        <p class="text-dark">Last Name: <?php echo $second_name; ?></p>
        <p class="text-dark">Email address: <?php echo $email; ?></p>
        <p class="text-dark">CV file:<a href="<?php echo $cvfile; ?>"> Link </a></p>
        <p ><a id="remove-user-btn" href='removeaccount.php' class="text-danger"> Remove Account </a></p>
        <input type="text" id="BgSelect">
        <div class="btn btn-primary" id="changeBgColor">Rotate Background Color</div>
        <br>
    </div>
</div>
<div class="container">
    <div class="col w-75 m-auto">

    <h3>Applications:</h3>

<?php

for ($i = 0 ; $i < $result->num_rows ; $i++) :
    $result->data_seek($i);
    $array = $result->fetch_assoc();

    foreach ($array as $key => $value) :
    ?>

    <h6 class="text-dark"><?php echo $key. " : " . $value ; ?> </h6>

    <?php endforeach; ?>

    <a href='jobpostings.php?posting_id=<?php echo $array['ID']; ?>'>See posting details</a><br>
    <a href='withdraw.php?posting=<?php echo $array['ID']; ?>'>Withdraw application</a>
    <br><br>

<?php endfor; ?>

    </div>
</div>

<?php require_once 'footer.php'; ?>
