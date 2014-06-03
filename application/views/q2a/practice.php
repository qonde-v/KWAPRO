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
function gonext(bz){
	var ob;
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
<input type="radio" id="selecttemp" name="selecttemp" value="1" checked="checked" /> 
<div class="anniu_g" style="width:200px;text-align:center;display:inline"><a href="#" class="White14">使用空白模版</a></div>	
<br><br>
 <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="2"><input type="radio" id="selecttemp" name="selecttemp" value="2"  /><div class="anniu_g" style="width:150px;text-align:center;display:inline"><a href="#" class="White14">选择类似设计作为模板</a></div></td>
          </tr>
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
			<td width="80%" valign="middle" align="left"><font class="fBlack14">在桑拿天跑步的大人</font></td>
          </tr>
		  <tr>
            <td height="50" valign="middle" align="right"><font class="fDGray14">功能参数：</font></td>
			<td valign="middle" align="left"><font class="fBlack14">1646546</font></td>
          </tr>
		  <tr>
            <td height="50" valign="middle" align="right"><font class="fDGray14">仿    真：</font></td>
			<td valign="middle" align="left"><font class="fBlack14">桑拿天</font></td>
          </tr>
		  <!-- <tr>
		    <td height="50" valign="middle" align="right"></td>
			<td height="50" valign="middle" align="right">
			<div class="anniu_g" style="width:100px; text-align:center;"><a href="#" class="White14">选择</a></div>
			</td>
          </tr> -->
	  

</table>
			</td>
          </tr>
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
            <td width="100%" height="40" valign="middle" align="left" colspan="5"><div class="anniu_g" style="width:100px; text-align:center;">
<a href="#" class="White14">上 传</a></div></td>
          </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="5"><INPUT id="" name=""  type="radio" value="radio"  checked> 请上传样式设计图</td>
          </tr>
		  <tr>
            <td width="20%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/tuijianchanpin01.jpg';?>" align="absmiddle" border="0" width="140" height="126" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
			<td width="20%" valign="top" align="center"><img src="<?php echo $base.'img/tuijianchanpin01.jpg';?>" align="absmiddle" border="0" width="140" height="126" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
			<td width="20%" valign="top" align="center"><img src="<?php echo $base.'img/tuijianchanpin01.jpg';?>" align="absmiddle" border="0" width="140" height="126" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
			<td width="20%" valign="top" align="center"><img src="<?php echo $base.'img/tuijianchanpin01.jpg';?>" align="absmiddle" border="0" width="140" height="126" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
			<td width="20%" valign="top" align="center"><img src="<?php echo $base.'img/tuijianchanpin01.jpg';?>" align="absmiddle" border="0" width="140" height="126" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
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
            <td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/buliao01.jpg';?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
			<td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/buliao02.jpg';?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
<td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/buliao03.jpg';?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
<td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/buliao04.jpg';?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
<td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/buliao05.jpg';?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
<td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/buliao06.jpg';?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
<td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/buliao07.jpg';?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br>
<a href="#" class="Red">李宁AKSH321-2</a></td>
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


<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="50%" height="40" valign="middle" align="right" style="padding-right:10px;"><div class="anniu_g" style="width:100px; text-align:center;">
<a href="#" class="White14">提交仿真</a></div> </td>
            <td width="50%" height="40" valign="middle" align="left" style="padding-left:10px;"><div class="anniu_g" style="width:100px; text-align:center;">
<a href="#" class="White14">保存设计</a></div></td>
          </tr>
</table>
</div>

<div class="sheji_nr_r">
<div class="sheji_r_tupian"><img src="<?php echo $base.'img/sheji_r_tp.jpg';?>" align="absmiddle" border="0" /></div>
</div>
		 
</div>


	
</div>




</div>


</div>
</div>


<!------------ 底部开始 ------------->
<?php include("footer.php");?>

</body>
</html>
