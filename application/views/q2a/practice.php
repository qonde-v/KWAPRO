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


<link rel="stylesheet" href="<?php echo $base.'css/jquery-ui.css';?>">
<script src="<?php echo $base.'js/jquery-1.10.2.js';?>"></script>
<script src="<?php echo $base.'js/jquery-ui.js';?>"></script>
<script>
$(function() {
$( "#slider" ).slider({
value:<?php if(!empty($similar)) echo $similar['strength']; else echo 0;?>,
min: 1,
max: 1.5,
step: 0.1,
slide: function( event, ui ) {
$( "#strength" ).val(ui.value );
}
});
$( "#strength" ).val($( "#slider" ).slider( "value" ) );


$( "#slider1" ).slider({
value:<?php if(!empty($similar)) echo $similar['sporttime']; else echo 0;?>,
min: 0,
max: 2,
step: 0.1,
slide: function( event, ui ) {
$( "#sporttime" ).val(ui.value );
}
});
$( "#sporttime" ).val($( "#slider1" ).slider( "value" ) );

$( "#slider2" ).slider({
value:<?php if(!empty($similar)) echo $similar['temperature']; else echo 0;?>,
min: 0,
max: 50,
step: 1,
slide: function( event, ui ) {
$( "#temperature" ).val(ui.value );
}
});
$( "#temperature" ).val($( "#slider2" ).slider( "value" ) );


$( "#slider3" ).slider({
value:<?php if(!empty($similar)) echo $similar['humidity']; else echo 0;?>,
min: 0,
max: 100,
step: 1,
slide: function( event, ui ) {
$( "#humidity" ).val(ui.value );
}
});
$( "#humidity" ).val($( "#slider3" ).slider( "value" ) );

$( "#slider4" ).slider({
value:<?php if(!empty($similar)) echo $similar['proficiency']; else echo 0;?>,
min: 0,
max: 100,
step: 1,
slide: function( event, ui ) {
$( "#proficiency" ).val(ui.value );
}
});
$( "#proficiency" ).val($( "#slider4" ).slider( "value" ) );

$( "#slider5" ).slider({
value:<?php if(!empty($similar)) echo $similar['age']; else echo 0;?>,
min: 10,
max: 70,
step: 1,
slide: function( event, ui ) {
$( "#age" ).val(ui.value );
}
});
$( "#age" ).val($( "#slider5" ).slider( "value" ) );

$( "#slider6" ).slider({
value:<?php if(!empty($similar)) echo $similar['weight']; else echo 0;?>,
min: 20,
max: 150,
step: 1,
slide: function( event, ui ) {
$( "#weight" ).val(ui.value );
}
});
$( "#weight" ).val($( "#slider6" ).slider( "value" ) );
});
</script>
<script>
function gonext(bz){
	var ob;
	if(bz==3){
		if($('input:radio[name="selecttemp"]:checked').val()==-1){
			//alert('无类似设计请选择空白模板');
			$('.modal-body').html('无类似设计请选择空白模板');
			$('#msg_modal').css('display','block');
			return;
		}
	}
	for(i=1;i<=4;i++){
		ob=document.getElementById('buzhou'+i);
		ob1=document.getElementById('sheji'+i);
		if(i==bz){
			ob.style.display='';
			ob1.className='sheji_bz1';
		}
		else{
			ob.style.display='none';
			ob1.className='sheji_bz2';
		}
	}

}


function save_pic()
{
	$('#save_thumb').text('loading...');
	ajaxUpload('form_pic',$('#base').val()+'design/save_pic/', 'original_photo','',upload_succ);
	$('#save_thumb').text('上传');
}

function upload_succ()
{
	var src = document.getElementById("original_img").src;
	if(src.indexOf('.')>=0)
	{
		//$('#crop_photo').attr('src',src);
		var num = document.getElementById('picNumber').value;
		num++;
		if(num>5){
			$('.modal-body').html('最多上传五张设计图');
			$('#msg_modal').css('display','block');
			return;
		}
		var img = document.createElement("img");
		img.id = "crop_photo"+num;
		img.src = src;
		img.width=140;
		img.height=126;
		img.border=0;
		img.className="img_k";
		document.getElementById('div_pic').appendChild(img);
		document.getElementById('picNumber').value = num;

		$('.modal-body').html('上传成功');
		$('#msg_modal').css('display','block');
	}
}


function designok()
{
	var data = new Array();
	data['title'] = $('#title').val();
	data['demand_id'] = $('#demand_id').val();
	data['selecttemp'] = $('input:radio[name="selecttemp"]:checked').val();
	data['fabric'] = $('input:radio[name="fabric"]:checked').val();
	if($('#crop_photo1').length>0)data['design_pic1'] = get_picname(document.getElementById('crop_photo1').src);
	if($('#crop_photo2').length>0)data['design_pic2'] = get_picname(document.getElementById('crop_photo2').src);
	if($('#crop_photo3').length>0)data['design_pic3'] = get_picname(document.getElementById('crop_photo3').src);
	if($('#crop_photo4').length>0)data['design_pic4'] = get_picname(document.getElementById('crop_photo4').src);
	if($('#crop_photo5').length>0)data['design_pic5'] = get_picname(document.getElementById('crop_photo5').src);


	var post_str = generate_query_str(data);
	var url = $('#base').val() + 'design/designok/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('.modal-body').html(html);
		$('#msg_modal').css('display','block');
	}};
	jQuery.ajax(ajax);
	setTimeout("window.location.href=$('#base').val() + 'design/'",200);

}
function get_picname(picstr)
{
	return picstr.substr(picstr.lastIndexOf("/")+1);
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

<div id="main">
<div id="main_nr">
<div id="index_qp">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">设 &nbsp;&nbsp; 计</div><br>
<br>

<div id="sheji1" class="sheji_bz1"><a href="#" onclick="javascript:gonext(1)" class="White14">开始设计</a></div>
<div class="xuqiu_bz_jt"></div>
<div id="sheji2" class="sheji_bz2"><a href="#" onclick="javascript:gonext(2)" class="White14">选择设计模版</a></div>
<div class="xuqiu_bz_jt"></div>
<div id="sheji3" class="sheji_bz2"><a href="#" onclick="javascript:gonext(3)" class="White14">设计实践</a></div>
<div class="xuqiu_bz_jt"></div>
<div id="sheji4" class="sheji_bz2"><a href="#" onclick="javascript:gonext(4)" class="White14">完成设计</a></div>

<div class="sheji_nr">
<!-- 第一步 -->
<div id="buzhou1" >
<div class="sheji_nr_l">
<input type="hidden" id="demand_id" value="<?php echo $demand['id'];?>"></input>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td width="100%" height="40" valign="middle" align="left"><font class="fDBlack16">需求</font></td>
          </tr>
		  <tr>
            <td width="100%" height="200" valign="top" align="left" style="background-color:#f4f4f7; padding:10px 20px 10px 20px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="20%" height="50" valign="middle" align="right"><font class="fDGray14">描    述：</font></td>
			<td width="80%" valign="middle" align="left"><font class="fBlack14"><?php echo $demand['title'];?></font></td>
          </tr>
		  <tr>
            <td height="50" valign="middle" align="right"><font class="fDGray14">运动类型：</font></td>
			<td valign="middle" align="left"><font class="fBlack14"><?php echo $demand['type'];?></font></td>
          </tr>
		  <tr>
            <td height="50" valign="middle" align="right"><font class="fDGray14">运动场景：</font></td>
			<td valign="middle" align="left"><font class="fBlack14"><?php echo $demand['weather'];?></font></td>
          </tr>
		  <tr>
            <td height="50" valign="middle" align="right"><font class="fDGray14">着装对象：</font></td>
			<td valign="middle" align="left"><font class="fBlack14"><?php echo $demand['target'];?></font></td>
          </tr>
</table>
			</td>
          </tr>
</table>

</div>

<div class="sheji_nr_r">

<div class="sheji_r_tupian"><img src="<?php echo $base.'img/sheji_r_tp.jpg';?>" align="absmiddle" border="0" /></div>
</div>
<div style="width:450px">
	<div class="anniu_g" style="width:45px;text-align:center;background-color:#FF2F2F;float:right"><a href="#" onclick="javascript:gonext(2)" class="White14">下一步</a></div>
</div>
</div>
<!-- 第二步 -->
<div id="buzhou2"  style="display:none">
<div class="sheji_nr_l">
<input type="radio" id="selecttemp" name="selecttemp" value="0" checked="checked" /> 
<div class="anniu_g" style="width:200px;text-align:center;display:inline"><a href="#" class="White14">使用空白模版</a></div>	
<br><br>
 <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="2"><input type="radio" id="selecttemp" name="selecttemp" value="<?php if (!empty($similar)) echo $similar['id']; else echo -1;?>"  /><div class="anniu_g" style="width:150px;text-align:center;display:inline"><a href="#" class="White14">选择类似设计作为模板</a></div></td>
          </tr>
			<?php if (!empty($similar)){?>
		  <tr>
            <td width="30%" height="200" valign="top" align="left" style="background-color:#f4f4f7; padding:10px 20px 10px 20px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr>
				<td width="100%" height="50" valign="middle" align="left"><img src="<?php echo $base.'img/sheji_b_tp.jpg';?>" align="absmiddle" border="0" /></td>
			  </tr>
			</table>
			</td>
			<td width="70%" height="200" valign="top" align="left" style="background-color:#f4f4f7; padding:10px 20px 10px 20px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="20%" height="50" valign="middle" align="right"><font class="fDGray14">需    求：</font></td>
			<td width="80%" valign="middle" align="left"><font class="fBlack14"><?php echo $similar['title'];?></font></td>
          </tr>
		  <tr>
            <td height="50" valign="middle" align="right"><font class="fDGray14">功能参数：</font></td>
			<td valign="middle" align="left">
			<div  style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			强度： 
			<font size="2" color="f6931f">1(轻松)</font>
			<div id="slider" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">1.5(激烈)</font>
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			时间： 
			<font size="2" color="f6931f">0Hour</font>
			<div id="slider1" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">2Hour</font>
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			温度： 
			<font size="2" color="f6931f">0</font>
			<div id="slider2" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">50</font>
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			湿度： 
			<font size="2" color="f6931f">0</font>
			<div id="slider3" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">100</font>
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			熟练度：
			<font size="2" color="f6931f">0(初学者)</font>
			<div id="slider4" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">100(运动达人)</font>
			<input type="hidden" id="proficiency" name="proficiency" >
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			年龄：
			<font size="2" color="f6931f">10</font>
			<div id="slider5" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">70</font>
			<input type="hidden" id="age" name="age" >
			</div>
			<div style="padding:5px;border:1px solid #D9D9D9;">
			体重：
			<font size="2" color="f6931f">20kg</font>
			<div id="slider6" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">150kg</font>
			<input type="hidden" id="weight" name="weight" >
			</div>


			</td>
          </tr>
		  <tr>
            <td height="50" valign="middle" align="right"><font class="fDGray14">仿    真：</font></td>
			<td valign="middle" align="left"><font class="fBlack14">桑拿天</font></td>
          </tr>

</table>
			</td>
          </tr>
		  <?php }else {?>
		  <tr>
		    <td height="50" valign="middle" align="center" style="background-color:#f4f4f7; padding:10px 20px 10px 20px;"><font class="fDOrange16">无类似设计</font></td>
			<td height="50" valign="middle" align="left">
			</td>
          </tr>
		  <?php }?>
</table>
</div>

<div class="sheji_nr_r">
<div class="sheji_r_tupian"><img src="<?php echo $base.'img/sheji_r_tp.jpg';?>" align="absmiddle" border="0" /></div>
</div>
<div style="width:250px;padding-left:200px">
	<div class="anniu_g" style="width:45px;text-align:center;background-color:#FF2F2F;float:left"><a href="#" onclick="javascript:gonext(1)" class="White14">上一步</a></div>
	<div class="anniu_g" style="width:45px;text-align:center;background-color:#FF2F2F;float:right"><a href="#" onclick="javascript:gonext(3)" class="White14">下一步</a></div>
</div>
</div>
<!-- 第三步 -->
<div id="buzhou3"  style="display:none">
<div class="sheji_nr_l" >
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="5"><font class="fDBlack16">上传样式设计图</font> </td>
          </tr>
          <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="5">
			<form id="form_pic" name="form_pic" action="" method="POST" onsubmit="return false;">
				<input name="design_pic" id="design_pic" type="file" />
					<div class="anniu_g" style="width:100px; text-align:center;display:inline"><a id="save_thumb" href="#" onclick="save_pic();" class="White14">上 传</a></div>
					<div id="original_photo" style="text-align:center;display:inline-block"></div>
			</form>
			</td>
          </tr>

		  <tr> 
		    <?php if(!empty($design_pic)){foreach($design_pic as $item): ?>
            <td width="20%" height="180" valign="top" align="center"><img src="<?php echo $base.$base_photoupload_path.'temp/'.$item['pic_url'];?>" align="absmiddle" border="0" width="140" height="126" class="img_k"/><br><br>
			<!-- <a href="#" class="Red"><?php echo $design_pic['pic_title'];?></a> --></td>
			<?php endforeach; }?>
			<input type="hidden" id="picNumber" name="picNumber" value=<?php echo count($design_pic);?>>
			<td width="20%" height="180" valign="top" align="center">
				<div id="div_pic" name="div_pic">
					 <img style="position:relative;" id="crop_photo"  border=0 width="140" height="126" class="img_k"/> 
				</div>
			</td>
          </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="2"><font class="fDBlack16">选择面料</font></td>
          </tr>
		  
		  <tr>
            <td width="100%" height="200" valign="top" align="left" style="padding:10px 20px 10px 20px;" colspan="2">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
		  <?php foreach($fabric as $item): ?>
            <td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/'.$item['pic'];?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br>
			<input type="radio" id="fabric" name="fabric" value="<?php echo $item['id'];?>" <?php if($item['id']==1) echo 'checked';?>/><font color="Red"><?php echo $item['name'];?> </font></td>
			<?php endforeach; ?>
          </tr>
</table>
			</td>
			
          </tr>
</table>
</div>

<div class="sheji_nr_r">
<div class="sheji_r_tupian"><img src="<?php echo $base.'img/sheji_r_tp.jpg';?>" align="absmiddle" border="0" /></div>
</div>
	<div style="width:250px;padding-left:200px">
	<div class="anniu_g" style="width:45px;text-align:center;background-color:#FF2F2F;float:left"><a href="#" onclick="javascript:gonext(2)" class="White14">上一步</a></div>
	<div class="anniu_g" style="width:45px;text-align:center;background-color:#FF2F2F;float:right"><a href="#" onclick="javascript:gonext(4)" class="White14">下一步</a></div>
</div>
	 
</div>

<!-- 第四步 -->
<div id="buzhou4"  style="display:none">
	<div class="sheji_nr_l" >
	<b>请一句话描述您的设计： </b> 
	<input id="title" style="background:transparent;border:1px solid #000000; height:30px; width:350px; padding-top:5px;"> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">

			  <tr>
				<td width="50%" height="40" valign="middle" align="right" style="padding-right:10px;"><div class="anniu_g" style="width:100px; text-align:center;">
	<a href="#" class="White14">提交仿真</a></div> </td>
				<td width="50%" height="40" valign="middle" align="left" style="padding-left:10px;"><div class="anniu_g" style="width:100px; text-align:center;">
	<a href="#" onclick="javascript:designok()" class="White14">保存设计</a></div></td>
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
