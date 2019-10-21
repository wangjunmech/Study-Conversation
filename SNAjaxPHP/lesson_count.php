<?php 
// var_dump($_POST);

require_once('mypdo.class.php');
require_once('db-config.php');

// echo 'See below the details!'
// // //开始连接数据库
$db = mypdo::newClass();//实例化PDO对象
$db->pdoConnect($conf);//接上面提供的数组连接配置
$arr= $db->select('conv');

$arr=$db->selectAll();
// echo '开始连接数据库';
// var_dump(count($arr)) ;
// // var_dump(($arr));
echo json_encode($arr);

?>
