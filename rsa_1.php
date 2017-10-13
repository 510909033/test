<?php
class Deque{
    private $queue=array();
    public function addFirst($item){
        return array_unshift($this->queue,$item);
    }

    public function addLast($item){
        return array_push($this->queue,$item);
    }
    public function removeFirst(){
        return array_shift($this->queue);
    }

    public function removeLast(){
        return array_pop($this->queue);
    }
}
    $card_num = 54;//
    function wash_card($card_num){
        $cards = $tmp = array();
        for($i = 0;$i < $card_num;$i++){
            $tmp[$i] = $i;
        }

        for($i = 0;$i < $card_num;$i++){
            $index = rand(0,$card_num-$i-1);
            $cards[$i] = $tmp[$index];
            unset($tmp[$index]);
            $tmp = array_values($tmp);
        }
        return $cards;
    }
    // 测试：
    print_r(wash_card($card_num));
    
    
    
    
    
    
    function bubble_sort(&$arr){
        for ($i=0,$len=count($arr); $i < $len; $i++) {
            for ($j=1; $j < $len-$i; $j++) {
                if ($arr[$j-1] > $arr[$j]) {
                    $temp = $arr[$j-1];
                    $arr[$j-1] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }
    }
    
    // 测试
    $arr = array(10,2,36,14,10,25,23,85,99,45);
    bubble_sort($arr);
    print_r($arr);