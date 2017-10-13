<?php 
set_time_limit(1200);
error_reporting(E_ALL);
date_default_timezone_set('UTC');
$port_file = 'c:/port_file';
 $sock = socket_create_listen(0); 
socket_getsockname($sock, $addr, $port); 
 print "Server Listening on $addr:$port\n"; 
$fp = fopen($port_file, 'w'); 
fwrite($fp, $port); 
fclose($fp); 
$i=0;

socket_set_block($sock);
// socket_set_nonblock($sock);


 while($c = socket_accept($sock)) { 
     
     
    /* do something useful */ 
    socket_getpeername($c, $raddr, $rport); 
    print "Received Connection from $raddr:$rport\n";
//     file_put_contents('c:/time'.$rport.'.txt', date('Y-m-d H:i:s' , time()).PHP_EOL, FILE_APPEND|LOCK_EX);
    file_put_contents('c:/time.txt', date('Y-m-d H:i:s' , time()).PHP_EOL, FILE_APPEND|LOCK_EX);
    sleep(3);
 } 
socket_close($sock); 

echo 'over';