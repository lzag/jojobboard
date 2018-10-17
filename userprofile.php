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

                    <h5 class="mt-3 mb-0">
                        <?= $user->getProperty('first_name') ?>
                        <?= $user->getProperty('second_name') ?>
                    </h5>

            <p class="text-secondary">
                <?= $user->getProperty('summary') ?>
            </p>
            <p>CV link:

                <?php if ($user->getProperty('cv_file')) : ?> {

                <a href="<?= $user->getProperty('cv_file') ?>">Link</a>

                <?php else : ?>

                <a class="text-danger" href="uploadcv.php">Upload your CV</a>

                <?php endif; ?>

            </p>
            <p>Email:
                <?= $user->getProperty('email') ?>
            </p>
            <h6>Bio:</h6>
            <p> <?= $user->getProperty('bio') ?></p>
        </div>

        <!-- APPLICATION COLUMN -->
        <div class="col-8">
            <h2>Applications</h2>

            <div class="mb-4">
                <?php if ($user->getProperty('applications')) : ?>

                <small>Total:
                    <?= count($user->getProperty('applications')) ?></small>

                <?php foreach ($user->getProperty('applications') as $application) : ?>

                <h4>
                    Position:
                    <?= $application['title'] ?>
                </h4>
                <h6>
                    Company:
                    <?= $application['company_name'] ?>
                </h6>
                <p class="mt-0 pt-0 text-secondary">
                    <small>Applied on:
                        <?= $application['application_time'] ?></small>
                </p>
                Status:
                <strong><?= $application['status'] ?></strong> <br>

                <a class="btn btn-outline-primary my-1 py-1" href='jobpostings.php?posting_id=<?= $application[' application_id']; ?>'>See details</a>
                <a class="text-danger btn btn-outline-danger my-1 py-1" href='withdraw.php?posting=<?= $application[' application_id']; ?>'>Withdraw</a><br>
            </div>

            <?php endforeach ?>

            <?php else : ?>

            You have not applied to any jobs so far! <br>

            Check the latest offers now!

            <?php endif; ?>

        </div>
    </div>
</div>



<?php require_once 'footer.php'; ?>
