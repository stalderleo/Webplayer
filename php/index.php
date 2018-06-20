<!DOCTYPE html>
<?php
    ini_set('memory_limit', '-1');
    require_once './dataservice/class.db.php';
    require_once './objects/class.playlist.php';
    require_once './objects/class.video.php';

    $db = new db();
?>

<html>
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="../js/jwplayer-7.11.2/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key="7Jxu3WZus1Dv1+GbGmbwin7QKiTPAkVYxmItTw==";</script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/jwplayer_styles.css">

    <title>HOME</title>
</head>
<body>
    <ul id="nav">
            <li><a class="navbuttons" id="navbtn_jwplayer" class="active">JWPlayer</a></li>
        <li><a class="navbuttons" id="navbtn_html5player">HTML5 Player</a></li>
    </ul>
    <div class="playercontainer" id="jwplayer_container">
        <h1>JWPlayer</h1>

        <div id="container">Loading the player...</div>  
        <select id="skin-select">
            <option value="roundster">Roundster</option>
            <option value="five">Five</option>
            <option value="six">Six</option>
            <option value="seven">Seven</option>
            <option value="stormtrooper">Stormtrooper</option>
        </select>
    </div>

    <div class="playercontainer" id="html5player_container">
        <video id="html5videoplayer"></video>
        <div id="allVideos"></div>
    </div>
</body>
</html>
