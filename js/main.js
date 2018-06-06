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
});
