<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/style.css">

</head>
<body onload="init();">
<?php
    include "header.php";


?>

<div class="clear"></div>
<div class="content">
    <div class="side">
    <?php
        $query = $db->prepare("SELECT * FROM gallery WHERE userID=? ORDER BY imgID DESC");
        $query->execute(array($_SESSION['logged_on_usr']));
        foreach ($query as $row){
            $src = "gallery/".$row['URL'];
            $imgID = $row['imgID'];
            echo "<form action='delete.php' method='POST'>
                    <input type='hidden' name='src' value=$src>
                    <button type='submit' name='imgID' value=$imgID>
                        <img id='thumb' name=$imgID height=100px width=100px src=$src>
                    </button>
            </form>";
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
                <input onclick="getchoice()" type="file" name="fileToUpload" id="fileToUpload">
            <button id="upload" type="submit" value="" name="submit">Upload</button>
            </form>
            <button id="stop" onclick="stopWebcam();">Stop WebCam</button>
            <form action="snap.php" method="">
            <button id="snap" onclick="snapshot(0);">Take Snapshot</button>
    </form>
        </p>
        <div class="video">
            <img id="preview">
        <video width=640 height=484 id="video" controls autoplay></video>
        </div>
            <canvas  id="myCanvas" width="640" height="484"></canvas>
            <img id="temp" src="temp2.png" width="640" height="484">
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
        navigator.mediaDevices.getUserMedia ||
        navigator.msGetUserMedia);

    var video;
    var webcamStream;

    document.getElementById("snap").disabled = true;
    document.getElementById("stop").disabled = true;
    document.getElementById("upload").disabled = true;
    document.getElementById("fileToUpload").disabled = true;
    function chkd(choice) {
        var vid = document.getElementById("video");
        if (vid.currentTime > 0 && document.getElementById("snap").disabled == true) {

            document.getElementById("snap").disabled = false;
        }
        document.getElementById("fileToUpload").disabled = false;
        var src = "stock/";
        src =  src.concat(choice.toString());
        src = src.concat(".png");
        var img = document.getElementById("preview")
        img.src = src;
        img.alt = "filter";
    }
    function startWebcam() {
        var radios = document.getElementsByName("filter");
        for (var i = 0; i < radios.length; i++ ) {
            if( radios[i].checked ) {
                document.getElementById("snap").disabled = false;
            }
        }
        document.getElementById("stop").disabled = false;
        navigator.mediaDevices.getUserMedia({ audio: false, video: true })
            .then(function(stream) {
                video = document.querySelector('video');
                video.srcObject = stream;
                webcamStream = stream;
            })
            .catch(function(err) {
                console.log("The following error occured: " + err);
            });
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
    function snapshot(x) {
        var foo;
        var canvasData;
        var ajax;
        var choice;
        var radios;
        var vid;
        var temp;
        var canvas2;
        var ctx2;

        foo = parseInt(x);
        ajax = new XMLHttpRequest();
        vid = document.getElementById("video");
        if (vid.currentTime > 0) {
            radios = document.getElementsByName("filter");
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            canvasData = canvas.toDataURL("image/png");
            for (var i = 0; i < radios.length; i++ ) {
                if( radios[i].checked ) {
                    i++;
                    choice = i.toString();
                    canvasData = canvasData.concat(choice);
                    break;
                }
            }
        }
       else if (foo > 0){
            temp = document.getElementById("temp");
          //  temp.src = "temp2.png";
            canvas2 = document.getElementById("myCanvas");
            ctx2 = canvas2.getContext('2d');
            choice = foo.toString();
            ctx2.drawImage(temp, 0, 0, canvas2.width, canvas2.height);
            canvasData = canvas2.toDataURL("image/png");
            canvasData = canvasData.concat(choice);
        }
        ajax.open("POST", 'save.php', true);
       ajax.setRequestHeader('Content-Type', 'canvas/upload');
        ajax.send(canvasData);
    }

    function getchoice(){
        var radios = document.getElementsByName("filter");

        document.getElementById("upload").disabled = false;
        for (var i = 0; i < radios.length; i++ ) {
            if ( radios[i].checked ) {
                var radio = document.getElementById("upload");
                radio.value = i + 1;
            }
        }
    }

    function rmImg(imgID){
        console.log(imgID);
        var ajax2;

        ajax2 = new XMLHttpRequest();
        ajax2.open("POST", 'delete.php', true);
        ajax2.setRequestHeader('Content-Type', 'text/plain');
        ajax2.send(imgID);
    }

</script>
<?php
    if ($_SESSION['upload'] != ""){
    $chkd = $_SESSION['upload'];
    $_SESSION['upload'] = "";
    $chkd = (string)$chkd;
    echo "<script> snapshot($chkd)</script>";
}
?>
</html>
