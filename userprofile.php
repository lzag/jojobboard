<?php require_once 'header.php'; ?>



<div class="container">
    <div class="row justify-content-center mt-3">

        <!-- PROFILE COLUMN -->
        <div class="col-4 border">
            <h2 class="mb-0">Your Profile</h2>
            <p class="mt-0">
                <a href=""><small>Edit Profile</small></a>
            </p>
            <img src="https://via.placeholder.com/140x140">
            <p>
                <h5>
                    <?= $user->getProperty('first_name') ?>
                    <?= $user->getProperty('second_name') ?>
                </h5>
            </p>
            <p>
                <?= $user->getProperty('summary') ?>
            </p>
            <p>CV link:

                <?php if ($user->getProperty('cv_file')) : ?> {

                <a href="<?= $user->getProperty('cv_file') ?>">Link</a>

                <?php else : ?>

                <a class="text-danger" href="uploadcv.php">Please upload your CV</a>

                <?php endif; ?>

            </p>
            <p>Email:
                <?= $user->getProperty('email') ?>
            </p>
            <p>Bio:</p>
        </div>

        <!-- APPLICATION COLUMN -->
        <div class="col-4">
            <h2>Applications</h2>

            <?php if ($user->getProperty('applications')) : ?>
            <?php print_r ($user->getProperty('applications'))  ?>
            <?php foreach ($user->getProperty('applications') as $application) : ?>

            Position:
            <?= $application['title'] ?> <br>
            Company:
            <?= $application['company_name'] ?> <br>
            Applied on:
            <?= $application['application_time'] ?> <br>
            Status:
            <?= $application['status'] ?> <br>
            See details Withdraw <br>

            <div class="btn btn-outline-primary my-1"><a href='jobpostings.php?posting_id=<?= $application[' application_id']; ?>'>See posting details</a></div><br>
            <div class="btn btn-outline-danger my-1"><a class="text-danger" href='withdraw.php?posting=<?= $application[' application_id']; ?>'>Withdraw Application</a></div>

            <?php endforeach ?>

            <?php else : ?>

            You have not applied to any jobs so far! <br>

            Check the latest offers now!

            <?php endif; ?>

        </div>
    </div>
</div>



<?php require_once 'footer.php'; ?>
