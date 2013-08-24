<?php
function generate_grid(){
    $grid = array();
    for( $i=0; $i<5; $i++){
        $grid[$i] = array();
        for( $j=0; $j<3; $j++){
            $grid[$i][$j] = rand(0,1);
        }
        $grid[$i][3] = $grid[$i][1];
        $grid[$i][4] = $grid[$i][0];
    }
    return $grid;
}

$config = (object)array();
$config->width = $config->height = 300; // This is configurable.
$config->square = $config->width / 5;

$canvas = imagecreatetruecolor($config->width, $config->height);

// Allocate colors
$white = imagecolorallocate($canvas, 255, 255, 255);
$black = imagecolorallocate($canvas, 51, 51, 51);
$color = imagecolorallocate($canvas, rand(0,255), rand(0,255), rand(0,255));

$grid = generate_grid();
foreach($grid as $y=>$row){
    foreach($row as $x=>$cell){
        $x1 = $x * $config->square;
        $x2 = $x1 + $config->square;
        $y1 = $y * $config->square;
        $y2 = $y1 + $config->square;
        imagefilledrectangle($canvas, $x1, $y1, $x2, $y2, $cell?$color:$white);
    }
}

// Output and free from memory
header('Content-Type: image/png');
imagepng($canvas);
imagedestroy($canvas);
exit;