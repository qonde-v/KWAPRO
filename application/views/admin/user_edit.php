<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户信息管理</title>
<!-- <link href="<?php echo $base."css/style_1.css";?>" rel="stylesheet" type="text/css" id="cssfile"/> -->
<link href="<?php echo $base."css/tag.css";?>" rel="stylesheet"	type="text/css" />
<link href="<?php echo $base."css/jquery/jquery.validate.cmxform.css";?>"	rel="stylesheet" type="text/css" />
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
<input type="hidden" id="uri" value="<?php echo $base."admin/news/"?>"/>
	<div class="container-fluid">
	<div class="row-fluid">
		<?include(dirname(__FILE__).'/nav.php');?>
		<div id="content" style="padding-left:230px;">
			<div class="box" style="margin-top:0px;">
				<div class="box-header well" data-original-title>
							<h4><i class="icon-edit"></i>用户信息管理</h4>
							
				</div>
				<span style="color:red;"><?php echo (isset($saveinfo)?$saveinfo:"");?></span>
				<form action="<?php echo $base.$uri?>" name="frm_table" method="post" id="frm_table">
				<table id="companyInfo" width="100%" >
					<tr>
						<th width="13%"><label class="control-label" >用户名</label></th>
						<td>
						    <?php if(empty($info['id'])){?>
							<input class="txtInput" type="text" name="userCode" value="<?=$info['userCode']?>"/>
							<?php }else{?>
							<input class="txtInput" type="hidden" name="userCode" value="<?=$info['userCode']?>"/>
							<?=$info['userCode']?>
							<?php }?>
						</td>
					</tr>
					<tr>
						<th width="13%"><label class="control-label" >昵称</label></th>
						<td width="37%">
							<input class="txtInput" type="text" name="nickname" value="<?=$info['nickname']?>"/>
						</td>
					</tr>
					<tr>
						<th width="13%"><label class="control-label" >用户权限</label></th>
						<td>
							<input type="radio" id="roleId" name="roleId" value="1" checked="checked" style="margin-left:10px" /> 管理员
							<input type="radio" id="roleId" name="roleId" value="0" style="margin-left:20px" /> 普通人员
						</td>
					</tr>
				</table>
				<?php if(empty($info['id'])){?>
				<span style="float:right;color:red; font-size: 11px;">新增用户密码默认111，请自行修改</span>
				<?php }?>
				<span style="color:red;"><?php echo validation_errors(); ?></span>
				<div class="form-actions" align="center">
					<button type="submit"   id="submit1" class="btn btn-primary" >保存</button>
					
				</div>
				<input type="hidden" name="id" value="<?=$info['id']?>"/>
				</form>
				
			</div>
		</div>
	</div>
	</div>
</body>
<script src="<?php echo $base."js/jquery/jquery-1.7.1.min.js";?>"></script>
<script src="<?php echo $base."js/jquery/jquery.validate.min.js";?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base."js/bootstrap.js";?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base."js/bootstrap3-validation.js";?>"></script>

<style type="text/css">
.txtInput{
	width:120px;
}
</style>
<script language="javascript" type="text/javascript">
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
//保存提交
/*
function submit_opt(){
	var msg = "是否保存修改";
	var result = window.confirm(msg);
	if (result) {
		frm_table.submit();
	}
}
*/
</script>


</html>