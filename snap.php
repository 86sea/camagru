<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/style.css">

</head>
<body onload="init();">
<?php
    include "header.php";
    if ($_SESSION['upload'] != ""){
        $chkd = $_SESSION['upload'];
        echo "<script> snapshot($chkd)</script>";
    }

?>

<div class="clear"></div>
<div class="content">
    <div class="side">
    <?php
        $query = $db->prepare("SELECT * FROM gallery WHERE userID=? ORDER BY imgID DESC");
        $query->execute(array($_SESSION['logged_on_usr']));
        foreach ($query as $row){
            $src = "gallery/".$row['URL'];
            echo "<img id='thumb' height=100px width=100px src=$src>";
        }
    ?>
    </div>
    <div class="filter">
        <p>Select an image to superimpose:</p>
        <input onclick="chkd(1)" id="filter" name="filter" type="radio" value="1">Mr. Orange<br>
        <input onclick="chkd(2)" id="filter" name="filter" type="radio" value="2">Tree<br>
        <input onclick="chkd(3)" id="filter" name="filter" type="radio" value="3">Statue<br>
        <input onclick="chkd(4)" id="filter" name="filter" type="radio" value="4">Vapor 1<br>
        <input onclick="chkd(5)" id="filter" name="filter" type="radio" value="5">Vapor 2<br>
        <input onclick="chkd(6)" id="filter" name="filter" type="radio" value="6">Vapor 3<br>
        <input onclick="chkd(7)" id="filter" name="filter" type="radio" value="7">Meme Man<br>
        <input onclick="chkd(8)" id="filter" name="filter" type="radio" value="8">Evil Incarnate<br>
        <input onclick="chkd(9)" id="filter" name="filter" type="radio" value="9">Computer<br>
    </div>
    <div class="main">

        <h1>Take a snap</h1>
        Click on the Start WebCam button.
        <p>
            <button onclick="startWebcam();">Start WebCam</button>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input id="chkd" type="hidden" name="chkd" value="">
                <script>
                    var radios = document.getElementsByName("filter");
                    for (var i = 0; i < radios.length; i++ ) {
                        if ( radios[i].checked ) {
                            var chkd = document.getElementById("chkd");

                            chkd.value = i + 1;
                        }
                    }
                </script>
                <input type="submit" value="Upload Image" name="submit">
            </form>
            <button id="stop" onclick="stopWebcam();">Stop WebCam</button>
            <form action="snap.php" method="">
            <button id="snap" onclick="snapshot();">Take Snapshot</button>
    </form>
        </p>
        <div class="video">
            <img id="preview">
        <video onclick="snapshot(this);" width=640 height=484 id="video" controls autoplay></video>
        </div>
            <canvas  id="myCanvas" width="640" height="484"></canvas>

    </div>
</div>
<?php include "footer.php"; ?>
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

    document.getElementById("snap").disabled = true;
    document.getElementById("stop").disabled = true;
    document.getElementById("chkd").disabled = true;
    function chkd(choice) {
        var vid = document.getElementById("video");
        if (vid.currentTime > 0 && document.getElementById("snap").disabled == true) {
            document.getElementById("chkd").disabled = false;
            document.getElementById("snap").disabled = false;
        }
       // var img = document.createElement("img");
        //var elem = document.getElementById('preview');
        //if (elem != null) {
         //   elem.parentNode.removeChild(elem);
        //}
        var src = "stock/";
        src =  src.concat(choice.toString());
        src = src.concat(".png");
        var img = document.getElementById("preview")
        img.src = src;
       // img.width = 640;
       // img.height = 384;
        img.alt = "filter";
        //img.id = "preview";

        // This next line will just add it to the <body> tag
       // document.getElementById("previewdiv").appendChild(img);
    }
    function startWebcam() {
        var radios = document.getElementsByName("filter");
        for (var i = 0; i < radios.length; i++ ) {
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
            var choice;
            var radios = document.getElementsByName("filter");
            for (var i = 0; i < radios.length; i++ ) {
                if( radios[i].checked ) {
                    i++;
                    choice = i.toString();
                    canvasData = canvasData.concat(choice);
                    break ;
                }
            }
            ajax.open("POST", 'save.php', true);
            ajax.setRequestHeader('Content-Type', 'canvas/upload');
            ajax.send(canvasData);
        }
    }

</script>
</html>
