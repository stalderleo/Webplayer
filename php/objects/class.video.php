<?php
/**
 * Description of a video
 *
 * @author Leo Stalder
 * @version 1.0
 * @since 30.05.18
 */
class video {
    
    private $vid;
    private $bez;
    private $video;
    private $vorschaubild;
    
    function __construct($vid, $bez, $video, $vorschaubild) {
        $this->vid = $vid;
        $this->bez = $bez;
        $this->video = $video;
        $this->vorschaubild = $vorschaubild;
    }
    
    function getVid() {
        return $this->vid;
    }

    function getBez() {
        return $this->bez;
    }

    function getVideo() {
        return $this->video;
    }

    function getVorschaubild() {
        return $this->vorschaubild;
    }
    
    function generateJSON() {
        return '{"id":"'.$this->getVid().'", "bez":"'.$this->getBez().'", "video":"'.base64_encode(($this->getVideo())).'", "vorschaubild":"'.base64_encode(($this->getVorschaubild())).'"}'; 
    }
} 