<?php

    session_start();
    
    $code = rand(1000, 9999);
    
    $r = rand(0, 100);
    
    $g = rand(0, 100);
    
    $b = rand(0, 100);
    
    $_SESSION["code"] = $code;
    
    $im = imagecreatetruecolor(60, 24) or die('Cannot Initialize new GD image stream');
    
    // $bg = imagecolorallocate($im, 130, 0, 0); //background color blue
    
    $bg = imagecolorallocate($im, 255, 255, 255); //background color blue
    
    $fg = imagecolorallocate($im, $r, $g, $b); //text color white
    
    imagefill($im, 0, 0, $bg);
    
    imagestring($im, 5, 5, 5, $code, $fg);
    
    header("Cache-Control: no-cache, must-revalidate");
    
    header('Content-type: image/png');
    
    imagepng($im);
    
    imagedestroy($im);
