<?php

// echo ($_POST['url']);
// echo ($_POST['word']);

$url = $_POST['url'];
$word = $_POST['word'];

$basepath = './dictionary/';


$file = 'words.txt';
$path = $basepath.$file;


// file_put_contents($path, $word,FILE_APPEND | LOCK_EX);

$content = file_get_contents($path);
// echo $content;

//先检查是否已记录
if(!strpos($content,$word) != false ){
    file_put_contents($path, $word.PHP_EOL, FILE_APPEND);  
    $folder = substr($word, 0,1);
    $mp3path ='./dictionary/mp3/'.$folder;
    // echo $mp3path;
    $filename = './dictionary/mp3/'.$folder.'/'.$word.'.mp3';
    if(!is_dir($mp3path)){
        mkdir($mp3path);
    }
    // echo $filename;//./dictionary/mp3/h/here.mp3
    $mp3content = file_get_contents($url);        
    file_put_contents($filename, $mp3content);
   

}


// $content = file_get_contents($url);
// $path = './t1.mp3';
// file_put_contents($path, $content);
// if (file_exists($path))
//  {echo "oooooooooooooooooook";}
// else
//  {echo "ng";}




