<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body onload="init();">
<?php include "header.php"; ?>
<h1>Take a snapshot of the current video stream</h1>
Click on the Start WebCam button.
<p>
    <button onclick="startWebcam();">Start WebCam</button>
    <button onclick="stopWebcam();">Stop WebCam</button>
    <button onclick="snapshot();">Take Snapshot</button>
</p>
<video onclick="snapshot(this);" width=400 height=400 id="video" controls autoplay></video>
<p>

    Screenshots : </p>
    <canvas  id="myCanvas" width="400" height="350"></canvas>
</body>

<script>
    //--------------------
    // GET USER MEDIA CODE
    //--------------------
    navigator.getUserMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    var video;
    var webcamStream;

    function startWebcam() {
        if (navigator.getUserMedia) {
            navigator.getUserMedia (

                // constraints
                {
                    video: true,
                    audio: false
                },

                // successCallback
                function(localMediaStream) {
                    video = document.querySelector('video');
                    video.src = window.URL.createObjectURL(localMediaStream);
                    webcamStream = localMediaStream;
                },
                // errorCallback
                function(err) {
                    console.log("The following error occurred: " + err);
                }
            );
        } else {
            console.log("getUserMedia not supported");
        }
    }

    function stopWebcam() {
        webcamStream.getTracks()[0].stop();
    }
    //---------------------
    // TAKE A SNAPSHOT CODE
    //---------------------
    var canvas, ctx;

    function init() {
        // Get the canvas and obtain a context for
        // drawing in it
        canvas = document.getElementById("myCanvas");
        ctx = canvas.getContext('2d');
    }
    //https://gist.github.com/peterschmidler/2410299
    //https://permadi.com/2010/10/html5-saving-canvas-image-data-using-php-and-ajax/
    function snapshot() {
        // Draws current image from the video element into the canvas
         ctx.drawImage(video, 0,0, canvas.width, canvas.height);
        var canvasData = canvas.toDataURL("image/png");
        alert(canvasData);
        var postData = "canvasData="+canvasData;
        var ajax = new XMLHttpRequest();
        ajax.open("POST",'testsave.php',true);
        ajax.setRequestHeader('Content-Type', 'canvas/upload');
       // ajax.setRequestHeader('Content-Type-Length', postData.length);
        ajax.send(canvasData );
    }

</script>
</html>