<?php
set_time_limit(1200);
ini_set('memory_limit' , '1G');
/**
 * @deprecated
 * @author Administrator
 *
 */
class Sort{
    
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
        return $this->_zhijicharu($arr);
        for($i=1, $len=count($arr); $i<$len; $i++) {  
            $tmp = $arr[$i];  
            for($j=$i-1;$j>=0;$j--) {  
                if($tmp < $arr[$j]) {  
                    $arr[$j+1] = $arr[$j];  
                    $arr[$j] = $tmp;  
                } else {  
                    break;  
                }  
            }  
        }  
        return $arr;  
    }
    
    public function kuaisupaixu($arr){
        $length = count($arr);
        if ($length <= 7){
            if ($length <= 1){
                return $arr;
            }
            return $this->zhijiecharu($arr);
            return $arr;
        }
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
    
    private function _zhijicharu($arr){
        $length = count($arr);
        for ($i=1;$i<$length;$i++){
            for ($j=$i-1;$j>=0;$j--){
                $tmp = $arr[$j+1];
                if ($arr[$j+1] < $arr[$j]){
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $tmp;
                }
            }
        }
        return $arr;
    }
    
    
    public function test($sort){
        //check
        $arr = [];
        for ($i=0;$i<1000;$i++){
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
        
        
        echo 'time maopao='.($endtime1 - $starttime);
        echo PHP_EOL;
        echo 'time jiandanxuanze='.($endtime2 - $endtime1);
        echo PHP_EOL;
        
        echo 'time zhijiecharu='.($endtime4 - $endtime3);
        echo PHP_EOL;
        
        echo 'time kuaisupaixu='.($endtime3 - $endtime2);
        echo PHP_EOL;
        
        echo 'time_php='.($startphptime - $end);
        echo PHP_EOL;
    }
    
}

class Node{
    public $data;
    /**
     * @var Node
     */
    public $left=null;
    /**
     * @var Node
     */
    public $right=null;
    public $level = null;
    /**
     * @var Node
     */
    public $parent=null;
    
    public function __construct($data){
        $this->data = $data;
    }
}

class Tree{
    /**
     * @var Node
     */
    public $tree;
    
    
    
    public function addNode(Node $node){
       if (is_null($this->tree)){
           $node->level = 1;
           $this->tree = $node;
           $this->tree->parent = null;
       }else{
           $this->_addNode($this->tree, $node);
       }
        
    }
    
    public function _addNode(Node $tree,Node $node){
        
        if ($tree->data > $node->data){
            if ($tree->left){
                $this->_addNode($tree->left, $node);
            }else{
                $node->level = $tree->level+1;
                $node->parent = $tree;
                $tree->left = $node;
            }
        }else{
            if ($tree->right){
                $this->_addNode($tree->right, $node);
            }else{
                $node->level = $tree->level+1;
                $node->parent = $tree;
                $tree->right = $node;
            }
        }
    }
    
    public function loopTree(Node $tree){
        static $list = [];
        if (is_null($tree)){
            return ;
        }
        
        if (!is_null($tree->left)){
            $this->loopTree($tree->left);
        }
        
        $list[] = $tree->data;
        
        if (!is_null($tree->right)){
            $this->loopTree($tree->right);
        }
        
        return $list;
        
    }
    
    /**
     * @deprecated
     * @param Node $tree
     * @param unknown $level
     * @return void|NULL[]
     */
    public function loopTreeByLevel(Node $tree , $level ){
        static $list = [];
        if ($tree->level == $level){
            $list[] = $tree->data;
        }else{
            
            if (!is_null($tree->left) && $tree->left->level < $level ){
                $this->loopTreeByLevel($tree->left, $level+1);
            }else if (!is_null($tree->right) && $tree->right->level < $level ){
                $this->loopTreeByLevel($tree->right, $level+1);
            }else{
                return ;
            }
        }
        return $list;
    }
    
    
    
    /**
     * 
     * @param Node $tree
     * @param Node $searchNode
     * @return Node|false
     */
    public function searchNode(Node $tree , Node $searchNode ){
        
        if ($tree->data == $searchNode->data){
            return $tree;
        }
        
        if (!is_null($tree->left) && $tree->data  > $searchNode->data ){
            return $this->searchNode($tree->left, $searchNode);
        }
        
        
        
        $list[] = $tree->data;
        
        if (!is_null($tree->right) && $tree->data  < $searchNode->data ) {
            return $this->searchNode($tree->right, $searchNode);
        }
        
        return false;
    }
    private function msg($msg){
        var_dump($msg);
        echo new Exception($msg);
    }
    public function delete(Node $tree , Node $deleteNode){
        
        while ( !is_null($tree) &&  $tree->data != $deleteNode->data  ){
            if ($tree->data > $deleteNode->data){
                $tree = $tree->left;
            }else{
                $tree = $tree->right;
            }
        }
        
        if ( is_null($tree) ){
            $this->msg(__LINE__);
            return ;
        }
        
     
        
        if (is_null($tree->left) || is_null($tree->right)){
            if ($tree->parent->left == $tree){
                $tree->parent->left = !is_null($tree->left)?$tree->left:$tree->right;
            }else{
                $tree->parent->right = !is_null($tree->left)?$tree->left:$tree->right;
            }
        }else{
            
            echo 'todo'.PHP_EOL;
            
            
            
        }
        
        while (!is_null($tree->parent)){
            $tree = $tree->parent;
        }
        $this->tree = $tree;
    }
    
    
    
    
}
$arr = [];
$tree = new Tree();
for ($i=1;$i<=100;$i++){
    $arr[] = $i;
//     $arr[] = chr($i);
}
shuffle($arr);
foreach ($arr as $v){
    $node = new Node($v);
    $tree->addNode($node);
}

// var_export($tree);

// $tree = (array)$tree;
// // var_export($tree);

// print_r($tree);

$list = $tree->loopTree($tree->tree);

// print_r($list);

$searchNode = new Node(33);
var_dump((bool)$tree->searchNode($tree->tree , $searchNode));

$deleteNode = new Node(33);
$tree->delete($tree->tree, $deleteNode);

$searchNode = new Node(33);
var_dump((bool)$tree->searchNode($tree->tree , $searchNode));


$list = $tree->loopTree($tree->tree);
if (count($list) != 199 ){
    echo 'fail - '.count($list);
    print_r($list);
}else{
    echo 'success - '.count($list);
}

// $sort = new Sort();
// $sort->test($sort);
















