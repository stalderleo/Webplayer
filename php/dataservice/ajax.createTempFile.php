<?php
header("Content-Type: application/json", true);

if ($_POST['securekey'] == 'denis') {
    include 'class.db.php';
    include '../objects/class.video.php';
    include '../objects/class.playlist.php';
    
    $db = new db();
    
    $playlist = $db->selectPlaylist($_POST['pid']);
    $paths = array(
        'vid'=>array(),
        'video'=>array(),
        'vorschaubild'=>array()
    );
    foreach ( $playlist->getVideos() as $i=>$video )
    {   
        file_put_contents("../../videos/".$video->getBez()."vorschaubild.jpg", $video->getVorschaubild());
        file_put_contents("../../videos/".$video->getBez().".mp4", $video->getVideo());
        //Hier andere Path weil von index.htm aus
        array_push($paths['video'], "videos/".$video->getBez().".mp4");
        array_push($paths['vorschaubild'], "videos/".$video->getBez()."vorschaubild.png");
        array_push($paths['vid'], $video->getVid());
    }
    
    echo $playlist->generateJSONVideoPaths($paths);
    
}