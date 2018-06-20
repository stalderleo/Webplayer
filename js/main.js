jQuery(document).ready(function () {
    var player = jQuery('#container');
    jQuery('#skin-select').change(function () {
        var test = jQuery('#container[class*="jw-skin"]');
        var classes = test[0].className.split(" ");
        var currentClass;
        for (var j = 0; j <= classes.length; j++) {
            if (classes[j] != undefined && classes[j].match('jw-skin-')) {
                currentClass = classes[j];
            }
        }
        changeSkin(currentClass, jQuery(this).val());
    });

    //Navigation handler
    $(".navbuttons").click(function () {
        $(".navbuttons").removeClass("active");
        $(this).addClass("active");
        if ($(this).attr("id") == "navbtn_jwplayer") {
            $(".playercontainer").hide();
            $("#jwplayer_container").show();
            JWPlayer();
        } else {
            $(".playercontainer").hide();
            $("#html5player_container").show();
            html5player();
        }
    });
    $("#navbtn_jwplayer").click();
});

//return a promise that resolves with a File instance
function urltoFile(url, filename, mimeType) {
    return (fetch(url).then(function (res) {
        return res.arrayBuffer();
    }).then(function (buf) {
        return new File([buf], filename, {type: mimeType});
    }));
}

function startPlayer(video) {
    console.log(video);
    var player = jwplayer("container").setup({
        type: "mp4",
        flashplayer: "/jwplayer/player.swf",
        playlist: [
            {
                duration: 32,
                file: video,
            }
        ],
        "playlist.position": "right",
        "playlist.size": 360,
        height: 470,
        width: 720,
        skin: {
            name: 'roundster',
            url: '../js/jwplayer-7.11.2/skins/roundster.css'
        }
    });
}

function changeSkin(oldSkin, skinName) {
    jQuery('#container').removeClass(oldSkin);
    jQuery('#container').addClass('jw-skin-' + skinName);
}

function html5player() {
    
    jQuery.ajax({
        type: "POST",
        url: "http://localhost/webplayer/php/dataservice/ajax.getVideo.php",
        data: {
            securekey: "benis",
            vid: 6
        },
        cache: true,
        success: function (data) {
            var source = document.createElement("source");
            source.src = "data:video/mp4;base64," + data.video;
            var videoplayer = document.getElementById("html5videoplayer");
            videoplayer.appendChild(source);
            videoplayer.play();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        timeout: 10000
    });
    
}

function JWPlayer() {
    
}