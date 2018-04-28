<?php
$sitename = "Your employer profile";
require_once 'header.php';
/*$user = $_SESSION['employer'];*/
/*print_r($_SESSION);*/
/*$conn = new Database();
$query = "SELECT * FROM jjb_employers WHERE contact_email='$user'";
$result = $conn->execute_query($query);*/
/*
print_r($result->fetch_array());
*/

$employer = new Employer();
$contact_email = $_SESSION['employer'];
$employer_id = $employer->getEmployerID($contact_email);
$city = $employer->getCity($contact_email);
$contact_first_name = $employer->getContactFirstName($contact_email);
$contact_second_name = $employer->getContactSecondName($contact_email);
$tax_id = $employer->getTaxID($contact_email);
?>

<div class="container">
    <div class="col w-75 m-auto">
        <p class="text-dark">Company Tax ID: <?php echo $tax_id; ?></p>
        <p class="text-dark">Contact First Name: <?php echo $contact_first_name; ?></p>
        <p class="text-dark">Contact Last Name: <?php echo $contact_second_name; ?></p>
        <p class="text-dark">Contact Email: <?php echo $contact_email; ?></p>
        <p ><a href='removeaccount.php' class="text-danger"> Remove Account </a></p>
    </div>
</div>
<div class="container">
    <div class="col w-75 m-auto">
        <h3>Posted offers and applications:</h3>
            <?php
                $result = $employer->getPostings();
                for ($i = 0 ; $i < $result->num_rows ; $i++) :
                    $result->data_seek($i);
                    $array = $result->fetch_assoc();
                    foreach ($array as $key => $value) : ?>

                    <h6 class="text-dark"><?php echo $key. " : " . $value ; ?> </h6>

                    <?php endforeach; ?>

                    <?php
                    echo "<a href='reviewapplications.php?posting={$array['ID']}'>Review applications</a>";
                    echo "<br><br>";
                    endfor; ?>


    </div>
</div>


<?php require_once 'footer.php';

?>
