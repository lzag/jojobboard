<?php
require_once 'includes/database.php';

$xml = <<<_END
<?xml version="1.0" encoding="utf-8"?>
<trovit>

_END;

$sql = "SELECT posting_id, title, description from postings";
$result = $db->execute_query($sql);
while($row = $result->fetch_assoc()) {
$xml .= <<<_END
<ad>
    <id><![CDATA[{$row['posting_id']}]]></id>
    <title><![CDATA[{$row['title']}]]></title>
    <url><![CDATA[http://www.jojobboard.ga/jobpostings.php?posting_id={$row['posting_id']}]]></url>
    <content><![CDATA[{$row['description']}]]></content>
</ad>

_END;
}

$xml .= "</trovit>";

header("Content-Type: text/xml");
echo $xml;

?>
