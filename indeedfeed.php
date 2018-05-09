<?php
require_once 'includes/database.php';

$xml = <<<_END
<?xml version="1.0" encoding="utf-8"?>
<source>
<publisher>JoJobBoard</publisher>
<publisherurl>http://jojobboard.ga</publisherurl>

_END;

$sql = "SELECT posting_id, title, description, time_posted from jjb_postings";
$result = $db->execute_query($sql);
while($row = $result->fetch_assoc()) {
$xml .= <<<_END
<job>
    <title><![CDATA[{$row['title']}]]></title>
    <date><![CDATA[{$row['time_posted']}]]></date>
    <referencenumber><![CDATA[{$row['posting_id']}]]></referencenumber>
    <url><![CDATA[http://www.jojobboard.ga/jobpostings.php?posting_id={$row['posting_id']}]]></url>
    <country><![CDATA[NOT YET AVAILABLE]]></country>
    <description><![CDATA[{$row['description']}]]></description>
</job>

_END;
}

$xml .= "</source>";

header("Content-Type: text/xml");
echo $xml;

?>
