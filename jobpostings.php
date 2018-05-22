<?php
$sitename = "Index of Jobs";

/** Files that are required to setting the website **/

require_once 'header.php';

# if(!$result_post) die($conn->connect_error);

?>

<div class="container">
<div class="col w-75 m-auto">
<p>Order by:
<a href='<?php JobPost::add_url_filter("time_posted"); ?>'>Date</a>
<a href='<?php JobPost::add_url_filter("salary"); ?>'>Salary</a>
</p>
</div>
</div>
<div class="container">

<form action="jobpostings.php" method="get">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="keyword">Keywords: </label>
            <input type="text" class="form-control" id="keyword" name="keyword">
        </div>
        <div class="form-group col-md-3">
            <label for="location">Location: </label>
            <input type="text" class="form-control" id="location" name="location">
        </div>
        <div class="form-group col-md-1">
            <label for="salary_min">Salary min:</label>
            <input type="text" class="form-control" id="salary_min" name="salary_min">
        </div>
        <div class="form-group col-md-1">
            <label for="salary_max">Salary max:</label>
            <input type="text" class="form-control" id="salary_max" name="salary_max">
        </div>
        <div class="form-group col-md-3">
            <label for="order">Order by</label>
            <input type="text" class="form-control" id="order" name="order">
        </div>
    </div>
    <div class="form-row">
        <input type="submit" name="submit" value="Search for jobs" class="btn btn-primary">
    </div>
</form>

<?php

// GET THE RESULTS
$results_local = JobPost::get_posts();

if(!isset($_GET['id'])) {
$local_hits = $results_local ? $results_local->num_rows : 0;
$results_backfill = JobPost::get_backfill(100 - $local_hits);
$backfill_hits = $results_backfill ? $results_backfill->hits: 0;

echo "We've found $local_hits local and $backfill_hits external results for your query";
}
    ?>

<?php


    if($results_local) :
    while($row = $results_local->fetch_assoc()) :

    $status = $user->getAppStatus($row['posting_id']);
    ?>

    <div class="card w-75 mx-auto my-2">
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
            <form action="<?php echo isset($_GET["id"]) ? "application.php" : "jobpostings.php"; ?>" method="get">
                <input type="hidden" name="id" value="<?php echo $row['posting_id']; ?>">
                <input type="submit" value="<?php echo isset($_GET["id"]) ? "Apply" : "See Details"; ?>" class="btn btn-primary">
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
    endwhile;
    endif;
    ?>


<!--    GET THE BACKFILL OFFERS -->
    <?php


    if(isset($results_backfill->hits)) :
    foreach($results_backfill->jobs as $value) :
    ?>

    <div class="card w-75 mx-auto my-2">
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
            <h6 class="text-secondary">Site: <?php echo $value->site; ?>
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

    <div class="col w-75 m-auto">


    <?php
    //echo isset($_GET["id"]) ? '<a href="jobpostings.php">Go back to all</a><br>' : "";
    pagination(100,10);
    ?>
    </div>

</div>

<?php
require_once 'footer.php';

?>
