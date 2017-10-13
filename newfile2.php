<?php
set_time_limit(60);

var_dump(date_default_timezone_get());
echo '<br />';
echo time();
echo '<br />';
echo date('Y-m-d H:i:s' , time());
echo '<br />';

date_default_timezone_set('PRC');
var_dump(date_default_timezone_get());
echo '<br />';
echo time();
echo '<br />';
echo date('Y-m-d H:i:s' , time());

return ;

// echo chr(hexdec(str_replace(' ', '', 'E5 90 89 32 31 5A 44 41 41 2C 31 30 38 35 2C 38 33 32 32 37')));
$str = 'E5 90 89 32 31 5A 44 41 41 2C 31 30 38 35 2C 38 33 32 32 37';

function Hex2String($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        
        var_dump(chr(hexdec($hex[$i].$hex[$i+1])));
        
    }
    
    return $string;
}
echo Hex2String(str_replace(' ', '', $str));

return ;

exec('mode COM4: baud=115200 data=8 stop=1 parity=n');

// $fd =dio_open('COM3:',O_NOCTTY);
// if($fd){
//     echo "Error when open COM1";
// }

// echo "x";


$c = stream_context_create(array('dio' =>
    array('data_rate' => 115200,
        'data_bits' => 8,
        'stop_bits' => 1,
        'parity' => 0,
        'is_canonical' => 1)));

if (PATH_SEPARATOR != ";") {
    $filename = "dio.serial:///dev/ttyS0";
} else {
    $filename = "dio.serial://COM4";
}
$filename = "COM4:";
$fp = dio_open('COM4:',O_RDWR);
// $fp = fopen($filename, 'r', false, $c);

// var_dump(dio_stat($fp));exit;

while (true){
    $str = dio_read($fp, 1024);
    if ($str){
        var_dump($str);
        exit;
    }

}

// $str = file_get_contents($filename,null,$c);

// var_dump($str);
// return ;


// $str = stream_get_contents($c, 1024);
// print $str;

