<?php
// phpcs:ignore error

/**
 * Returnns a multi-dimensional array with bits representing various cells.
 *
 * @param integer $length Maximum size of the multi-dimensional array.
 *
 * @return array           Multi-dimensional array with bits.
 */
function imagegrid($length = 0)
{
    $grid = array();
    $modulus = ( $length % 2 == 0) ? 1 : 0;

    for ($i = 0; $i < $length; $i++) {
        $grid[$i] = array();
        $limit = ceil($length / 2);

        for ($j = 0; $j < $limit; $j++) {
            $grid[$i][] = rand(0, 1);
        }

        $missing = $length - $limit;
        $remaining = array_slice($grid[$i], 0, $missing);
        $remaining = array_reverse($remaining);

        foreach ($remaining as $remain) {
            $grid[$i][] = $remain;
        }
    }

    return $grid;
}

// Configurable variables
$config = (object) array();
$config->width = isset($_GET['width']) ? intval($_GET['width']) : 300;
$config->grid_length = isset($_GET['squares']) ? intval($_GET['squares']) : 5;

if ($config->grid_length > $config->width) {
    $config->grid_length = $config->width;
}

// Dynamic variables
$config->height = $config->width;
$config->square = $config->width / $config->grid_length;

// Initiate image and allocate colors
$canvas = imagecreatetruecolor($config->width, $config->height);
$white = imagecolorallocate($canvas, 255, 255, 255);
$color = imagecolorallocate($canvas, rand(0, 255), rand(0, 255), rand(0, 255));
$grid = imagegrid($config->grid_length);

foreach ($grid as $y0 => $row) {
    foreach ($row as $x0 => $cell) {
        $x1 = $x0 * $config->square;
        $x2 = $x1 + $config->square;
        $y1 = $y0 * $config->square;
        $y2 = $y1 + $config->square;
        $cell_color = $cell ? $color : $white;
        imagefilledrectangle($canvas, $x1, $y1, $x2, $y2, $cell_color);
    }
}

if (!isset($_SERVER['REQUEST_URI'])) {
    exit(1);
}

if (preg_match('/\/avatar\.(png|jpg|jpeg|gif)/', $_SERVER['REQUEST_URI'], $match)) {
    switch ($match[1]) {
    case 'jpeg':
    case 'jpg':
        header('Content-Type: image/jpeg');
        imagejpeg($canvas);
        break;
    case 'gif':
        header('Content-Type: image/gif');
        imagegif($canvas);
        break;
    default:
        header('Content-Type: image/png');
        imagepng($canvas);
        break;
    }

    imagedestroy($canvas);

    exit(0);
}
