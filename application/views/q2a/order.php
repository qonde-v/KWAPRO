<!DOCTYPE html>

<html>
<head>
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>



<script>
function submit_order()
{
	var data = new Array();
	data['realname'] = $('#realname').val();
	data['address'] = $('#address').val();
 	data['tel'] = $('#tel').val();
	data['remark'] = $('#remark').val();
	data['design_id'] = $('#design_id').val();

	var post_str = generate_query_str(data);
	var url = $('#base').val() + 'design/submit_order/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('.modal-body').html(html);
		$('#msg_modal').css('display','block');
	}};
	jQuery.ajax(ajax);
	setTimeout("window.location.href=$('#base').val() + 'order/'",200);

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

</head>
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->





<!------------ 内容开始 -------------> 
<input type="hidden" id="base" value="<?php echo $base;?>"></input>
<input type="hidden" id="design_id" value="<?php echo $design_id;?>"></input>
<div id="main">
<div id="main_nr">
<div id="index_qp">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">设 &nbsp;&nbsp; 计</div><br>
<br>

<div id="sheji1" class="sheji_bz2"><a href="#" onclick="javascript:gonext(1)" class="White14">完善个人资料信息</a></div>
<div class="xuqiu_bz_jt"></div>

<div class="sheji_nr">

<!-- 第四步 -->
<div id="buzhou4">
	<div class="sheji_nr_l" >
	<b>收件人： </b> 
	<input id="realname" style="background:transparent;border:1px solid #000000; height:30px; width:350px; padding-top:5px;"><br><br>
	<b>地&nbsp;&nbsp;&nbsp;址： </b> 
	<input id="address" style="background:transparent;border:1px solid #000000; height:30px; width:350px; padding-top:5px;"><br><br>
	<b>电&nbsp;&nbsp;&nbsp;话： </b> 
	<input id="tel" style="background:transparent;border:1px solid #000000; height:30px; width:350px; padding-top:5px;"><br><br>
	<b>备&nbsp;&nbsp;&nbsp;注： </b> 
	<input id="remark" style="background:transparent;border:1px solid #000000; height:30px; width:350px; padding-top:5px;"><br><br>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">

			  <tr>
				<td width="100%" height="40" valign="middle" align="center" >
				<div class="anniu_g" style="width:100px; text-align:center;"><a href="javascript:submit_order()" class="White14">提交订单</a></div> 
				</td>
			  </tr>
	</table>
	</div>

<div class="sheji_nr_r">
<div class="sheji_r_tupian"><img src="<?php echo $base.'img/sheji_r_tp.jpg';?>" align="absmiddle" border="0" /></div>
</div>
		 
</div>

<div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" onclick="$('#msg_modal').css('display','none');" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').css('display','none');">确定</button></div>
</div>
	
</div>




</div>


</div>
</div>


<!------------ 底部开始 ------------->
<?php include("footer.php");?>

</body>
	<script src="<?php echo $base.'js/ajaxupload.js';?>"></script>

</html>
