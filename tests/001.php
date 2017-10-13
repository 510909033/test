<?php if (!extension_loaded("dio")) print "skip"; ?>
<?php

set_time_limit(0);

exec('mode COM4: baud=115200 data=8 stop=1 parity=n xon=on');

$fd = dio_open('COM4:', O_RDWR);

if (! $fd) 

{
    
    die("Error when open COM1");
}

$ff = dio_stat($fd);
print_r($ff);

exit;

echo "HQB232 SERVER is listenning on COM1\n";

// / read

$len = 2;

$t = 0;
while ( true ) 

{
    
    $data = dio_read($fd, $len);
    
    if ($data) {
        
        file_put_contents('c:/001.txt', $data);
        
//         if ($data == chr(0) . chr(1)) {
            
            echo 'data<br />';
            echo $data;
            exit;
            echo "S_RECV:01\n";
            
            echo "S_SEND:02\n";
            
            //dio_write($fd, chr(0) . chr(2));
            
            break;
//         }
    }
    
    usleep(10000);
}





return ;






// / read

$len = 2;

$t = 0;
while (($t ++) < 1000) 

{
    
    $len = 2;
    
    $data = dio_read($fd, $len);
    
    if ($data == chr(0) . chr(3)) {
        
        echo "S_RECV:03\n";
        
        break;
    } 

    elseif ($data) {
        
        $len = intval($data);
        
        $data = dio_read($fd, $len);
        
        if ($data) {
            
            echo "S_RECV:($len)$data\n";
        }
    }
}

dio_close($fd);
            
            
            
            
            
            
            
            
            
            
            