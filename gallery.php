<?php
    $galleryQ = $db->prepare("SELECT * FROM gallery");
    $galleryQ->execute();
    $gallery = $galleryQ->fetchall(PDO::FETCH_ASSOC);
    if (isset($_GET['page']))
        $page = $_GET['page'] * 2;
    else
        $page = 2;
    $i = $page - 2;
    while ($i < $page){
        $src ="gallery/".$gallery[$i]['URL'];
        $imgID = $gallery[$i]['imgID'];
        $user = $gallery[$i]['userID'];
        $likes = $gallery[$i]['likes'];
        $comments = $db->prepare("SELECT * FROM comments WHERE imgID=?");
        $comments->execute(array($imgID));
        echo "
            <img src=$src alt=$src>
        ";
        echo "<h3 id='likes'>Likes: $likes</h3>";
        echo "<h3> COMMENTS:</h3>";
        while ($comment= $comments->fetch(PDO::FETCH_ASSOC)){
            $temp = $comment['comment'];
            echo "
                <p id='comment'>$temp</p>
            ";
        }

        if ($_SESSION['logged_on_usr'] != "") {
            echo "
                <form action='like.php' method='POST'>
                    <input type='submit' name='submit' value='Like!'> 
                    <input type='hidden' name=imgID value=$imgID>
                </form>
                <form id='comment' action='comment.php' method='POST'>
                    <textarea rows='4' cols='50' name='comment' maxlength='140'></textarea>
                    <input type='hidden' name=imgID value=$imgID>
                    <input type='hidden' name=user value=$user> <br>
                    <input type='submit' name='submit' value='Post Comment'>
                </form>
                ";
        }
        $i++;
    }







    $rowCount = $galleryQ->rowCount();
    if ($rowCount % 2 != 0)
        $rowCount++;
    $pageCount = $rowCount / 2;
    echo "<div id='pageNav'>";
    for ($i = 1; $i <= $pageCount; $i++)
    {
        echo "
                <a href='http://localhost:8080/camagru/index.php?page=2'>| $i |</a>
        ";
    }
    echo "</div>";
    echo "<footer id='galleryFooter'>Copyright 2017. Created By syoung.</footer>"
?>