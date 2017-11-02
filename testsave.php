<?php
if (isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
    $imageData = $GLOBALS['HTTP_RAW_POST_DATA'];
    $filter = substr($imageData, -1);
    $filterData = substr($imageData, 0, -1);
    $filteredData = substr($imageData, strpos($imageData, ",") + 1);
    $unencodedData = base64_decode($filteredData);
    $fp = fopen('temp.png', 'wb');
    fwrite($fp, $unencodedData);
    fclose($fp);
}
//https://stackoverflow.com/questions/3876299/merging-two-images-with-php
    $dest = imagecreatefrompng("temp.png");
    $src = imagecreatefrompng("stock/$filter.png");
    imagealphablending($dest, true);
    imagesavealpha($dest, true);
    imagealphablending($src, true);
    imagesavealpha($src, true);
    imagecopy($dest, $src, 0, 0, 0, 0, 640, 484);
    imagepng($dest, "temp.png");
    imagedestroy($dest);
    imagedestroy($src);
    // https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/send