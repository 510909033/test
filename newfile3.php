<?php
echo '<pre>';
// print_r(get_extension_funcs('MongoDB')); #看一下该扩展中提供了那些函数
print_r( get_class_methods('MongoClient') );
echo '</pre>';
// print_r(get_declared_classes()); #看一下预定义类中是否有你需要（或相似）的类名


// return ;
/*

    [134] => MongoClient
    [135] => Mongo
    [136] => MongoDB
    [137] => MongoCollection
    [138] => MongoCursor
    [139] => MongoCommandCursor
    [140] => MongoGridFS
    [141] => MongoGridFSFile
    [142] => MongoGridFSCursor
    [143] => MongoWriteBatch
    [144] => MongoInsertBatch
    [145] => MongoUpdateBatch
    [146] => MongoDeleteBatch
    [147] => MongoId
    [148] => MongoCode
    [149] => MongoRegex
    [150] => MongoDate
    [151] => MongoBinData
    [152] => MongoDBRef
    [153] => MongoException
    [154] => MongoConnectionException
    [155] => MongoCursorException
    [156] => MongoCursorTimeoutException
    [157] => MongoGridFSException
    [158] => MongoResultException
    [159] => MongoWriteConcernException
    [160] => MongoDuplicateKeyException
    [161] => MongoExecutionTimeoutException
    [162] => MongoProtocolException
    [163] => MongoTimestamp
    [164] => MongoInt32
    [165] => MongoInt64
    [166] => MongoLog
    [167] => MongoPool
    [168] => MongoMaxKey
    [169] => MongoMinKey

 */

$m = new MongoClient();    // 连接到mongodb
$db = $m->test;            // 选择一个数据库
$collection = $db->runoob; // 选择集合
$document = array( 
	"title" => "MongoDB".time(), 
	"description" => "database", 
	"likes" => 100,
	"url" => "http://www.runoob.com/mongodb/",
	"by", "菜鸟教程".time()
);
$collection->insert($document);
echo "数据插入成功";




$m = new MongoClient();    // 连接到mongodb
$db = $m->test;            // 选择一个数据库
$collection = $db->runoob; // 选择集合

$cursor = $collection->find();
// 迭代显示文档标题
foreach ($cursor as $document) {
    echo $document["title"] . "<br />";
}


$m = new MongoClient();    // 连接到mongodb
$db = $m->test;            // 选择一个数据库 //MongoDB

var_dump(get_class($db));

$collection = $db->runoob; // 选择集合//MongoCollection
var_dump(get_class($collection));

// 更新文档
$collection->update(array("title"=>"MongoDB"), array('$set'=>array("title"=>"MongoDB 教程")));
// 显示更新后的文档
$cursor = $collection->find();
var_dump(get_class($cursor));
// 循环显示文档标题
foreach ($cursor as $document) {
//     echo $document["title"] . "\n";
}


















