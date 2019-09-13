<?php 
/**
 * Jooble Job feed
 * Link: https://uk.jooble.org/files/XML-feed/EN/jooble-xml-4job.pdf
 * 
 * Obligatory:
 * <link> - URL
 * <name> - title
 * <description> - job description
 * <pubdate> - publication date
 * Optional:
 * <updated> - last modification of the job
 * <salary> - salary plus currency "300$"
 * <company> - name of the company - company
 * <expire> - expiration date
 * <jobtype> - type of the job
 */
require_once '../includes/database.php';
use App\Database;
header("Content-Type: text/xml");
$xml = initializeXML('jobs');
$listings = getListings(new Database);
echo buildFeed($listings, $xml)->asXML();

function getListings(Database $db) {
    $sql = "SELECT a.posting_id, b.company_name, a.title, a.location, a.salary, a.description, a.time_posted ";
    $sql .= "FROM jjb_postings a ";
    $sql .= "LEFT JOIN jjb_employers b ";
    $sql .= "ON a.employer_id=b.employer_id "; 
    $sql .= "WHERE a.local = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(1));
    return $stmt;
}

function initializeXML($root, $version = '<?xml version="1.0" encoding="utf-8"?>'){
    $xml_header = $version . "<" . $root . "/>";
    return new SimpleXMLElement($xml_header);
}

function buildFeed($listings, $xml) {
    $listings->bindColumn('posting_id', $id);
    $listings->bindColumn('company_name', $company);
    $listings->bindColumn('title', $title);
    $listings->bindColumn('location', $city);
    $listings->bindColumn('salary', $salary);
    $listings->bindColumn('description', $description);
    $listings->bindColumn('time_posted', $time_posted);
    
    while ($row = $listings->fetch (PDO::FETCH_BOUND)) {
        $job = $xml->addChild('job');
        $job->addAttribute('id', $id);

        $fields = array(
            'url' => 'http://www.jojobboard.ga/jobpostings.php?posting_id=' . $id,
            'title' => $title,
            'description' => $description,
            'pubdate' => DateTime::createFromFormat('Y-n-j H:i:s', $time_posted)->format('d.m.Y'),
            'company' => $company,
            'salary' => $salary,
        );

        foreach ($fields as $key => $field) {
            $job->addChild($key, Cdata($field));
        }
    }
    return $xml;
}

function Cdata($value) {
    return $value = "<![CDATA[" . $value . "]]>";
}