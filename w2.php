<?php
$dir = __DIR__;
require_once __DIR__.'/workerman/Autoloader.php';
use Workerman\Worker;

function out($str){
    echo $str.PHP_EOL;
}

$handle = fopen('php://stdout', 'wb');
fwrite($handle, __LINE__.PHP_EOL);
$worker = new Worker('http://0.0.0.0:1235');
fwrite($handle, __LINE__.PHP_EOL);
$worker->count=1;

$worker->onConnect = function(){
  echo 'onConnect '.PHP_EOL;  
};

$worker->onMessage = function($connection, $data) use($handle)
{
    fwrite($handle, __LINE__.PHP_EOL);
    $connection->send("HTTP/1.1 200 OK\r\nConnection: keep-alive\r\nServer: workerman\1.1.4\r\n\r\nhello");
    fwrite($handle, __LINE__.PHP_EOL);
};

// $worker2 = new Worker('http://0.0.0.0:1235');
// $worker2->count=3;

Worker::runAll();