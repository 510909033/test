<?php
set_time_limit(0);

exec('mode COM2: baud=115200 data=8 stop=1 parity=n xon=on');

$fd = dio_open('COM2:', O_RDWR);

if (! $fd) 

{
    
    die("Error when open COM2");
}

$ff = dio_stat($fd);
print_r($ff);

echo "HQB232 CLIENT is start on COM2\n";

dio_write($fd, chr(0) . chr(1));
echo "C_SEND:01\n";

$len = 2;

$t = 0;
while (($t ++) < 1000) 

{
    
    $data = dio_read($fd, $len);
    
    if ($data == chr(0) . chr(2)) {
        
        echo "C_RECV:02\n";
        
        break;
    }
}

$len = 2;

$t = 0;
while (($t ++) < 10) 

{





    $sdata = sprintf("%03d",$t) . "=" . microtime() . " (" . randomkeys(rand(0, 35)) . ")";
    
    $slen = strlen($sdata);
    
    $stxlen = sprintf("%02d", $slen);
    
    dio_write($fd, "$stxlen");
    
    dio_write($fd, "$sdata");
    echo "C_SEND:($stxlen)$sdata\n";
    
    // sleep(1);
}

dio_write($fd, chr(0) . chr(3));
echo "C_SEND:03\n";

dio_close($fd);

function randomkeys($length)

{
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
    
    for ($i = 0; $i < $length; $i ++) 

    {
        
        $key .= $pattern{rand(0, 35)};
    }
    
    return $key;
}

