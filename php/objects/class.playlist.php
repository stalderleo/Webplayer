<?php
/**
 * Description of a playlist
 *
 * @author Leo Stalder
 * @version 1.0
 * @since 30.05.18
 */
class playlist {
    
    private $pid;
    private $bez;
    private $videos;
    
    function __construct($pid, $bez, $videos = NULL) {
        $this->pid = $pid;
        $this->bez = $bez;
        if (is_array($videos)) {
            foreach ($videos as $key => $value) {
                if (!($value instanceof video)) {
                    throw new Exception("Der Konstrukotr von \"playlist\" verlangt im dritten Parameter ein Array mit Elementen vom Typ \"video\" oder nichts!");
                    break;
                }
            } 
            $this->videos = $videos;
        }
        if (empty($this->videos)) $this->videos = array();
    }
    
    function getPid() {
        return $this->pid;
    }

    function getBez() {
        return $this->bez;
    }

    function getVideos() {
        return $this->videos;
    }

    function addVideo($video) {
        if (!($video instanceof video)) {
            throw new Exception("Die Funktion addVideo(\$video) der Klasse \"playlist\" verlangt als Parameter ein Objekt vom Typ \"video\"");
        } else {
            $this->videos[] = $video;
        }
    }
    
    function addVideos($video) {
        if (!($video instanceof video)) {
            throw new Exception("Die Funktion addVideo(\$video) der Klasse \"playlist\" verlangt als Parameter ein Objekt vom Typ \"video\"");
        } else {
            $this->videos[] = $video;
        }
    }
    
    function generateJSON() {
        $returnstr = '{"id":"'.$this->getPid().'", "bez":"'.$this->getBez().'", "videos":['; 
        
        $videos = $this->getVideos();
        $i = 0;
        $len = count($videos);
        foreach ($videos as $video) {
            if ($i == $len - 1) {
                $returnstr.= $video->generateJSON();
            } else {
                $returnstr.= $video->generateJSON().",";
            }
            $i++;
        }
        
        $returnstr.="]}";
        return $returnstr;
    }
    
    function generateJSONVideoPaths($paths) {
        $returnstr = '{"id":"'.$this->getPid().'", "bez":"'.$this->getBez().'", "videos":['; 
        
        $videos = $this->getVideos();
        $i = 0;
        $len = count($videos);
        foreach ($videos as $video) {
            
            $j = 0;
            foreach ($paths["vid"] as $path) {
                if ($path == $video->getVid()) {
                    $video->setVideo($paths['video'][$j]);
                    $video->setVorschaubild($paths['vorschaubild'][$j]);
                    break;
                }
                $j++;
            }
            
            if ($i == $len - 1) {
                $returnstr.= $video->generateJSONWithPaths();
            } else {
                $returnstr.= $video->generateJSONWithPaths().",";
            }
            $i++;
        }
        
        $returnstr.="]}";
        return $returnstr;
    }
}