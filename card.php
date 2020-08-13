<?php
    include "./lib/phpqrcode/qrlib.php";
    header("Content-type: image/png");
    $imgPath = 'QtyCare3.png';
    $image = imagecreatefrompng($imgPath);
    $color = imagecolorallocate($image, 18, 73, 128);
    $string = $_GET['q'];
    
    $nm = $_GET['n'];
    $fontSize = 36;
    $URL = "http://cmmu.hexta.bid/index.php?q=$string"; 
    $frame = QRcode::text($URL,false,QR_ECLEVEL_M);
    $font = "./baskvl.ttf";
    $ox = 682;
    $oy = 734;
    $pixelPerPoint = 7
    ; 
    $outerFrame = 4;
    $h = count($frame);
    $w = strlen($frame[0]); 
    $imgW = $w + 2*$outerFrame;
    $imgH = $h + 2*$outerFrame; 
    $base_image = imagecreate($imgW, $imgH);
    
    $col[0] = imagecolorallocate($base_image,255,255,255); // BG, white 
    $col[1] = imagecolorallocate($base_image,0,0,0);     // FG, blue

    imagefill($base_image, 0, 0, $col[0]);

    for($y=0; $y<$h; $y++) {
        for($x=0; $x<$w; $x++) {
            if ($frame[$y][$x] == '1') {
                imagesetpixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]); 
            }
        }
    }
    
    // saving to file
    $target_image = imagecreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint); 
    imagecopyresized(
        $target_image, 
        $base_image, 
        0, 0, 0, 0, 
        $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH
    ); 

    
    imagecopymerge($image, $target_image, 677, 802, 0, 0, imagesx($target_image), imagesy($target_image), 100);
    //imagefilledrectangle($image, 600,700,1050,770,$color);
    imagettftext($image, $fontSize, 0, $ox , $oy , $color, $font, $nm);
    //imagettftext($image, $fontSize, 0, $ox+30 , $oy+11 , $color, $font, $string);
    #imagestring($image, $fontSize, $x, $y, $string, $color);
    imagepng($image);
?>

