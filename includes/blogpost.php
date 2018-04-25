<?php
class BlogPost {

    private $id;
    private $title;
    private $author;
    private $content;

    public static function getAllPosts() {

        $conn = new Database();
        $sql = "SELECT * FROM jjb_blog_posts";
        $result = $conn->execute_query($sql);
        for ($i = 0 ; $i < $result->num_rows; $i++) {
            $result->data_seek($i);
            $result_arr = $result->fetch_assoc();
            foreach($result_arr as $key => $entry) {
            echo "$key : $entry";
        }
        }
    }
}
?>
