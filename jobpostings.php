<?php
$sitename = "Index of Jobs";

/** Files that are required to setting the website **/

require_once 'header.php';

$user = new User();
$conn = new Database();

# if ($conn->connect_error) die("The connection failed".$conn->connect_error);

if (isset($_GET['posting_id'])){
  $query_post = "SELECT a.posting_id as 'Posting ID', a.title as 'Job Title',b.company_name as 'Company', a.description as 'Job Description', a.time_posted as 'Posted on:' FROM jjb_postings a
INNER JOIN jjb_employers b ON a.employer_id=b.employer_id WHERE a.posting_id=".$_GET['posting_id'];
    $result_post = $conn->execute_query($query_post);
    # if(!$result_post) die($conn->connect_error);
    $row_post = $result_post->fetch_assoc();
    echo "<div align='center'>";
    echo '<h2>' . $row_post['Job Title'] . '</h2><br>';
    echo 'Posting ID: ' . $row_post['Posting ID'] . '<br>';
    echo 'Posting company: <br> '. $row_post['Company'] .  '<br>';
    echo 'Job description:<br> ' . $row_post['Job Description'] . '<br>';
    echo 'Posted on: ' . $row_post['Posted on:'] . '<br>';
    $status = $user->getAppStatus($row_post['Posting ID']);
        if (isset($_SESSION['user']) && ($status)) {
            echo "Status: $status<br><br>";
        }
    else {
    echo <<<_END
    <form action="application.php" method="GET">
    <input type="hidden" name="posting_id" value="{$_GET['posting_id']}">
    <input type="submit" value="Apply" class="btn btn-primary">
    </form>
_END;
    }
    echo '<a href="jobpostings.php">Go back to all</a><br>';

} else{

echo "Order by: <a href='jobpostings.php?order=time_posted'>Date</a> |  <a href='jobpostings.php?order=posting_id'>Relevance</a>";
if (isset($_GET['order'])) {
    $query = "SELECT a.posting_id as 'Posting ID', a.title as 'Job Title',b.company_name as 'Company', a.description as 'Job Description', a.time_posted as 'Posted on:' FROM jjb_postings a
INNER JOIN jjb_employers b ON a.employer_id=b.employer_id ORDER BY ". $_GET['order'] . " desc";
} else{
$query = "SELECT a.posting_id as 'Posting ID', a.title as 'Job Title',b.company_name as 'Company', a.description as 'Job Description', a.time_posted as 'Posted on:' FROM jjb_postings a
INNER JOIN jjb_employers b ON a.employer_id=b.employer_id";
    }
$result = $conn->execute_query($query);
# if(!$result) die($conn->connect_error);

/*print_r($result); echo "<br><br>";
echo gettype($result); */
/* print_r($result->data_seek(1)); echo "<br><br>";
print_r($result->data_seek(3)); echo "<br><br>";
var_dump($result->fetch_assoc()); echo "<br><br>"; */

/*for ($j=0; $j < $rows ; ++$j)
{
    $result->data_seek($j);
    echo 'User_ID: ' . $result->fetch_assoc()['user_id'] . '<br>';
    $result->data_seek($j);
    echo 'First Name: ' . $result->fetch_assoc()['first_name'] . '<br>';
    $result->data_seek($j);
    echo 'Second Name: ' . $result->fetch_assoc()['second_name'] . '<br>';
    $result->data_seek($j);
    echo 'Email: ' . $result->fetch_assoc()['email'] . '<br>';
    echo "<br>=====================<br>";
}*/

$rows = $result->num_rows;
$pagesnr = ceil($rows / 5);

    echo "</div><br>";

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
}

for ($j=$post_begin - 1; $j < $post_end ; ++$j)
{
    $result->data_seek($j);
    $row = $result->fetch_assoc();
    /*print_r($row); echo gettype($row);  */
    echo "<div align='center'>";
    echo '<h2>' . $row['Job Title'] . '</h2><br>';
    echo 'Posting ID: ' . $row['Posting ID'] . '<br>';
    echo 'Job description:<br> ' . $row['Job Description'] . '<br>';
    echo 'Posting company: <br> '. $row['Company'] .  '<br>';
    echo 'Posted on: ' . date("D d F Y",strtotime($row['Posted on:'])) . '<br>';
    $status = $user->getAppStatus($row['Posting ID']);
     if (isset($_SESSION['user']) && ($status)) {
            echo "Status: $status<br><br>";
        }
    else {
    echo<<<_END
    <form action="jobpostings.php" method="get">
    <input type="hidden" name="posting_id" value="{$row['Posting ID']}">
    <input type="submit" value="See Details" class="btn btn-primary">
    </form>
_END;
    }
     echo "<br>=====================<br></div>";
}


$result->close();
$conn->close();

}



require_once 'footer.php';


?>
