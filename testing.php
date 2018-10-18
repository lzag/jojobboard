<?php
require_once 'header.php';

//
///
//$database = new Database();
//
//$result = $database->execute_query("SELECT  FROM users WHERE user_id=12");
//
//if(!$result) echo "Sth is wrong";
//print_r($result->fetch_array()['first_name']);
///
//
///$user = new User();
//echo $user->getFirstName('12');
//echo $user->getSecondName('12');
//echo $user->getEmail('12');/
///
//$dir = `cd uploads & mkdir userfiles2`;
//
////echo "$dir";/
//$user = new User;
////$result = $user->getUserDetails('a@b');
//print_r($user);
////print_r($result);
//
//echo $user->getProperty('first_name');

//$sql = "SELECT posting_id, title, description, time_posted from postings";
//$result = $db->execute_query($sql);
//while($row = $result->fetch_assoc()) {
//    echo $row['time_posted'];
//echo $date = date("D d M Y T",mktime($row['time_posted']));
//}
//
//
//
//echo "<pre>";
//print_r($cj = json_decode(file_get_contents('http://public.api.careerjet.net/search?locale_code=de_DE')));
//
//print_r ($cj->jobs);
//
//get_object_vars($cj);
//
//

/*
Testing raw CareerJet API
require_once "includes/Careerjet_API.php";

   // Create a new instance of the interface for UK job offers
   $cjapi = new Careerjet_API('en_GB');


   // Then call the search methods (see below for parameters)
   $result = $cjapi->search( array(
                                    'keywords' => 'java manager',
                                    'location' => 'London',
                                    'affid'    => '0afaf0173305e4b9',
                                  )
                            );

   if ($result->type == 'JOBS') {
       echo "Got ".$result->hits." jobs: \n\n";
       $jobs = $result->jobs;

       foreach ($jobs as &$job) {
           echo " URL: ".$job->url."\n";
           echo " TITLE: ".$job->title."\n";
           echo " LOC:   ".$job->locations."\n";
           echo " COMPANY: ".$job->company."\n";
           echo " SALARY: ".$job->salary."\n";
           echo " DATE:   ".$job->date."\n";
           echo " DESC:   ".$job->description."\n";
           echo "\n";
        }
    }
    */
//echo "<pre>";
//print_r (JobPost::get_backfill());

pagination();

function justify($str, $len) {
  $line = "";
  $text = array();
  $words = explode(" ", $str);
  $last_word = end($words);
  foreach ($words as $key => $word) {

    if ($next_word != $last_word) $next_word = $words[$key + 1];
    else $next_word = "";

    $line .= $word;

    if (strlen($line ." ") == $len || strlen($line) == $len) {

    $line .= "\n";
    array_push($text, $line);
    $line = "";

    } elseif (strlen($line ." ". $next_word) <= $len) {

      $line .= " ";

    } else {

            while(strlen($line) < $len) {

            $line = preg_replace('/\s/', echo "  ",$line);

            }

            $line .= "\n";
            array_push($text, $line);
            $line = "";

        }
        }

  echo $justified = implode("", $text);
  return $justified;
}

$str = "DLAFSDASDF DFSAFAS DAS FASDFASFDASD ASDFASDFASF ASDFASDF ASDFSADFAS DSAFDASFA DFASFA FDASFDAS FDSAF";

echo justify($str,15);

?>
