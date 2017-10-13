<?php
$dir = 'c:/test/flock/';
if (!is_dir($dir)){
    @mkdir($dir,755,true);
}

$filename = $dir.'flock1.txt';

$handle = fopen($filename, 'r+b');

//| LOCK_NB
if (flock($handle, LOCK_EX )){
    usleep(200);


     fseek($handle, 4 , SEEK_CUR );

    $con = intval(fread($handle, 10));
    
    var_dump(rewind($handle));
//     var_dump(fstat($handle));
    var_dump(fseek($handle, 0));
    var_dump(ftell($handle));
    
    $con++;
    fwrite($handle, $con );
    flock($handle, LOCK_UN);
}
fclose($handle);

echo $con;

// $fp = fopen("lock.txt","w+");
// if (flock($fp,LOCK_EX)) {
//     //获得写锁，写数据
//     fwrite($fp, "write something");

//     // 解除锁定
//     flock($fp, LOCK_UN);
// } else {
//     echo "file is locking...";
// }
// fclose($fp);

echo PHP_EOL;

// echo posix_getpid(); //8805

$handle = fopen('php://stderr', 'w');
fwrite($handle, 'errstr');


$fp = fopen('php://stdout', 'w');
fwrite($fp, 'haha');
fwrite($fp, 'hahaheihei');

echo fread(STDIN, 1024).PHP_EOL;


while (fscanf(STDIN, "%d%d", $a, $b) == 2) {
    print ($a + $b) . "\n";
}
return;



$descriptorspec = array(
    0 => array("pipe", "r"),  // 标准输入，子进程从此管道中读取数据
    1 => array("pipe", "w"),  // 标准输出，子进程向此管道中写入数据
    2 => array("file", "c:/a.txt", "a") // 标准错误，写入到一个文件
);

$cwd = 'c:/';
$env = array('some_option' => 'aeiou');

$process = proc_open('php', $descriptorspec, $pipes, $cwd, $env);

if (is_resource($process)) {
    // $pipes 现在看起来是这样的：
    // 0 => 可以向子进程标准输入写入的句柄
    // 1 => 可以从子进程标准输出读取的句柄
    // 错误输出将被追加到文件 /tmp/error-output.txt

    fwrite($pipes[0], '<?php print_r($_ENV); ?>');
    fclose($pipes[0]);

    echo stream_get_contents($pipes[1]);
    fclose($pipes[1]);


    // 切记：在调用 proc_close 之前关闭所有的管道以避免死锁。
    $return_value = proc_close($process);

    echo "command returned $return_value\n";
}
return;


$cmd = "php -v";
function execInBackground($cmd) {
    if (substr(php_uname(), 0, 7) == "Windows"){
//         popen("start /B ". $cmd, "r");
        pclose(popen("start /B ". $cmd, "r"));
    } else {
        exec($cmd . " > /dev/null &");
    }
}
execInBackground($cmd   );
return;





$fp = fsockopen("tcp://127.0.0.1", 8888, $errno, $errstr);
if (!$fp) {
    echo "ERROR: $errno - $errstr<br />\n";
} else {
//     fwrite($fp, "\n");

    
    
    
    echo iconv('UTF-8', 'GBK', $str);
    fclose($fp);
}
return;



$filename = 'http://www.qq.com';
$handle = fopen($filename, 'rb');

var_dump(stream_get_meta_data($handle));

$context = stream_context_create($options);




return ;

$i = 0;
while ( !feof($handle) ){
    fgets($handle);
    
    echo $i++.PHP_EOL;
}
fclose($handle);



















