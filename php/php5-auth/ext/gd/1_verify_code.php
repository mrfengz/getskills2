<?php
//imagecreatetruecolor(w, h) 创建一个指定大小的画布
$size_x = 600;
$size_y = 380;
//创建画布
$img = imagecreatetruecolor($size_x, $size_y);

//分配颜色
$background = imagecolorallocate($img, 255, 255, 255);
$border = imagecolorallocate($img, 128, 128, 128);
//渲染文本颜色
$colors[] = imagecolorallocate($img, 128, 64,64);
$colors[] = imagecolorallocate($img, 198, 64, 128);
$colors[] = imagecolorallocate($img, 108, 192, 64);

//填充背景
imagefilledrectangle($img, 1, 1, $size_x - 2, $size_y - 2, $background);
imagerectangle($img, 0, 0, $size_x - 1, $size_y - 1, $border);

//绘制文本
for($i=0; $i<strlen($code); $i++){
    $color = $colors[$i % count($colors)];
    imagettftext(
        $img,
        28 + rand(0, 8),  //fontsize
        -20 + rand(0, 40),
        ($i + 0.3) * $space_per_char,
        50 + rand(0, 10),
        $color,
        'arial.ttf',
        $code{$i}
    );
}
