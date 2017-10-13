<?php
date_default_timezone_set('PRC');
if($argv[1]){
    $file = __FILE__;
    $handle = popen("php ".$file, 'r');
    $str = fread($handle, 1024);
    echo $str;
}else{
    echo date('c');
}
