<?php

$sitename = "User profile";
require_once 'header.php';

?>

    <div class="container" id="userdata">
        <div class="col w-75 m-auto">
            <p class="text-dark">Name:
                <?php echo $user->getProperty('first_name'); ?>
            </p>
            <p class="text-dark">Last Name:
                <?php echo $user->getProperty('second_name'); ?>
            </p>
            <p class="text-dark">Email address:
                <?php echo $user->getProperty('email'); ?>
            </p>
            <p class="text-dark">CV file:

            <?php
        if ($user->getProperty('cv_file')) {

            echo "<a href='{$user->getProperty('cv_file')}'>Link</a>";

        } else {

            echo "<a class='text-danger' href='uploadcv.php'>Please upload your CV</a>";

        }
        ?>

            </p>
            <p><a id="remove-user-btn" href='removeaccount.php' class="text-danger"> Remove Account </a></p>
            <br>
        </div>
    </div>



    <div class="container">
        <div class="col w-75 m-auto">
            <h3>Applications:</h3>

            <?php
    $result = $user->fetchApplications();
    for ($i = 0 ; $i < $result->num_rows ; $i++) :
    $result->data_seek($i);
    $array = $result->fetch_assoc();
?>
            <div class="d-block my-5 ">
                <h5>Title:
                    <span class="text-secondary"><?php echo $array['title']; ?></span></h5>
                <h5>Company:
                    <span class="text-secondary"><?php echo $array['company_name']; ?></span></h5>

                Applied on:
                <?php echo $array['application_time']; ?> <br> Status:
                <?php echo $array['status']; ?><br>

                <div class="btn btn-outline-primary my-1"><a href='jobpostings.php?posting_id=<?php echo $array[' application_id ']; ?>'>See posting details</a></div><br>
                <div class="btn btn-outline-danger my-1"><a class="text-danger" href='withdraw.php?posting=<?php echo $array[' application_id ']; ?>'>Withdraw Application</a></div>

            </div>

            <?php endfor; ?>

        </div>
    </div>

    <?php require_once 'footer.php'; ?>
