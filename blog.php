<?php
$sitename = "Blog";

require_once 'header.php';

echo "<h1>Check out some blog posts</h1><pre>";


$all_posts = BlogPost::getPostsArray();

$file = fopen("C:/Users/Lukasz/Desktop/CSV_data.csv",'w') or die("Can't open the file");
foreach($all_posts as $post) {
    if(fputcsv($file,$post) === false) {
        die("Can't write the csv line");
    }
}

fclose($file) or die("this is shit");
require_once 'footer.php';
?>
