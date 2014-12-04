<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIT后台</title>

<link href="<?php echo $base."css/index.css";?>" rel="stylesheet" type="text/css"  id="cssfile" />
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>

<script type="text/javascript" language='javascript'>
	$(document).ready(function(){
//用户名框鼠标焦点移进，文字消失 
	$("#txt_userCode").click(function () {
		var check_username = $(this).val(); 
		if (check_username == this.defaultValue) { 
		$(this).val(""); 
		$(this).css("color","#000000");
		} 
	}); 
//用户名框鼠标焦点移出，文字显示 
	$("#txt_userCode").blur(function () {
		var check_username = $(this).val(); 
		if (check_username == this.defaultValue || check_username == "") { 
		$(this).val(this.defaultValue); 
		$(this).css("color","#a7a7a7");
		} 

	}); 
//密码框鼠标焦点移进，文字消失 
	$("#pwd input").click(function () { 
		alert("d");
		if ($(this).val() == "密码" || $(this).val() == "") { 
		$("#pwd").html("<input type=\"password\" name=\"pwd\" class=\"text_mm\" value=\"\" />"); 
		$("#pwd input").focus();
		} 
	//密码框鼠标焦点移出，文字显示 
		$("#pwd input").blur(function () { 
			if ($(this).val() == "密码" || $(this).val() == "") { 
			$("#pwd").html("<input type=\"text\" name=\"pwd\" class=\"text_mm\" value=\"密码\" />"); 
			}
		}); 
	}); 

	});
function showtext() {   
    if($("#pwd input").val()=="") {   
    $("#pwd").html("<input type=\"text\" name=\"pwd\" value=\"密码\" class=\"text_mm\" onfocus=\"showpwd();\" />");
    $("#pwd input").css("color","#a7a7a7");
    }   
}   
  
function showpwd() {   
    $("#pwd").html("<input type=\"password\" name=\"pwd\" value=\"\" class=\"text_mm\" onblur=\"showtext();\" />" );   
    $("#pwd input").css("color","#000000");
    /**  
    这里为什么要用setTimeout，因为ie比较傻，刚创建完对象，你直接设置焦点  
    在ie下是不会响应的，你必须留出时间给ie缓冲下，所以加上了这个定时器  
    **/  
    setTimeout(function(){   
    $("#pwd input").focus();   
    },20);  
    } 
	function Init(){
		var eVal=document.getElementById("sessionErr").value;
		if(eVal){
			alert(eVal);
		}
	}

	
</script>
</head>
<BODY onload="Init()">
<input id="sessionErr" type="hidden" value="<?php if(isset($_SESSION['err'])) echo $_SESSION['err'];?>"/>
<?php
  $_SESSION['err'] = "";
?>


<input type="hidden" value="<?php echo $base;?>" id="header_base" />
<div id="login_main">
<table width="100%" border="0" cellpadding="0" cellspacing="5" >
          <tr>
            <td width="" valign="top" align="left" style="padding-top:25px;">
			<table border="0" cellpadding="0" cellspacing="0" align="center">
				  <tr>
					<td width="330" valign="top" align="center" colspan="2" >
					<form action="" method="post">
					<div style="border:2px;border-radius:5px;background-color:#CCCCCC;padding:16px;">
						<table width="240" border="0" cellpadding="0" cellspacing="0" align="center" style="padding-left:20px;">
							  <tr>
								<td width="240" height="20" valign="middle" align="left" colspan="2" style="height:50px;"><span style="color:#000000;font-size:22px">登录</span></td>
							  </tr>
							  <tr>
								<td width="240" valign="middle" align="left" colspan="2">
									<div style="border:1px solid #cccccc;border-top-left-radius:5px;border-top-right-radius:5px;background:#ffffff;padding:10px;width:280px;margin-right:20px;">
										<img src="<?php echo $base.'img/index_login_user.png';?>"/>
										<input class="text_dl" id="txt_userCode" name="userCode" type="text" value="用户名" />
									</div>
								</td>
							  </tr>
							  <tr>
								<td width="240" valign="middle" align="left" colspan="2">
									<div style="border:solid #cccccc 1px; border-top:0px; border-bottom-left-radius:5px;border-bottom-right-radius:5px;background:#ffffff;padding:10px; width:280px;">
										<img  src="<?php echo $base.'img/index_login_pwd.png';?>"/>
										<span id="pwd">
										<input class="text_mm" name="pwd" value="密码" onfocus="showpwd();"/></span>
									</div>
								</td>
							  </tr>
							  <tr>
								<td width="120" height="30" valign="middle" align="left">
									<div class="login_error"><?php echo validation_errors(); ?> </div>
								</td>
							  </tr>
							  <tr>
								<td width="240" height="45" valign="top" align="left" colspan="2">
									<input style="border:2px;border-radius:5px;background-color:#5B9E13; padding:6px 45px 6px 45px; color:white;font-size:14px;cursor:pointer;" type="submit" name="Submit" value="登录" />
								</td>
							  </tr>
						</table>
					</div>
					</form>
					</td>
				  </tr>				  
			 </table>
			
			</td>
            
          </tr>
		  
</table>
</div>


</BODY>
</HTML>
