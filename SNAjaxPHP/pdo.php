<?php 
require('db-config.php');
try{
    $pdo = new PDO($conf[0],$conf[1],$conf[2],array("PDO:ATTR_AUTOCOMMIT"=>false));  
    // $pdo = new PDO("mysql:host=127.0.0.1;dbname=study",'root','111111',array("PDO:ATTR_AUTOCOMMIT"=>false));  

    // $pdo = new PDO("mysql:host=148.72.232.169;dbname=study",'study2019','800815wj',array("PDO:ATTR_AUTOCOMMIT"=>false));    
}catch(PDOException $e){
    echo "数据库连接失败！错误消息：".$e->getMessage();

}
