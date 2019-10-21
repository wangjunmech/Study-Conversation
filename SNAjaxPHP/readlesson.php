<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript" src="./../jquery-v3.3.1.js"></script>
    <meta charset="UTF-8">
    <title>课程编号：<?=$_GET['id'];?></title>
        <style type="text/css">
    p{
        margin-top:5;
        white-space:0; 
        font-family: arial;
        padding: 5px;
        width: auto;
        display: block;
        background: lightblue;
        word-wrap: break-word;
        border: 0px solid;
        border-radius: 5px;


    }
    .role{    
        margin-left: 2%;
        width: 100px;
        padding-right: 10px;
        outline: none;
        border: none;
        list-style: none;
        background: transparent;
        font-size: 20px;

    }


    .sts{
        
    }
    .qs{
        background: pink;

    }
    .qslist{
        background: lightgreen;
        margin-left: 20%;

    }
    .correct{
        background: green;
        margin-left: 30%;

    }
    .ccc{
        background: orange;
        margin-left: 20%;
        color:red;
    }
    #space{
    	width: 100%;
    	height: 100px;
    }
        a {
            text-decoration: none;          
        }

</style>
</head>
<body>

<?php
header('Content-type:text/html;charset=utf-8');
require('pdo.php');



//生成随机颜色函数
function randrgb() 
{ 
  $str='0123456789ABCDEF'; 
    $estr='#'; 
    $len=strlen($str); 
    for($i=1;$i<=6;$i++) 
    { 
        $num=rand(0,$len-1);   
        $estr=$estr.$str[$num];  
    } 
    return $estr; 
} 


$lessonId= intval($_GET['id']);

$stmt = $pdo->query("select * from conv where lesson=".$lessonId);
// var_dump($stmt);
$res=$stmt->fetchAll();
// echo '<pre>';

// print_r($res);//輸出結果數組;

$arr = $res[0];

echo '<p>课程编号:'.($arr['lesson']).'</p>';
echo '<p>笔记时间:'.($arr['notetime']).'</p>';
echo '<p>笔记花费时间:'.($arr['studytime']).'分钟</p>';

$content=$arr['notestr'];
// $obj = (unserialize($content));
// echo gettype($content);
$obj = json_decode($content);
// echo $obj;

echo '<p>课程主题:'. $obj->subject .'</p>';
// echo '问题列表:'.$obj->questionArr;
// echo '句型列表:'.$obj->sentencesArr;

// var_dump($arr['notestr']);//　輸出字符串
// $arr = '['+$arr['notestr']+']';

$sentences =count($obj->sentencesArr);
echo '<p>例句数：'.$sentences.'</p>';
echo '<p>角色数：'.$obj->roleNum.'个人对话</p>';
$colorArr  = array();
// // 根据角色数自动生成颜色数组
// for($c = 0;$c<$obj->roleNum;$c++){
//     array_push($colorArr, randrgb());
// }

$colorArr = array('SpringGreen','LightSkyBlue','LightPink','Plum','Gold','Coral');

// var_dump($colorArr);
echo '<hr>';
for($i=0;$i<$sentences;$i++){
    $color = $colorArr[$i%$obj->roleNum];
    echo '<h3><p style = "background:'.$color.'"><input type = "text" class = "role" value = '.($obj->sentencesArr[$i][0]).':>';
    // echo '<h3 ><p style = "background:'.$color.'"><span class = "role">'.$obj->sentencesArr[$i][0].':</span>';

    echo '<span>'.($obj->sentencesArr[$i][1]).'</span></p></h3>';

};

//*********************首字母大写***************
// for($i=0;$i<$sentences;$i++){
//     $color = $colorArr[$i%$obj->roleNum];
//     echo '<h3><p style = "background:'.$color.'"><input type = "text" class = "role" value = '.ucfirst($obj->sentencesArr[$i][0]).':>';
//     // echo '<h3 ><p style = "background:'.$color.'"><span class = "role">'.$obj->sentencesArr[$i][0].':</span>';

//     echo '<span>'.ucfirst($obj->sentencesArr[$i][1]).'</span></p></h3>';

// };
//*********************首字母大写 End***************



?>
<hr>
<div id='mp3'>
</div>
<div id='space'>
</div>
<div id='space2'>
</div>
<div id='space3'>
</div>
<div class='boxClass' id = 'boxId'>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
</div>

</body>

<script>

//生成随机颜色函数
function randrgb() 
{ 
    var str='0123456789ABCDEF'; 
    var estr='#'; 
    var len=str.lenth; 
    var colorLen = 3;//生成3位RGB颜色如:#F8F
    var colorLen = 6;//生成6位RGB颜色如:#F8F8FF
    for(let i=1;i<=colorLen;i++) 
    { 
        var num=Math.round(Math.random()*10);   
        estr=estr+str[num];  
    } 
    return estr; 
} 

 document.querySelectorAll('#boxId > div').forEach(div => {
    div.style.width = div.style.height = '60px'
    div.style.background = randrgb();
    div.style.margin = '12px'
    div.style.display = 'inline-block'
})       

//字符串转DOM,string to DOM Object, example <a href="http://dict.cn/Hi" target="_blank">Hi</a>  
function parseDom(arg) {
　　 var objE = document.createElement("div");
　　 objE.innerHTML = arg;
　　 return objE.childNodes;
};

//DOM转字符串 to string,
function nodeToString ( node ) {  
   var tmpNode = document.createElement( "div" );  
   tmpNode.appendChild( node.cloneNode( true ) );  
   var str = tmpNode.innerHTML;  
   tmpNode = node = null; // prevent memory leaks in IE  
   return str;  
}  

// *****************正则替换测试,[\u4e00-\u9fa5]|[^\x00-\xff]代表中文全角字符,包含特殊符号*************************
    var reg=/\\|\?|\？|\*|\"|\“|\”|\'|\‘|\’|\<|\>|\{|\}|\[|\]|\【|\】|\、|\^|\$|\!|\~|\`|\||\.|\s+|[\u4e00-\u9fa5]|[^\x00-\xff]|/g;//正则替换url中的特殊字符,除:和//外,如http://dict.cn/suggestions?需要去掉末尾的问题
    w1 = 'are. 这是一个测试';
    w2 = 'are.这是一个测试 ';
    wd = w2.replace(reg,'');
    // console.log((wd)+'[[[[[[[[')
// ******************************************

// ******************************************
/* @params word 单词
/* @params url　单词的语音链接
*/
function saveAudio(word,url){
    //AJAX发送到后台处理记录生词
    // alert(word+'===>'+url);
    worddata = {word,url};

    $.ajax({
        async:true,  
        url:'./save-audio.php?'+Math.random(),
        data:worddata,
        type:'post',
        traditional: true,
        timeout:10000, 
        success:function(data){
            // alert(data);
            console.log(data);
                },
        complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
                　　　　if(status=='timeout'){//超时,status还有success,error等值的情况
                　　　　　  console.log("保存MP3连接请求超时!!!!!!!!!!!!!");
                　　　　}
                 　　　if(status=='success'){//超时,status还有success,error等值的情况
                　　　　　  console.log("写入MP3成功!");
                　　　　}
 
                }
            });

}
// ******************************************

function getAudioUrl(url){
    
    urldata = url;
    var word = '';
    word = url.split('/')[3];//得到单词

    // //******在此扩展点击生词查询后的处理***************
    // // 注意:名词suggestion的复数形式.  
    // // 用Ajax发送查询内容给PHP处理
        $.ajax({
        async:true,  
        url:'./dict.php?'+Math.random(),
        data:{urldata},
        type:'post',
        traditional: true,
        timeout:10000, 
        success:function(data){
            var content = JSON.parse(data);//将PHP返回的JSON数据解析
            // console.log(content);
            parser=new DOMParser();//创建解析器
            content=parser.parseFromString(content, "text/html");//解析json对象为html对象
            var paraphrase = content.getElementsByClassName('layout detail');//从解释出的html对象中找出需要的内容
            var sentenceExample = content.getElementsByClassName('layout sort');//
            var mp3addressArr = content.getElementsByClassName('sound fsound');//
            var nfo = content.getElementsByClassName('layout nfo');//
            var index = (mp3addressArr.length-1);

            var mp3address = mp3addressArr[index].getAttribute('naudio');
            // fuk04pc07473cf34e828ae4b81c1d0cf1f9a41.mp3?t=you
            // http://audio.dict.cn/muTd30sec88b57c2fd0c06339f6b56442db4c3ed.mp3?t=aortic//正确的地址
            var addr = mp3address.split('?');//以问号分割数组
            var audioAddr = 'http://audio.dict.cn/'+addr[0]+'?t='+word;
            saveAudio(word,audioAddr);


            // console.log(addr[0]);
            // console.log(audioAddr);
            $('#mp3').html(addr[0]);
            $('#space').html(nfo[0]);

            document.querySelector('#space').querySelectorAll('li').forEach(item => {
                            item.style.width = '100px'
                            item.style.background = '#afd'
                            item.style.margin = '12px'
                            item.style.display = 'inline-block'
                        })  
            $('#space2').html(paraphrase[0]);

            document.querySelector('#space2').querySelectorAll('li').forEach(item => {
                            item.style.width = '100px'
                            item.style.background = '#afd'
                            item.style.margin = '12px'
                            item.style.display = 'inline-block'
                        })  
            $('#space3').html(sentenceExample[0]);

                },
        complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
                　　　　if(status=='timeout'){//超时,status还有success,error等值的情况
                　　　　　  alert("连接请求超时!!!!!!!!!!!!!");
                        subAns.style.visibility='visible';
                　　　　}
 
                }
            });





        // // // //原生Ajax ***********************
        // var xmlhttp;//Ajax对象变量
        // if (window.XMLHttpRequest)
        //   {// code for IE7+, Firefox, Chrome, Opera, Safari
        //   xmlhttp=new XMLHttpRequest();
        //   }
        // else
        //   {// code for IE6, IE5
        //   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        //   }
        // xmlhttp.onreadystatechange=function()
        //   {
        //   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        //     {
        //     console.log(xmlhttp.responseText+'/////////');
        //     }
        //   if (xmlhttp.readyState==0)
        //     {
        //     console.log('0: 请求未初始化');
        //     }
        //   if (xmlhttp.readyState==1)
        //     {
        //     console.log('1: 服务器连接已建立');
        //     }
        //   if (xmlhttp.readyState==2)
        //     {
        //     console.log('2: 请求已接收');
        //     }
        //   if (xmlhttp.readyState==3)
        //     {
        //     console.log('3: 请求处理中');
        //     }
        //   if (xmlhttp.readyState==4)
        //     {
        //     console.log('4: 请求已完成，且响应已就绪');
        //     }
        //   }

        // xmlhttp.open("POST","./dict.php",true);
        // xmlhttp.send({"url":"dict.cn"});
        // xmlDoc=xmlhttp.responseText;
        // alert(xmlDoc);

        // // //原生Ajax ***********************
}


    var sentences = document.getElementsByTagName('span');
    var num = sentences.length;
    // alert(str.length);
    for(let i = 0;i<num;i++){
        var tempS = '';
        var wordsArr = sentences[i].innerHTML.split(' ');//把句子按空格分割为数组

        // console.log(wordsArr);//[ "", "Certainly", "here", "", "you", "are．" ]數組元素需要去除空格,否則最這這個元素會有問題

        for(let j = 0;j<wordsArr.length;j++){
        let reg=/\\|\?|\？|\*|\"|\“|\”|\'|\‘|\’|\<|\>|\{|\}|\[|\]|\【|\】|\、|\^|\$|\!|\~|\`|\||\.|\s+|[\u4e00-\u9fa5]|[^\x00-\xff]|/g;//正则替换单词中的特殊符号,如结果的问号,小数点及标点符号等
            w2 = wordsArr[j].replace(reg,'');
            // console.log(w2+']');
            wordsArr[j] = wordsArr[j].link('http://dict.cn/'+w2);//循环给每个单词加链接
            var tag = parseDom(wordsArr[j]);
            tag[0].target = '_blank';
            // console.log(tag[0]);
            tag[0].setAttribute("onclick",'getAudioUrl(this.href)');
            // tag[0].setAttribute("onclick",'getAudioUrl(console.log(this.href))');


            // console.log(tag[0]);
            var newstr = nodeToString(tag[0]);
            // console.log(newstr);
            tempS += newstr +' ';  
        }
        sentences[i].innerHTML = tempS;
    }


// /d  = digital


</script>

</html>




