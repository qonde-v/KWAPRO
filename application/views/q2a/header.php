<script type="text/javascript"> 
$(function(){ 
$("img").mouseover(function(e){ 
$("#tooltip").remove(); 
var info = "收集素材";
var s=this.src;
var mname=s.substring(s.lastIndexOf("/")+1);
var toolTip = "<div id='tooltip' width='300px' height='30px' style='position:absolute;border:solid #aaa 1px;background-color:#F9F9F9'><a href='javascript:collection(\""+mname+"\")'>" + info + "</a></div>"; 
$("body").append(toolTip); 
$("#tooltip").css({ 
"top" :e.pageY + "px", 
"left" :e.pageX + "px" 
}); 
}); 
}); 
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<div id="top">
<div id="top_main">
<div id="top_l"><img src="<?php echo $base.'img/logo.png';?>" align="absmiddle" border="0" /></div>
<div id="top_r">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <!-- <td width="5%" height="50" valign="bottom" align="left"></td> -->
			<td width="45%" valign="middle" align="left" class=" fWhite topr topt"><a href="<?php echo $base;?>" class="White14">首页</a> &nbsp;&nbsp; &nbsp;<a href="<?php echo $base.'news/?type=1';?>" class="White14">运动</a> &nbsp;&nbsp; &nbsp;<a href="<?php echo $base.'news/?type=2';?>" class="White14">服装</a> &nbsp;&nbsp; &nbsp;<a href="<?php echo $base.'news/?type=3';?>" class="White14">明星</a> &nbsp;&nbsp; &nbsp;<a href="<?php echo $base.'question_pool/';?>" class="White14">问答</a> &nbsp;&nbsp; &nbsp;<a href="<?php echo $base.'demand/demandlist/';?>" class="White14">设计实现</a> &nbsp;&nbsp; &nbsp;<a href="<?php echo $base.'demand/';?>" class="White14">个人空间</a></td>
			<td width="55%" valign="middle" align="left" >
			<?php if(!isset($login)):?>
			 <form method="post" action="" style="float:right;margin:10px 30px 10px 0px" name="login" onsubmit="return false;">
            <!-- <input class="input-small" name="username" id="login_username" type="text" placeholder="<?php echo $header_username;?>" >
            <input class="input-small" name="password" id="login_pswd" type="password" placeholder="<?php echo $header_password;?>"> -->
			<a id="head_login" href="#denglu" class="White">登录</a> &nbsp;&nbsp;<a id="head_register" href="<?php echo $base.'register/';?>" class="White">注册</a> &nbsp;&nbsp;<a href="#" class="White">网站导航</a>
			</form>
			<?php else:?>
			<p class="pull-right" style="margin-top:10px;margin-bottom:10px"><a style="color:white;padding-right:30px;" href="<?php echo $base."login/logout";?>">退出</a></p>
			<?php endif; ?>
			</td>
          </tr>
         </table>
</div>
</div>
</div>
