<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新闻信息维护</title>
<!-- <link href="<?php echo $base."css/style_1.css";?>" rel="stylesheet" type="text/css" id="cssfile"/> 
<link href="<?php echo $base."css/bootstrap.css";?>" rel="stylesheet" type="text/css" id="cssfile"/>-->

<style type="text/css">
.txtInput{
	width:160px;
}
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

	<div class="container-fluid">
	<div class="row-fluid">
		<?include(dirname(__FILE__).'/nav.php');?>

		<div id="content" style="padding-left:230px;">
			<div class="box" style="margin-top:0px;">
				<div class="box-header well" data-original-title>
							<h4><i class="icon-edit"></i>新闻信息</h4>
				</div>
			<span style="color:red;"><?php echo (isset($saveinfo)?$saveinfo:"");?></span>
			<form action="<?php echo $base.$uri?>" name="frm_table" method="post" id="form1">
				<table id="companyInfo" class="table_frm" width="100%">
					<tr>
						<th width="13%">新闻类型</th>
						<td width="37%" colspan='3'>
							<select name="type" id="type" >
								<option value="1" <?php if($info['type']==1) echo 'selected'; ?>>运动</option>
								<option value="2" <?php if($info['type']==2) echo 'selected'; ?>>服装</option>
								<option value="3" <?php if($info['type']==3) echo 'selected'; ?>>明星</option>
							</select>
						</td>
					</tr>
					<tr>
						<th width="13%">作者</th>
						<td width="37%" colspan="3">
							<input class="txtInput" type="text" name="author" value="<?=$info['author']?>"/>
						</td>
					</tr>
					<tr>
						<th width="13%">来源</th>
						<td  colspan="3">
							<input type="text" class="txtInput" id="source" name='source' value="<?=$info['source']?>">
						</td>
					</tr>
					<tr>
						<th width="13%">显示</th>
						<td  colspan="3">
							<input type="checkbox"  id="isfirst" name="isfirst" value="1" <?php if($info['isfirst']==1)echo 'checked'; else echo '';?>>首页
							<input type="checkbox"  id="isbest" name="isbest" value="1" <?php if($info['isbest']==1)echo 'checked'; else echo '';?>>精华推荐
						</td>
					</tr>
					<tr>
						<th width="13%">新闻标题</th>
						<td>
							<input class="txtInput" style="width:400px" type="text" name="title" value="<?=$info['title']?>" check-type="required" required-message="请填写新闻标题！"/>
							
						</td>
					</tr>
					<tr>
						<th width="13%">文章内容</th>
						<td>
							<textarea name="content" rows="10" check-type="required" required-message="请填写新闻内容！"> <?=$info['content']?></textarea>
						</td>
					</tr>

			<input type="hidden" name="id" id="id" value="<?=$info['id']?>"/>
			<input type="hidden" name="createid" value="<?=$info['createid']?>"/>
			<input type="hidden" name="createTime" value="<?=$info['createTime']?>"/>

			</form>
						<tr>
						<th>添加相关图片：</th>
						<td colspan="5">
							<div class="span5">
							<form id="upload_picture_form" target="hidden_frame" action="<?php echo $base.'admin/news/upload_picture'; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
									<span>仅支持jpg,png,gif格式的图片</span>
									<input class="input-file" name="picture_file"  id="picture_file" type="file" onchange="fileChange(this);">
									<input type="submit" id="submit_picture" class="btn btn-success" name="submit_picture" value="上传图片" onclick="return upload_picture();" >
									
									<div id="upload_tips"  style="display: none;">
										<img id="waiting_img" src="<?php echo $base."img/waiting.gif";?>" alt="上传中...">
									</div>
									<input type="hidden" name="id" id="id" value="<?=$info['id']?>"/>
							<iframe name='hidden_frame' id="hidden_frame" style='display:none'></iframe>
							</form>
							</div>
							<div class="" id="related_picture">
								<?php include "related_picture_default.php"?>
							</div>
						</td>
					</tr>
					
</table>
			<span style="color:red;"><?php echo validation_errors(); ?></span> 
			<div class="admintitle" align="center">
				<button  type="submit" id="submit1"  class="btn btn-primary" >保存</button>

				<a href="javascript:go_list();" style="padding:0px; margin:0px; margin-left:100px;">
					<img border="0"  align="absmiddle"  src="<?php echo $base."img/go_back.png";?>" alt="返回" />
				</a>
			</div>
		</div>
	</div>
	</div>
	


</body>
<script language="javascript" type="text/javascript" 
	src="<?php echo $base."js/public.js";?>" charset="gb2312"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base."js/jquery/jquery-1.7.1.min.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.form.js";?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base."js/bootstrap.js";?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base."js/bootstrap3-validation.js";?>"></script>

<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/orderedit.js";?>"></script>
<script type="text/javascript">
	//保存提交
    $("#submit1").on('click',function(event){
      // 2.最后要调用 valid()方法。
      if ($("#form1").valid()==false){
        return false;
      }else{
		  			frm_table.submit();

	  }
    })
	//返回列表
	function go_list(){
		window.location.href="<?php echo $base.'admin/news?createid='.$createid;?>";
	}
    $("#productid").change(function(){
      // 设置所有定制菜单隐藏
	  $(".productid").css('display','none');
	  $(".productid_"+$(this).val()).css('display','');
		if($(this).val()==2){
			$('#policyamount').attr('readonly','readonly');
		}else{
			$('#policyamount').removeAttr('readonly');
			$('#policyamount').val('');
		}

    });
	$('.calculate').change(function(){
		if($(this).val()!=''){
			$(this).parent().parent().find($('.calculatecheck')).attr('checked','true');
		}else{
			$(this).parent().parent().find($('.calculatecheck')).removeAttr('checked');

		}
		var summoney=0;
		$(".calculatecheck").each(function() {
		 if($(this).attr('checked')){
			//summoney+=$(this).parent().parent().find($('.calculatemoney')).val()*$(this).parent().parent().find($('.calculatenum')).val();
			summoney+=$(this).parent().parent().find($('.calculatemoney')).val()*1;
		 }
		});
		$('#policyamount').val(summoney);

	});
	$('.calculatecheck').click(function(){
		var summoney=0;
		$(".calculatecheck").each(function() {
		 if($(this).attr('checked')){
		//	summoney+=$(this).parent().parent().find($('.calculatemoney')).val()*$(this).parent().parent().find($('.calculatenum')).val();
			summoney+=$(this).parent().parent().find($('.calculatemoney')).val()*1;
		 }
		});
		$('#policyamount').val(summoney);

	});
	$(function(){
		    $("#form1").validation();
			$("#productid").change();

	});

</script>



</html>