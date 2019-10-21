<?php
header('Content-type:text/html;charset=utf-8');
require 'db-config.php';
require 'mypdo.class.php';

$db = mypdo::newClass();//实例化PDO对象
$db->pdoConnect($conf);//连接上面提供的数组连接配置
// var_dump($db);

$arr=$_POST;
$a = json_decode($arr['dataObj']);
// var_dump($a);
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
 
    return $obj;
}

$arr2 = object_to_array($a);
// var_dump($arr2);

$Arrnum = count($arr2);
$varnum =(extract($arr2));//把数组转为变量


// ********************************//
date_default_timezone_set('PRC');
$tt = date("Y-m-d H:i:s",time());
$data  = array(
    'lesson'=>$lessonId,
    'notestr'=>$arr['dataObj'],
    'studytime'=>$timespend,
    'notetime'=>$tt
);

// //先检查lesson编号是否已经存在

// $stmt=$db->prepare('select count(*) from note where lesson ='. $lessonId);
// // $stmt->bindParam(':lesson', $lessonId);
// $isExist = $stmt->execute();
// // echo $isExist.'xxxxxxxx';


$db->insert("conv",$data); //向表中插入数组
$result = $db->lastinsertid();//返回最后插入的记录的id
echo $result;



?>