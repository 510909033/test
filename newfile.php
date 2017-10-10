<?php
class Sort{
    
}

 for ($i = 0; $i<1000000;$i++){

    $arr[] = rand(0,1000000);
}

$arr2 = $arr;

 $t1 = microtime(true);
// $returnAr = quickSort($arr);

sort($arr2);

var_dump(memory_get_peak_usage(true)/1024/1024);echo "\n";echo "\n";


$t2 = microtime(true);
echo "usetime:".($t2-$t1);
echo "\n";

$returnAr1 = tong($arr);
$t3 = microtime(true);
echo "usetime:".($t3-$t2);
echo "\n";

var_dump(memory_get_peak_usage(true)/1024/1024);echo "\n";echo "\n";

file_put_contents(__DIR__.'/aaa', var_export($returnAr1,true));


 
function quickSort($arr) { 
    $length = count($arr);
    if($length <= 1) {
        return $arr;
    }
    //选择第一个元素作为基准
    $base_num = $arr[0];
    $left_array = array(); 
    $right_array = array(); 
    for($i=1; $i<$length; $i++) {
        if($base_num > $arr[$i]) {
            //放入左边数组
            $left_array[] = $arr[$i];
        } else {
            //放入右边
            $right_array[] = $arr[$i];
        }
    }
    $left_array = quickSort($left_array);
    $right_array = quickSort($right_array);
    //合并
    return array_merge($left_array, array($base_num), $right_array);
}

function tong($arr){
    $new = [];
    
    for ($i=0,$max=max($arr);$i<$max;$i++){
        $new[$i] = 0;
    }
    
    foreach ($arr as $v){
        $new[$v]++;
    }
    
    
    $arr = [];
    foreach ($new as $k=>$v){
        while ($v-- > 0 ){
            $arr[] = $k;
        }
    }
    return $arr;
}







