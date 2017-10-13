<?php
header('content-type:text/html;charset=utf-8');


function getHex($str,$length){
    
    $str = bin2hex($str);
    
    return str_pad($str, 20,'0');
}


// echo hex2bin('0221e5908941543530364300310000000000000000003135393130373539323443ff');exit;



// header('content-type:image/png');
$debug = [];
$qrcode_str = '吉AT506C,1,1591075924';
$qrcodeArr = [
    'car_number'=>'吉AT506C',
    'version'=>1,
    'expire'=>1591075924,
];


$debug['qrcode_str'] = $qrcode_str;

$hex = bin2hex($qrcode_str);
$hex = '';
foreach ($qrcodeArr as $value){
    $length = 20;
    $hex .=getHex($value, $length);
//     $hex .='--';
}



$debug['hex'] = $hex;

//0x02  0x21

$first = 0x02^0x21;
$second = $first ;

$debug['first'] = $first;



$a = '';
for ($i=0;$i<strlen($hex);$i+=2){
    $char_tmp = $hex{$i}.$hex{$i+1};
    
    $second = $second ^ $char_tmp;
    
}
//12345
//

$debug['second'] = $second;


$final = '0221'.$hex.$second.'ff';
// $final = $hex.$second;

// $final = hex2bin($final);
// var_dump($debug);
// echo $final;return;
/*
 * 起始位置0
 * 4-23 车牌号
 * 24-43 版本号
 * 44-63 二维码有效期
 * 64-83 腾放科技车辆信息主键id
 */

// var_dump($debug);
// var_dump($final);
// var_dump( hex2bin($final) );
// echo bin2hex($final) .PHP_EOL;
// echo hex2bin('000000'); echo PHP_EOL;


require_once 'phpqrcode/phpqrcode.php';


QRcode::png($final , false , QR_ECLEVEL_L , 8 ,1);









