<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TIT系统</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<!-- <script src="<?php echo $base.'js/register.js';?>"></script> -->
</head>
<style>
.col-4{ width:33.3333333%; float:left; }
</style>
<script type="text/javascript" >
$(function(){
	$('#username').live('focus',function(){$('#username_suggestion').show();});
	$('#username').live('blur',function(){$('#username_suggestion').hide();});
	
	$('#password').live('focus',function(){$('#pswd_suggestion').show();});
	$('#password').live('blur',function(){$('#pswd_suggestion').hide();});

	$('#passwordc').live('blur',function(){
		if($('#password').val()!=$('#passwordc').val())$('#pswdc_suggestion').show();
		else $('#pswdc_suggestion').hide();
	});

	var err_username = "<?php echo form_error('username'); ?>";
	if(err_username!=''){
		$('#username_suggestion').find('span').find('label').html(err_username);
		$('#username_suggestion').show();
	}
	var err_password = "<?php echo form_error('password'); ?>";
	if(err_password!=''){
		$('#pswd_suggestion').find('span').find('label').html(err_password);
		$('#pswd_suggestion').show();
	}
	var err_passwordc = "<?php echo form_error('passwordc'); ?>";
	if(err_passwordc!=''){
		$('#pswdc_suggestion').find('span').find('label').html(err_passwordc);
		$('#pswdc_suggestion').show();
	}
	var err_email = "<?php echo form_error('email'); ?>";
	if(err_email!=''){
		$('#email_suggestion').find('span').find('label').html(err_email);
		$('#email_suggestion').show();
	}
});

function reset(){
	$('#username').val('');
	$('#password').val('');
	$('#passwordc').val('');
	$('#email').val('');
	$('#qq').val('');
	$('#weibo').val('');
}
function register()
{
	var data = new Array();
	var hint = '';
	data['username'] = $('#username').val();
	data['password'] = $('#password').val();
	data['email'] = $('#email').val();
	data['qq'] = $('#qq').val();
	data['weibo'] = $('#weibo').val();
	

	if(data['username']=='') hint=hint+'请输入用户名称<br/>';
	if(data['password']=='') hint=hint+'请输入用户密码<br/>';
	if(data['email']=='') hint=hint+'请输入邮箱<br/>';

	if(hint!=''){
		$('.modal-body').html(hint);
		$('#msg_modal').removeClass("hide");;
		return;
	}

	var post_str = generate_query_str(data);
	var url = $('#base').val() + 'register/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			//alert('需求描述已存在，请重新输入');
			$('.modal-body').html(html);
			$('#msg_modal').removeClass("hide");
			$('#msg_modal').show();
		
	}};
	jQuery.ajax(ajax);
	
	//setTimeout("window.location.href=$('#base').val() + 'demand/products/?"+post_str+"'",200);
	//window.location.href=$('#base').val() + 'demand/demandlist/';
}
function generate_query_str(data)
{
   var str = "";
   for(var key in data)
   {
      str += key + "="+ data[key]+"&";
   }
   return str.substring(0,str.length-1);  
}
</script>
<body>
<div id="" class="container">
 <?php include("header.php"); ?>

<input type="hidden" id="base" value="<?php echo $base;?>"></input>
 <div id="register" class="main"> 
	<div class="register-main">
    	<div class="register-box">
        	<div class="box-title">
            	<img src="<?php echo $base.'img/logo.png';?>" />
                <label>注册新账号</label>
            </div>
			<form action="<?php echo $base.'register';?>" method="post" id="registerfrom">
            <div class="form-horizontal">
            	<div class="form-group">
                    <label class="col-4 control-label">用户名称：</label>
                    <div class="col-6">
                      <input type="text" id="username" name="username" class="form-control" />
                    </div>
                    <div class="col-2" id="username_suggestion" style="display:none;"><span class="result result-error"><label><?php echo $register_username_suggestion;?></label></span></div>
                 </div>
                 <div class="form-group">
                    <label class="col-4 control-label">设置密码：</label>
                    <div class="col-6">
                      <input type="password"  id="password" name="password" class="form-control" />
                    </div>
                    <div class="col-2" id="pswd_suggestion" style="display:none;"><span class="result result-error"><label><?php echo $register_password_suggestion;?></label></span></div>
                 </div>
                 <div class="form-group">
                    <label class="col-4 control-label">重填密码：</label>
                    <div class="col-6">
                      <input type="password"  id="passwordc" name="passwordc" class="form-control" />
                    </div>
                    <div class="col-2" id="pswdc_suggestion" style="display:none;"><span class="result result-error"><label>输入密码前后不一致</label></span></div>
                 </div>
                 <div class="form-group">
                    <label class="col-4 control-label">邮　　箱：</label>
                    <div class="col-6">
                      <input type="text" id="email" name="email" class="form-control" />
                    </div>
                    <div class="col-2" id="email_suggestion" style="display:none;"><span class="result result-error"><label></label></span></div>
                 </div>
                 <div class="form-group">
                    <label class="col-4 control-label">QQ&nbsp;<small>非必填</small>：</label>
                    <div class="col-6">
                      <input type="text"  id="qq" name="qq" class="form-control" />
                    </div>
                    <div class="col-2"><span class="result"></span></div>
                 </div>
                 <div class="form-group">
                    <label class="col-4 control-label">微博&nbsp;<small>非必填</small>：</label>
                    <div class="col-6">
                      <input type="text"  id="weibo" name="weibo" class="form-control" />
                    </div>
                    <div class="col-2"><span class="result"></span></div>
                 </div>
            </div>
			</form>
            <div class="form-footer">
            	<div class="btns">
                	<a class="btn-register" href="javascript:;" onclick="javascript:$('#registerfrom').submit();">注&nbsp;册</a>
                    <a class="btn-reset" href="javascript:;" onclick="javascript:reset();">重&nbsp;置</a>
                </div>
                <div class="links">
                	<a href="#">返回之前的页面</a>
                    <a class="pull-right" href="#">未完成注册，无法登录账号</a>
                </div>
            </div>
        </div>
    </div>
  </div>
  				 
<div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" onclick="$('#msg_modal').addClass('hide');" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').addClass('hide');">确定</button></div>
</div>

<?php include("footer.php");?>

  </div>  
  </body>
	
</html>   
    