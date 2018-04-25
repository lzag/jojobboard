<?php
$sitename = "Blog";

require_once 'header.php';

echo "<h1>Check out some blog posts</h1>";


BlogPost::getAllPosts();


require_once 'footer.php';
?>
