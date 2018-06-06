<?php
header("Content-Type: application/json", true);

if (isset($_GET['securekey'])) {
    include 'class.db.php';
    include '../objects/class.video.php';
    $db = new db();
    
    $debug = $db->selectVideo(1);
    $debug = $db->selectVideo(1)->generateJSON();
    
    echo $db->selectVideo(1)->generateJSON();
}