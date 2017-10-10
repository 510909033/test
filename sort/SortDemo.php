<?php
set_time_limit(1200);
ini_set('memory_limit' , '1G');
class SortDemo{
    
    public function maopao($arr){
        $length = count($arr);
        $is_change = true;
        for ($i=0;$i<=$length-2;$i++){
            $is_change = false;
            for ($j=$length-1;$j>$i;$j--){
                if ($arr[$j] < $arr[$j-1] ){
                    $tmp = $arr[$j-1];
                    $arr[$j-1] = $arr[$j];
                    $arr[$j] = $tmp;
                    $is_change = true;
                }
            }
            if (!$is_change){
                return $arr;
            }
        }
        
        return $arr;
    }
    
    public function jiandanxuanze($arr){
        $length = count($arr);
        for ($i=0;$i<=$length-2;$i++){
            $min = $i;
            for ($j=$i+1;$j<=$length-1;$j++){
                if ($arr[$j] < $arr[$min]){
                    $min = $j;
                }
            }
            if ($min != $i){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$min];
                $arr[$min] = $tmp;
            }
        }
        
        return $arr;
    }
    
    
    public function zhijiecharu($arr){
        $length = count($arr);
        for ($i=1;$i<$length;$i++){
            for ($j=$i-1;$j>=0;$j--){
                if ($arr[$j+1] < $arr[$j]){
                    $tmp = $arr[$j+1];
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $tmp;
                }
            }
        }
        return $arr;
    }
    
    public function kuaisupaixu($arr){
        $length = count($arr);
        if ($length <= 1){
            return $arr;
        }
//         if ($length <= 7){
//             if ($length <= 1){
//                 return $arr;
//             }
//             return $this->zhijiecharu($arr);
//             return $arr;
//         }
        $middle = $arr[0];
        $l = [];
        $r = [];
        for ($i=1;$i<=$length-1;$i++){
            if ($arr[$i] > $middle){
                $r[] = $arr[$i];   
            }else{
                $l[] = $arr[$i];
            }
        }
        
        $l = $this->kuaisupaixu($l);
        $r = $this->kuaisupaixu($r);
        
        return array_merge($l,array($middle) , $r);
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
    
    
    public static function test(SortDemo $sort){
        //check
        $arr = [];
        for ($i=0;$i<10000;$i++){
            $arr[] = rand(0,4000);
        }
        
        
        
        $starttime = microtime(true);
        $result1 = call_user_func(array($sort , 'maopao') , $arr);
        $endtime1 = microtime(true);
        
        
        $result2 = call_user_func(array($sort , 'jiandanxuanze') , $arr);
        $endtime2 = microtime(true);
        
        $result3 = call_user_func(array($sort , 'kuaisupaixu') , $arr);
        $endtime3 = microtime(true);
        
        $result4 = call_user_func(array($sort , 'zhijiecharu') , $arr);
        $endtime4 = microtime(true);
        
        $endtime_tong_start = microtime(true);
        $result_tong = call_user_func(array($sort , 'tong') , $arr);
        $endtime_tong_end = microtime(true);
        
        $startphptime = microtime(true);
        sort($arr);
        $end = microtime(true);
        if ($result1 !== $arr){
            echo 'fail 1';
            echo PHP_EOL;
        }
        if ($result2 !== $arr){
            echo 'fail 2';
            echo PHP_EOL;
        }
        if ($result3 !== $arr){
            echo 'fail 3';
            echo PHP_EOL;
        }
        if ($result4 !== $arr){
            echo 'fail 4';
            echo PHP_EOL;
        }
        if ($result_tong !== $arr){
            echo 'fail tong';
            echo PHP_EOL;
        }
        
        
        ob_end_clean();
        ob_start();
        echo 'time maopao='.($endtime1 - $starttime);
        echo PHP_EOL;
        echo 'time jiandanxuanze='.($endtime2 - $endtime1);
        echo PHP_EOL;
        
        echo 'time zhijiecharu='.($endtime4 - $endtime3);
        echo PHP_EOL;
        
        echo 'time kuaisupaixu='.($endtime3 - $endtime2);
        echo PHP_EOL;
        echo 'time tong='.($endtime_tong_start - $endtime_tong_end);
        echo PHP_EOL;
        
        
        echo 'time_php='.($startphptime - $end);
        echo PHP_EOL;
        
        $content = ob_get_contents();
        ob_end_clean();
        echo nl2br($content);
    }
    
}

call_user_func( [new SortDemo() , 'test'] , new SortDemo() );
// forward_static_call(array(new SortDemo() , 'test') ,[]);














