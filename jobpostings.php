<?php
$sitename = "Index of Jobs";

/** Files that are required to setting the website **/

require_once 'header.php';

$user = new User();
$conn = new Database();
$filtered = isset($_GET['posting_id']);

# if ($conn->connect_error) die("The connection failed".$conn->connect_error);

$query_post = "SELECT a.posting_id as 'Posting ID', a.title as 'Job Title',b.company_name as 'Company', a.description as 'Job Description',       a.time_posted as 'Posted on:'";
$query_post .= " FROM jjb_postings a INNER JOIN jjb_employers b ON a.employer_id=b.employer_id";
$filtered ? $query_post .= " WHERE a.posting_id=".$_GET['posting_id'] : "" ;
(isset($_GET['order'])) ? $query_post .= " ORDER BY ". $_GET['order'] . " desc" : "" ;
$result = $conn->execute_query($query_post);
# if(!$result_post) die($conn->connect_error);
$rows = $result->num_rows;


        /****** PAGINATION CODE THAT DOESN'T WORK
        $pagesnr = ceil($rows / 5);
        if (isset($_GET['page'])) {
            echo "<div align='center'>Pages: ";
                for ($i=1; $i <= $pagesnr ; $i++){
                echo "<a href='jobpostings.php?page=$i'>$i</a> | ";
            }

            $post_begin = 1 + 5 * ($_GET['page'] - 1) ;
                    (($post_begin + 4) > $rows ) ? $post_end = $rows : $post_end = $post_begin + 4 ;
                echo "<div align='center'>Results from $post_begin until $post_end out of $rows</div>";
            } else {
                $post_begin = 1;
                $post_end = $rows;
                echo "<div align='center'>Showing all results</div>";
            }*/
?>

<div class="container">
<div class="col w-75 m-auto">
<p>Order by: <a href='jobpostings.php?order=time_posted'>Date</a> | <a href='jobpostings.php?order=posting_id'>Relevance</a></p>
</div>
</div>
<div class="container">

<?php
    for ($j=0; $j < $rows ; ++$j) :

    $result->data_seek($j);
    $row = $result->fetch_assoc();
    $status = $user->getAppStatus($row['Posting ID']);
    ?>

    <div class="card w-75 mx-auto my-2">
        <div class="card-body">
            <h3 class="card-title">
                <?php echo $row['Job Title']; ?>
            </h3>
            <h6 class="card-subtitle mb-2 text-muted">Posted by:
                <?php echo $row['Company']; ?>
            </h6>
            <p class="card-text">
                <?php echo $row['Job Description']; ?>
            </p>
            <?php if (isset($_SESSION['user']) && ($status)) :
             echo "<h5 class='text-info'>Status: $status</h5>";
        else : ?>
            <form action="<?php echo $filtered ? "application.php" : "jobpostings.php"; ?>" method="get">
                <input type="hidden" name="posting_id" value="<?php echo $row['Posting ID']; ?>">
                <input type="submit" value="<?php echo $filtered ? "Apply" : "See Details"; ?>" class="btn btn-primary">
            </form>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <h6 class="text-secondary">Posting ID:
                <?php echo $row['Posting ID']; ?>
            </h6>
            <h6 class="text-secondary">Posted on:
                <?php echo date("D d F Y",strtotime($row['Posted on:'])); ?>
            </h6>

        </div>
    </div>

    <?php
    endfor;
    $conn->close();
    ?>

    <div class="col w-75 m-auto">
    <?php
    echo $filtered ? '<a href="jobpostings.php">Go back to all</a><br>' : "";
    ?>
    </div>

</div>

<?php
require_once 'footer.php';

?>
