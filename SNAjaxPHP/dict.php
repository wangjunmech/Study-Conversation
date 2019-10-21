<?php
header('Content-type:text/html;charset=utf-8');
require 'db-config.php';
require 'mypdo.class.php';

$db = mypdo::newClass();//实例化PDO对象
$db->pdoConnect($conf);//连接上面提供的数组连接配置


$arr=$_POST;

$url = $arr['urldata'];//取出post传过来的链接
// $url = './dictionary/src.html';
$content = file_get_contents($url);
//去掉换行、制表等特殊字符，可以echo一下看看效果
// $content=preg_replace("/[\t\n\r]+/","",$content);
// var_dump($content);
// $content = htmlspecialchars($content);//输出源码;

// echo '<pre>';
// ********正则匹配html标签********
$paraphrase001 = "/(<div.*?class=\".*?\".*?><.*?>.*?<\/.*?><\/div>)/ism"; 
$paraphrase002 = '/(<div.*?class=\"(.*?detail)\".*?\".*?>.*?<\/div>)/s';  
$paraphrase = "/<div\sclass=\"layout\">([\s\S]*)<\/div>/";  

// $paraphrase = '/<div\Sclass=>(.*)<\/div>/im';
// ********end正则匹配html标签********
// $resultArr = [];
// $key = preg_match_all($paraphrase002, $content, $resultArr);

// var_dump( ($resultArr));
// var_dump($key);

// **************正则去除字符中的特殊字符***********
// $a = 'sugge\st&ions??]>';
// $aa = 'suggestions>';
// $aa = 'suggestions/';
// $aa = 'suggestions\\';
// $reg =  '/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\（|\）|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\||\s+/';

// $newstr = preg_replace($reg,'',$aa);//正则替换返回替换后的内容
// **************正则去除字符中的特殊字符***********
// $newContent = '
// <!DOCTYPE html> 
// <html lang="en"> 
// <head> 
// <meta charset="UTF-8"> 
// <title>modelform</title> 
// </head> 
// <body> 

// </body> 
// </html>';


echo json_encode($content);



?>