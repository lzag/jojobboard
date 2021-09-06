<?php

/** Files that are required to setting the website **/

require_once 'header.php';

$conn = new Database;
echo "<div align='center'>";

if ($conn->connect_error):
    die("The connection failed".$conn->connect_error);
else :
    echo "Connection success, fetching results... <br>=============<br>";
endif;

if (isset($_POST['delete_all'])){
$query_del_all="TRUNCATE users";
if ($result_del = $conn->query($query_del_all)) echo "Deleted all users"."<br>=============<br>";
    }

if (isset($_POST['delete_user']))
{
    $query_del="DELETE from users WHERE user_id=".$_POST['del_user_id'];
    if ($result_del = $conn->query($query_del)) echo "Deleted USER ID".$_POST['del_user_id']."<br>=============<br>";
}

echo "</div>";
$query = "SELECT * FROM users";
$result = $conn->query($query);
if(!$result) die($conn->connect_error);
/*print_r($result); echo "<br><br>";
echo gettype($result); */
$rows = $result->num_rows;
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
echo<<<_END
<div align="center">
<form action="userlist.php" method="post">
    <input type="hidden" name="delete_all">
    <input type="submit" value="DELETE ALL">
    </form>
</div>
_END;

for ($j=0; $j < $rows ; ++$j)
{
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    /*print_r($row); echo gettype($row);  */
    echo 'User_ID: ' . $row['user_id'] . '<br>';
    echo 'First Name: ' . $row['first_name'] . '<br>';
    echo 'Second Name: ' . $row['second_name'] . '<br>';
    echo 'Email: ' . $row['email'] . '<br>';
    echo 'IP address: ' . $row['ip_address'] . '<br>';
    echo <<<_END
    <form action="userlist.php" method="post">
    <input type="hidden" name="delete_user">
    <input type="hidden" name="del_user_id" value="{$row['user_id']}">
    <input type="submit" value="DELETE USER">
    </form>
_END;
    echo "<br>=====================<br>";
}


$result->close();
$conn->close();
require_once 'footer.php';


?>
