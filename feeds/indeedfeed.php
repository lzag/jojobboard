<?php
require_once '../includes/database.php';
use App\Database;
$db = new Database;
$lastbuild = date("D, d M Y H:i:s T");
$xml_header = '<?xml version="1.0" encoding="utf-8"?><source/>';
$xml = new SimpleXMLElement($xml_header);
$main = array(
    'publisher' => 'JoJobBoard',
    'publisherurl' => 'http://jojobboard.ga',
    'lastBuild' => $lastbuild
);
foreach ($main as $key => $value) {
    $xml->addChild($key, $value);
}
// $row = array (
//     'title' => 'This is the title',
//     'posted_on' => time(),
//     'date' => 'Date posted',
//     'description' => 'This is the job description',
//     'url' => 'http://someurl.com',
//     'referencenumber' => '324214'
// );
// this variable holds the matching of the keys from the database to the ones in the feed
$feed_fields = array(
    'title' => 'title',
    'time_posted' => 'time_posted',
    'description' => 'description',
    'posting_id' => 'referencenumber'
);

$fields = implode(", ", array_keys($feed_fields));

$query = "SELECT $fields FROM jjb_postings WHERE local = 1";
$results = $db->query($query);
foreach ($results as $row) {
    $job = $xml->addChild('job');
    foreach ($row as $key => $value) {
        if (array_key_exists($key, $feed_fields)) {
            $job->addChild($feed_fields[$key], wrapCdata($value));
        }
    }
}

function wrapCdata($input) {
    return "![CDATA[" . $input . "]]";
}
// $date = date("D, d M Y H:i:s T",strtotime($row['time_posted']));
// $job->addChild('date', "![CDATA[{$date}]]");
// $job->addChild('country', '![CDATA[NOT YET AVAILABLE]]');

    // <job>
    //     <date><></date>
    //     <referencenumber><![CDATA[{$row['posting_id']}]]></referencenumber>
    //     <url><![CDATA[http://www.jojobboard.ga/jobpostings.php?posting_id={$row['posting_id']}]]></url>
    //     <country><![CDATA[NOT YET AVAILABLE]]></country>
    //     <description><![CDATA[{$row['description']}]]></description>
    // </job>

header("Content-Type: text/xml");
echo $xml->asXML();