<script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
<script src="<?php echo $base.'js/home.js';?>"></script>
 <script src="<?php echo $base.'js/login.js';?>" ></script>
<script type="text/javascript"> 
$(function(){
	if($('#ifcollect').val()==1){
		$("img").mouseover(function(e){ 
			$("#tooltip").remove(); 
			var info = "素材采集";
			var s=this.src;
			var mname=s.substring(s.lastIndexOf("/")+1);
			var toolTip = "<div id='tooltip' style='position:absolute;border:1px solid #aaa;background-color:#ff7a23;border-radius:4px;padding:10px;'><a style='color: #fff;' href='javascript:collection(\""+mname+"\")'>" + info + "</a></div>"; 
			$("body").append(toolTip); 
			$("#tooltip").css({ 
				"top" :e.pageY + "px", 
				"left" :e.pageX + "px" 
			}); 
		}); 
	}
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
<script type="text/javascript">
function showLoginModal(){
	$("[role=modal]").show();
	$('#draggable').attr('style','display:none');
}
function hideLoginModal(){
	$("[role=modal]").hide();
}
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >

  <div class="head">
    <div class="logo pull-left"> <a href="<?php echo $base;?>"><img src="<?php echo $base.'img/logo.png';?>" /></a> </div>
    <ul class="dropdown-menus">
	  <?php if(!isset($login)):?>
      <li><a href="#" onclick="javascript:showLoginModal();">登录</a></li>
      <li><a href="<?php echo $base.'register/';?>">注册</a></li>
	  <input type="hidden" id="ifcollect" value="0">
      <?php else:?>
	  <li class="drop"><a href="#" onclick="javasrcipt:showmenu();" ><?php echo $user_info['username']; ?></a>
      	<ul id="dropmenu" style="display:none;">
        	<li><a href="<?php echo $base.'demand/';?>">个人空间</a></li>
            <!-- <li><a href="#">我的关注</a></li>
            <li><a href="#">我的评论</a></li>
            <li><a href="#">我的粉丝</a></li> -->
            <li><a href="<?php echo $base.'design/';?>">我的设计</a></li>
            <li><a href="<?php echo $base.'demand/demandlist/';?>">需求广场</a></li>
            <li><a href="<?php echo $base.'news?type=21';?>">知识广场</a></li>
			<?php if($user_info['permission']){?>
			<li><a href="<?php echo $base.'order/orderlist';?>">订单管理</a></li>
			<?}?>
            <li><a href="<?php echo $base."login/logout";?>">退　　出</a></li>
        </ul>
      </li>
	  <input type="hidden" id="ifcollect" value="<?php echo $user_info['ifcollect'];?>">
	  <?php endif; ?>
    </ul>

  </div>

<!-- 
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
</div> -->

<div class="modal login" role="modal" id="login_modal">
    <div class="login-main">
    	<a href="javascript:;" onclick="hideLoginModal()" class="btn-close"><img src="<?php echo $base.'img/dot_gb.png';?>" /></a>
    	<div class="input-control">
        	<span><img src="<?php echo $base.'img/denglu_hy.png';?>" /></span>
            <input type="text" placeholder="登录账号" id="login_username" name="username"/>
        </div>
        <div class="input-control">
        	<span><img src="<?php echo $base.'img/denglu_mm.png';?>" /></span>
            <input  id="login_pswd" name="password" type="password" placeholder="账号密码" />
        </div>
        <a id="head_login" href="javascript:;" class="btn-login" onclick="login_process();">登　录</a>
        <div class="login-footer">
        	<a href="#">忘记密码？</a>&nbsp;|&nbsp;<a href="<?php echo $base.'register/';?>">注册</a>
            <div class="pull-right">
            	其他账号登录：	<a class="xl" href="#"></a><a class="qq" href="#"></a>
            </div>
        </div>
    </div>
</div>
<div class="modalBg" role="modal"></div>


<input type="hidden" value="<?php echo $base; ?>" id="header_base" />
<input type="hidden" value="请稍候......" id="login_wait"/>
<div id="login_msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close" onclick="$('#login_msg_modal').addClass('hide');$('#login_modal_bg').addClass('hide');">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#login_msg_modal').addClass('hide');$('#login_modal_bg').addClass('hide');">确定</button></div>
</div>
<div id="login_modal_bg" class="modal-backdrop hide"></div>