<?php

// $xportlist = stream_get_transports();
// print_r($xportlist);
// return ;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$ret = socket_connect($socket,'127.0.0.1',8888);
if (!$ret){
    echo socket_strerror(socket_last_error($socket));
    return ;
}


// socket_getpeername($socket,$name,$port);
// echo "{$name}:{$port}<br />"; // 127.0.0.1:1
// var_dump(socket_send($socket,'foo',3,0)); // int(3)
// var_dump(socket_last_error($socket)); // int(0)

socket_write($socket, 'hellow');
echo '<br />';

echo socket_read($socket, 1024);
echo '<br />';

socket_close($socket);

return;


$fp = stream_socket_client("tcp://127.0.0.1:8888", $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    $len = fwrite($fp, "GET / HTTP/1.0\r\nHost: www.example.com\r\nAccept: */*\r\n\r\n");
    while (!feof($fp)) {
//         echo fgets($fp, 1024);
        echo fread($fp, 1024);
    }
    echo '<br />';
    echo $len.'<br/ >';
    fclose($fp);
}