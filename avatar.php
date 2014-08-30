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

// Configurable variables
$config = (object) array();
$config->width = 300;
$config->height = $config->width;
$config->square = $config->width / 5;

// Initiate image and allocate colors
$canvas = imagecreatetruecolor( $config->width, $config->height );
$white = imagecolorallocate( $canvas, 255, 255, 255 );
$black = imagecolorallocate( $canvas, 51, 51, 51 );
$color = imagecolorallocate( $canvas, rand(0,255), rand(0,255), rand(0,255) );

$grid = generate_grid();
foreach( $grid as $y0 => $row ){
    foreach( $row as $x- => $cell ){
        $x1 = $x0 * $config->square;
        $x2 = $x1 + $config->square;
        $y1 = $y0 * $config->square;
        $y2 = $y1 + $config->square;
        $cell_color = $cell ? $color : $white;
        imagefilledrectangle( $canvas, $x1, $y1, $x2, $y2, $cell_color );
    }
}

// Output and free from memory
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'avatar.php';
if( preg_match('/\/avatar\.(php|png|jpg|jpeg|gif)/', $request_uri, $match) ){
    switch( $match[1] ){
        case 'jpeg':
        case 'jpg':
            header('Content-Type: image/jpeg');
            imagejpeg($canvas);
            break;
        case 'gif':
            header('Content-Type: image/gif');
            imagegif($canvas);
            break;
        case 'png':
        case 'php':
        default:
            header('Content-Type: image/png');
            imagepng($canvas);
            break;
    }
    imagedestroy($canvas);
    exit(0);
}
