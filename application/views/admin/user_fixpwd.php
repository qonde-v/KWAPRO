<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户信息管理</title>
<!-- <link href="<?php echo $base."css/bootstrap.css";?>" rel="stylesheet" type="text/css" id="cssfile"/> -->

<style type="text/css">
table tbody th {
    border-top: 1px solid #ddd;
    vertical-align: top;
}
table th {
    font-weight: bold;
    padding-top: 9px;
}
</style>

</head>
<body>

<?include("page_head.php");?>
<input type="hidden" id="uri" value="<?php echo $base."admin/news"?>"/>
	<div class="container-fluid">
	<div class="row-fluid">
		<?include(dirname(__FILE__).'/nav.php');?>
		<div id="content" style="padding-left:230px;">
			<div class="box" style="margin-top:0px;">
				<div class="box-header well" data-original-title>
							<h4><i class="icon-edit"></i>用户密码修改</h4>
				</div>
				<span style="color:red;"><?php echo (isset($saveinfo)?$saveinfo:"");?></span>
				<form action="<?php echo $base.$uri?>" name="frm_table" method="post" id="frm_table">
				<table id="companyInfo" width="100%">
					<tr>
						<th width="13%">用户名</th>
						<td>
							<input class="txtInput" type="hidden" name="userCode" value="<?=$info['userCode']?>"/>
							<?=$info['userCode']?>
						</td>
						<th width="13%">昵称</th>
						<td width="37%">
							<input class="txtInput" type="hidden" name="nickname" value="<?=$info['nickname']?>"/>
							<?=$info['nickname']?>
						</td>
					</tr>
					<tr>
						<th width="13%">密码</th>
						<td>
							<input id="pwd1" class="txtInput" type="password" name="pwd1"  check-type="required" minlength="6" someinput='pwd2'  style='width:120px;' required-message="请填写密码！"/>
							
						</td>
						<th width="13%">确认密码</th>
						<td>
							<input id="pwd2" class="txtInput" type="password" name="pwd2"  check-type="required" minlength="6" someinput='pwd1' style='width:120px;' required-message="请确认密码！"/>
						</td>
					</tr>
				</table>
				<span style="color:red;"><?php echo validation_errors(); ?></span>
				<div class="admintitle" align="center">
					<button type="submit"   id="submit1" class="btn btn-primary">保存</button>
					
				</div>
				<input type="hidden" name="id" value="<?=$info['id']?>"/>
				</form>
				
			</div>
		</div>
	</div>
	</div>
</body>
<script language="javascript" type="text/javascript" src="<?php echo $base."js/jquery/jquery-1.7.1.min.js";?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base."js/bootstrap.js";?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base."js/bootstrap3-validation.js";?>"></script>

<script language="javascript" type="text/javascript">
//保存提交
/*
function submit_opt(){
	var pwd1 = $("#pwd1").val();
	var pwd2 = $("#pwd2").val();

	if(len(pwd1)<6 || len(pwd2)<6 ){
		alert("密码必须大于等于6位");
	} else if(pwd1 != pwd2){
		alert("两次输入密码必须一致");
	}else {
		var msg = "是否确认修改密码";
		var result = window.confirm(msg);
		if (result) {
			frm_table.submit();
		}
	}	
}

function len(s) { 
	var l = 0; 
	var a = s.split(""); 
	for (var i=0;i<a.length;i++){
		if (a[i].charCodeAt(0)<299) {
			l++;
		} else {
			l+=2; 
		} 
	} 
	return l; 
}
*/
	$(function(){
		    $("#frm_table").validation();
	});
    $("#submit1").on('click',function(event){
      // 2.最后要调用 valid()方法。
      if ($("#frm_table").valid()==false){
			return false;
      }else{
		  	frm_table.submit();
	  }
    });
</script>
</html>