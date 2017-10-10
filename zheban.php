<?php
header("Content-type: text/html; charset=utf-8"); 

/* 折半查询算法--不用递归 */
function qSort($data = array(), $x = 0){
	$startIndex = 0;                // 开始索引
	$endIndex = count($data) - 1;   // 结束索引
	$index = 0;
	$number = 0;                    // 计数器
	do{
		if($endIndex > $startIndex){
			$searchIndex = ceil(($endIndex - $startIndex) / 2);
		}else if($endIndex == $startIndex){
			$searchIndex = $endIndex;
		}else{
			$index = -1;
			break;
		}
		$searchIndex += ($startIndex - 1);

		echo '检索范围：'.$startIndex.' ~ '.$endIndex.'<br>检索位置：'.$searchIndex.'检索值为：'.$data[$searchIndex];
		echo '<br>=======================<br><br>';

		if($data[$searchIndex] == $x){
			$index = $searchIndex;
			break;
		}else if($x > $data[$searchIndex]){
			$startIndex = $searchIndex + 1;
		}else{
			$endIndex = $searchIndex - 1;
		}

		$number++;
	}while($number < count($data));
	return $index;
}

function sSort($data, $x, $startIndex, $endIndex){
	if($endIndex > $startIndex){
		$searchIndex = ceil(($endIndex - $startIndex) / 2);
	}else if($endIndex == $startIndex){
		$searchIndex = $endIndex;
	}else{
		return -1;
	}

	$searchIndex += ($startIndex - 1);

	echo '检索范围：'.$startIndex.' ~ '.$endIndex.'<br>检索位置：'.$searchIndex.'检索值为：'.$data[$searchIndex];
	echo '<br>=======================<br><br>';

	if($data[$searchIndex] == $x){
		return $searchIndex;
	}else if($x > $data[$searchIndex]){
		$startIndex = $searchIndex + 1;
		return sSort($data, $x, $startIndex, $endIndex);
	}else{
		$endIndex = $searchIndex - 1;
		return sSort($data, $x, $startIndex, $endIndex);
	}
}

$data = array(1, 3, 4, 6, 9,11, 11, 12, 13, 15, 20, 21, 25, 33, 34, 35, 39, 41, 44);

$index = qSort($data, 11);                       // 不用递归的排序方法
$index = sSort($data, 11, 0, count($data) - 1);  // 使用递归的排序方法
echo '结果：'.$index;