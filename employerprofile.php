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


echo <<<_END
Company Tax ID: $tax_id <br>
Contact first name: $contact_first_name <br>
Contact second name: $contact_second_name <br>
Contact email address: $contact_email <br>
<a href='removeaccount.php' style='color:red'> Remove Account </a>
<br>
<br>

Offers and Applications:<br><br>
_END;

$result = $employer->getPostings();

for ($i = 0 ; $i < $result->num_rows ; $i++){
    $result->data_seek($i);
    $p_array = $result->fetch_assoc();
        foreach ($p_array as $key => $value) {
            echo "$key : $value <br>";
        }
    echo "<a href='reviewapplications.php?posting={$p_array['ID']}'>Review applications</a>";
    echo "<br><br>";
}



require_once 'footer.php';

?>
