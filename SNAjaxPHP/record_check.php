<?php
header('Content-type:text/html;charset=utf-8');
require('pdo.php');
// $stmt = $pdo->query("select count(*) from note where lesson=2");
// $res=$stmt->fetchAll();
// var_dump($res);

$lessonId= $_POST['lessonId'];
$stmt = $pdo->query("select * from conv where lesson={$lessonId}");
$res=$stmt->rowCount();
echo $res;



?>