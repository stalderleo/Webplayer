var video;

jQuery(document).ready(function () {
    jQuery.ajax({
        type: "GET",
        url: "http://localhost/webplayer/php/dataservice/ajax.getVideo.php",
        data: {
            securekey: "benis"
        },
        cache: true,
        success: function (data) {
            var blob = new Blob([atob(data.video)], {"type": "video\/mp4"});
            blob.lastModifiedDate = new Date();
            blob.name = data.bez;
            var file = new File([blob], "name");
            var imageUrl = window.URL.createObjectURL(file);

            console.log(imageUrl);
            var source = document.createElement("source");
            source.src = "data:video/mp4;base64,"+data.video;
            var video = document.getElementById("video");
            video.appendChild(source);
            //startPlayer();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        timeout: 10000
    });

    //return a promise that resolves with a File instance
    function urltoFile(url, filename, mimeType){
        return (fetch(url)
            .then(function(res){return res.arrayBuffer();})
            .then(function(buf){return new File([buf], filename, {type:mimeType});})
        );
    }
    //Usage example:
    /*urltoFile('data:video/mp4;base64,'+data.video, 'demo.mp4', 'video/mp4')
    .then(function(file){
        console.log(file);
    })*/
    //Usage example:
    urltoFile('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAInCAYAAAAiUmQrAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA/tpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDE0IDc5LjE1Njc5NywgMjAxNC8wOC8yMC0wOTo1MzowMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ1dWlkOjVEMjA4OTI0OTNCRkRCMTE5MTRBODU5MEQzMTUwOEM4IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkUwQUI0QkNCQUJDODExRTRBOTI1RUFBQjM5MUU5QTVCIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkUwQUI0QkNBQUJDODExRTRBOTI1RUFBQjM5MUU5QTVCIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIElsbHVzdHJhdG9yIENTNiAoTWFjaW50b3NoKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjA2ODAxMTc0MDcyMDY4MTE4MjJBRDY5NzcyMDIzMTMwIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjA2ODAx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', 'hello.png', 'image/png')
    .then(function(file){
        var img = jQuery('.test');
        jQuery(img).attr('src', URL.createObjectURL(file));
        console.log("awd");
    })


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

    function changeSkin(oldSkin, skinName) {
        jQuery('#container').removeClass(oldSkin);
        jQuery('#container').addClass('jw-skin-' + skinName);
    }

    function startPlayer() {
        var player = jwplayer("container").setup({
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
});
