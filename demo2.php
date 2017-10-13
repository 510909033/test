<?php
$handle = fopen('php://stdin', 'rb');
function out($str){
    echo $str.PHP_EOL;
}

$client = stream_socket_client('127.0.0.1:2001',$errno,$errstr,1,STREAM_CLIENT_CONNECT );
if (!$client){
    out('stream_socket_client error');
    return ;
}

while (true){
    
    $str = fread($handle, 1024);
    
    out('stdin read:'.$str);
    
    
    $len = fwrite($client, $str);
    out('fwrite client len='.$len);
    
    $client_read = fread($client, 1024);
    
    out('client_read:'.$client_read);
    
}

