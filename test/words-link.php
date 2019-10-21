<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>conversation note 对话笔记</title>
	    <link href="./bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="./jquery-v3.3.1.js"></script>
    <script type="text/javascript" src="./bootstrap-4.0.0/dist/js/bootstrap.js"></script>
    <style type="text/css">
    	body{
    		margin: 3%;
    	}
    	#listcontrol{
    		margin-bottom:10px;
    	}
    	#subAns,#addsentence {
    		/*border-radius: 40%;*/
    		margin-left: 40%;
    		width: 30%;
    		line-height: 60px;
    	}
    	#addsentence {
    		border-radius: 40px 40px;

    	}
    	.noteList{
    		width: 100%;
    		/*margin: 5px auto;*/
    		display: none;
    		height: auto;
    		padding: 5px;
    		margin:5px;
    		background:#ACFF94;/*列表背景*/
    		border: 1px solid red;
    		float: left;
    		border-radius:10px 10px;
    		word-wrap: break-word;
    		word-break: break-all;
    		white-space:normal;
    		/*white-space: pre-line;*/
    	}    	
    	.list {
    		width: auto;
    		height: auto;
    		padding: 5px;
    		float:left;

    		margin:5px;
    		background:#aef;
    		border: 1px solid blue;
    		display: inline;
    		border-radius:10px 10px;
    	} 	
    	.list:hover{
    		background:pink;
    		border: 1px solid red;
    		margin: 5px;
    	}
    	.idSpan{
    		font-size: 20px;
    		color:red;
    	}
    	#loading,#loading2{
    		z-index: 9999;
    		align-content: center;
    		text-align: center;    	
    	   	}
    	img{ width:20%; 
    		height:auto; 
    		max-width:100%; 
    		max-height:100%;
    		align-self: center;
    		margin: 0 auto;
    	}
    	#listcontrol{
    		border: 5px red dashed;
    	}
    	.roleinput{
    		/*min-width: 10px;*/
    		/*max-width: 110px;*/
    		width:60px;
    	}

    </style>
</head>
<body>
<p>课程编号:6</p><p>笔记时间:2019-04-21 13:03:25</p><p>笔记花费时间:6分钟</p><p>课程主题:That’s a nice kite</p><p>例句数：6</p><p>角色数：2个人对话</p><hr>
<h3><p style = "background:SpringGreen"><input type = "text" class = "role" value = A:><span>Hi what’s that in the sky</span></p>
</h3>
<h3><p style = "background:LightSkyBlue"><input type = "text" class = "role" value = B:><span>That’s a nice kite</span></p>
</h3>
<h3><p style = "background:SpringGreen"><input type = "text" class = "role" value = A:><span>Oh is this your football</span></p>
</h3>
<h3><p style = "background:LightSkyBlue"><input type = "text" class = "role" value = B:><span>Yes it’s my football</span></p>
</h3>
<h3><p style = "background:SpringGreen"><input type = "text" class = "role" value = A:><span>Can you play</span></p>
</h3>
<h3><p style = "background:LightSkyBlue"><input type = "text" class = "role" value = B:><span> No I can’t it’s too hard </span></p>
</h3>
<input type="hidden" name="trick" id = 'trick' value="用于存放点击后的URL">
<div id='space'>
	
</div>

<script>

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
function getAudioUrl(url){
	// alert(typeof(url));
	console.log(url); 
    var url = url; 
    $("#trick").val(url);
    alert($("#trick").val());  

    // console.log('\<\?php echo ' +url+ 'url; ?>')

}
	var sentences = document.getElementsByTagName('span');
	var num = sentences.length;
	// alert(str.length);
	for(let i = 0;i<num;i++){
		var tempS = '';
		var wordsArr = sentences[i].innerHTML.split(' ');//把句子按空格分割为数组
		// console.log(wordsArr);
		for(let j = 0;j<wordsArr.length;j++){
			wordsArr[j] = wordsArr[j].link('http://dict.cn/'+wordsArr[j]);
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
<?php
// echo "<script> url </script>";
?>
</body>
</html>

