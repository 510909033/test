<?php
$dir = __DIR__;
require_once __DIR__.'/workerman/Autoloader.php';
use Workerman\Worker;
use Workerman\Connection\TcpConnection;

function out($str){
    echo $str.PHP_EOL;
}

$handle = fopen('php://stdout', 'wb');
fwrite($handle, __LINE__.PHP_EOL);
$worker = new Worker('http://0.0.0.0:1234');
fwrite($handle, __LINE__.PHP_EOL);
$worker->count=1;

$worker->onConnect = function(){
  echo 'onConnect '.PHP_EOL;  
};

$worker->onMessage = function(TcpConnection $connection, $data) use($handle)
{
    fwrite($handle, __LINE__.PHP_EOL);
    $connection->send(var_export($data,true).str_repeat('1', 1024000));
    fwrite($handle, __LINE__.PHP_EOL);
};

// $worker2 = new Worker('http://0.0.0.0:1235');
// $worker2->count=3;

Worker::runAll();