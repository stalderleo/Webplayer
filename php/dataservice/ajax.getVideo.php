<?php
header("Content-Type: application/json", true);

if ($_POST['securekey'] == 'benis') {
    include 'class.db.php';
    include '../objects/class.video.php';
    $db = new db();
    
    echo $db->selectVideo($_POST['vid'])->generateJSON();
}