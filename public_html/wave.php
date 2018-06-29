<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/GIFEncoder.class.php');

function mydisplay($x, $t, $a, $f1, $f2){
  return 120.0*(0.5*($a/256.0)+0.5)*(abs(sin($t/31.4*pow(2, 1+($f1 % 2))))*sin(50.0*$x)*sin((100*(0.5*($f2/256.0)+0.5)*$x+5.0*$t)/30.) + 1.0);
}

$delayInTheAnimation = 5;
$red = intval(bin2hex(openssl_random_pseudo_bytes(1)),16);
$green = intval(bin2hex(openssl_random_pseudo_bytes(1)),16);
$blue = intval(bin2hex(openssl_random_pseudo_bytes(1)),16);
$amp = intval(bin2hex(openssl_random_pseudo_bytes(1)),16);
$freq1 = intval(bin2hex(openssl_random_pseudo_bytes(1)),16);
$freq2 = intval(bin2hex(openssl_random_pseudo_bytes(1)),16);
for($t = 0; $t < 50; $t++){
  $im = @imagecreate(400, 300) or die("Cannot Initialize new GD image stream");
  $bgcolor = imagecolorallocate($im, 0x00, 0x00, 0x00);
  for($i = 0; $i < 200; $i++){
    $x = 2*$i;
    $xn = 2*($i+1);
    $y  = intval(floor(mydisplay($x , $t, $amp, $freq1, $freq2)));
    $yn = intval(floor(mydisplay($xn, $t, $amp, $freq1, $freq2)));
    imageline($im, $x, $y, $xn, $yn, imagecolorallocate($im, $red, $green, $blue));
  }
  ob_start();
  imagegif($im);
  $frames[]=ob_get_contents();
  $framed[]=$delayInTheAnimation;
  ob_end_clean();
  imagedestroy($im);
}

// Generate the animated gif and output to screen.
$gif = new GIFEncoder($frames,$framed,0,2,-1,-1,-1,'bin');
header('Content-type: image/gif');
echo $gif->GetAnimation();
?>
