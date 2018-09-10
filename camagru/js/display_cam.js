(function(){
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
    vendorUrl = window.URL || window.webkitURL;

    navigator.getMedia =    navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mediaDevices.getUserMedia ||
        navigator.msGetUserMedia;
    navigator.getMedia({
        video: true,
        audio: false
    },function(stream){
        video.src = vendorUrl.createObjectURL(stream);
        video.play();
    }, function(error){

        alert('Unable to find camera. Please upload an image.');
    });
    document.getElementById('capture').addEventListener('click', function() {
        var subimage = document.getElementById('sub-image');
        context.drawImage(video, 0, 0, 400, 300);

        var img = canvas.toDataURL();
        subimage.value = img;
        document.getElementById('submit-form').submit;
    });
})();
