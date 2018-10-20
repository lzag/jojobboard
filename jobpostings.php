<?php require_once 'header.php'; ?>



<div class="container">

    <div class="row">
        <div class="col-8 m-auto">
            <h3 class="text-center mb-5 mt-3">Search for the job you want!</h3>
            <form action="jobpostings.php" method="get">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="keyword">Keywords: </label>
                        <input type="text" class="form-control" id="keyword" name="keyword" value="<?= echoGet('keyword') ?>">
                    </div>
                    <div class="form-group col">
                        <label for="location">Location: </label>
                        <input type="text" class="form-control" id="location" name="location" value="<?= echoGet('location') ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="salary_min">Salary min:</label>
                        <input type="text" class="form-control" id="salary_min" name="salary_min" value="<?= echoGet('salary_min') ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="salary_max">Salary max:</label>
                        <input type="text" class="form-control" id="salary_max" name="salary_max" value="<?= echoGet('salary_max') ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="order">Order by</label>
                        <input type="text" class="form-control" id="order" name="order" value="<?= echoGet('order') ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="order">Per page</label>
                        <input name="per_page" type="text" class="form-control" id="order" name="order" value="5">
                    </div>
                </div>
                <div class="form-row">
                    <input type="submit" name="submit" value="Search for jobs" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>

    <?php

// GET THE RESULTS

//if(!isset($_GET['id'])) {
//    $local_hits = $results_local ? count($results_local) : 0;
//    $results_backfill = JobPost::get_backfill(100 - $local_hits);
//    $backfill_hits = $results_backfill ? $results_backfill->hits: 0;
//}
    ?>
    <!--
    <div class="row">
        <div class="col-8 m-auto">
            We've found
            <?= $local_hits ?> local and
            <?= $backfill_hits ?> external results for your query
        </div>
    </div>
-->
    <div class="row">
        <div class="col-8 m-auto">
            <?php $results = showResults() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-8 m-auto">

            <?php
         //echo isset($_GET["id"]) ? '<a href="jobpostings.php">Go back to all</a><br>' : ""; ?>
         <?php pagination($results['total_hits'],$_GET['per_page']);?>
        </div>
    </div>

    <div class="row">
        <div class="col-8 m-auto">
            <?php
if(array_key_exists('local',$results)) :
        foreach($results['local'] as $row) :
        $status = $user->getAppStatus($row['posting_id']);
?>

            <div class="card mx-auto my-2">
                <div class="card-body">
                    <h3 class="card-title">
                        <?php echo $row['title']; ?>
                    </h3>
                    <h6 class="card-subtitle mb-2 text-muted">Posted by:
                        <?php echo $row['company_name']; ?>
                    </h6>
                    <p class="card-text">
                        <?php echo $row['description']; ?>
                    </p>
                    <?php if (isset($_SESSION['user']) && ($status)) :
             echo "<h5 class='text-info'>Status: <span class='badge badge-info'>$status</span></h5>";
        else : ?>
                    <form action="<?php echo isset($_GET[" id"]) ? "application.php" : "jobpostings.php" ; ?>" method="get">
                        <input type="hidden" name="id" value="<?php echo $row['posting_id']; ?>">
                        <input type="submit" value="<?php echo isset($_GET[" id"]) ? "Apply" : "See Details" ; ?>" class="btn btn-primary">
                    </form>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <h6 class="text-secondary">Posting ID:
                        <?php echo $row['posting_id']; ?>
                    </h6>
                    <h6 class="text-secondary">Posted on:
                        <?php echo date("D d F Y",strtotime($row['time_posted'])); ?>
                    </h6>

                </div>
            </div>

            <?php
    endforeach;
endif;
?>

            <!--    GET THE BACKFILL OFFERS -->
            <?php
if(array_key_exists('foreign',$results)) :
    foreach($results['foreign'] as $value) :
?>

            <div class="card mx-auto my-2">
                <div class="card-body">
                    <h3 class="card-title">
                        <?php echo $value->title; ?>
                    </h3>
                    <h6 class="card-subtitle mb-2 text-muted">Posted by:
                        <?php echo $value->company; ?>
                    </h6>
                    <p class="card-text">
                        <?php echo $value->description; ?>
                    </p>
                    <a href="<?php echo $value->url; ?>" class="btn btn-primary">See Details</a>
                </div>
                <div class="card-footer">
                    <h6 class="text-secondary">Site:
                        <?php echo $value->site; ?>
                    </h6>
                    <h6 class="text-secondary">Posted on:
                        <?php echo date("D d F Y",strtotime($value->date)); ?>
                    </h6>

                </div>
            </div>

            <?php
    endforeach;
endif;
?>
        </div>
    </div>

    <div class="container">
        <div class="col w-75 m-auto">
            <p>Order by:

                <a href='<?php /*JobPost::add_url_filter("time_posted");*/ ?>'>Date</a>
                <a href='<?php /*JobPost::add_url_filter("salary");*/ ?>'>Salary</a>

            </p>
        </div>
    </div>

</div>

<?php require_once 'footer.php'; ?>
