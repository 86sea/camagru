<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/style.css">

</head>
<body onload="init();">
<?php include "header.php"; ?>
<div class="filter">
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="1">Plastic<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="2">Blood<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="3">Snake<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="4">Money<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="5">Cat<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="6">AK47<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="7">Sniper<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="8">Bear<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="9">Hand<br>
    <input onclick="chkd()" id="filter" name="filter" type="radio" value="10">Scratch<br>
</div>
<h1>Take a snapshot of the current video stream</h1>
Click on the Start WebCam button.
<p>
    <button onclick="startWebcam();">Start WebCam</button>
    <button id="stop" onclick="stopWebcam();">Stop WebCam</button>
    <button id="snap" onclick="snapshot();">Take Snapshot</button>
</p>
<video onclick="snapshot(this);" width=640 height=484 id="video" controls autoplay></video>
<p>

    Screenshots : </p>
    <canvas  id="myCanvas" width="640" height="484"></canvas>
<?php include "footer.php"; ?>
</body>

<script>
    function chkd() {
        var vid = document.getElementById("video");
        if (vid.currentTime > 0 && document.getElementById("snap").disabled == true) {
            document.getElementById("snap").disabled = false;
        }
    }
    //--------------------
    // GET USER MEDIA CODE
    //--------------------
    navigator.getUserMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    var video;
    var webcamStream;

    document.getElementById("snap").disabled = true;
    document.getElementById("stop").disabled = true;
    function startWebcam() {
        var radios = document.getElementsByName("filter");
        for (i = 0; i < radios.length; i++ ) {
            if( radios[i].checked ) {
                document.getElementById("snap").disabled = false;
            }
        }

        document.getElementById("stop").disabled = false;
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
                    //console.log("The following error occurred: " + err);
                }
            );
        } else {
           // console.log("getUserMedia not supported");
        }
    }

    function stopWebcam() {
        var vid = document.getElementById("video");
        if (vid.currentTime > 0) {
            document.getElementById("snap").disabled = true;
            webcamStream.getTracks()[0].stop();
        }
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
        var vid = document.getElementById("video");
        if (vid.currentTime > 0) {
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            var canvasData = canvas.toDataURL("image/png");
            var ajax = new XMLHttpRequest();
            ajax.open("POST", 'testsave.php', true);
            ajax.setRequestHeader('Content-Type', 'canvas/upload');
            ajax.send(canvasData);
        }
    }

</script>
</html>