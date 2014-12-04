<script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
<script src="<?php echo $base.'js/home.js';?>"></script>
 <script src="<?php echo $base.'js/login.js';?>" ></script>
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
<script type="text/javascript"> 
function showmenu(){
	if(document.getElementById('dropmenu').style.display=='none'){
		document.getElementById('dropmenu').style.display="block";
	}else{
		document.getElementById('dropmenu').style.display="none";
	}
}
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >

  <div class="head">
    <div class="logo pull-left"> <a href="<?php echo $base;?>"><img src="<?php echo $base.'img/logo.png';?>" /></a> </div>
    <ul class="dropdown-menus">
	  <?php if(!isset($login)):?>
      <li><a href="#" onclick="javascript:document.getElementById('login_modal').className='modal';">登录</a></li>
      <li><a href="<?php echo $base.'register/';?>">注册</a></li>
      <?php else:?>
	  <li class="drop"><a href="#" onclick="javasrcipt:showmenu();" ><?php echo $user_info['username']; ?></a>
      	<ul id="dropmenu" style="display:none;">
        	<li><a href="<?php echo $base.'demand/';?>">个人空间</a></li>
            <li><a href="#">我的关注</a></li>
            <li><a href="#">我的评论</a></li>
            <li><a href="#">我的粉丝</a></li>
            <li><a href="<?php echo $base.'design/';?>">我的设计</a></li>
            <li><a href="<?php echo $base.'demand/demandlist/';?>">需求广场</a></li>
            <li><a href="<?php echo $base.'news?type=21';?>">知识广场</a></li>
			<?php if($user_info['permission']){?>
			<li><a href="<?php echo $base.'order/orderlist';?>">订单管理</a></li>
			<?}?>
            <li><a href="<?php echo $base."login/logout";?>">退　　出</a></li>
        </ul>
      </li>
	  <?php endif; ?>
    </ul>

  </div>


<div id="login_modal" class="modal hide" style="width:auto;">
	<div class="modal-header"><a href="#" class="close" onclick="$('#login_modal').hide();">&times;</a><h3>用户登录</h3></div>
	<div class="modal-body">
		<div class="clearfix">
			<label style="width:70px">用户名：</label>
			<input class="span7" type="text" id="login_username" name="username"></input>
		</div>
		<div class="clearfix">
			<label style="width:70px">密&nbsp;&nbsp;&nbsp;码：</label>
			<input class="span7"  id="login_pswd" name="password" type="password"></input>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn primary" id="head_login" onclick="login_process();">
			登录
		</button>
	</div>
</div>
<input type="hidden" value="<?php echo $base; ?>" id="header_base" />
<input type="hidden" value="请稍候" id="login_wait"/>
<div id="login_msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close" onclick="$('#login_msg_modal').hide();">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#login_msg_modal').hide();">确定</button></div>
</div>