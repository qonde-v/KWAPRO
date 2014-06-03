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


</head>
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->





<!------------ 内容开始 -------------> 


<div id="main">
<div id="main_nr">
<div id="index_lx">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">需 &nbsp;&nbsp; 求</div>
<div class="gray_q_bt14" style="width:825px; height:40px; margin-bottom:10px;">当前设计：<b>555   </b>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   需求：<b>5665   </b>        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        设计：<b>9889</b>

</div>

<div class="index_news">
	<div class="index_news_bt">
	<b><?php echo $consult['title'];?> </b>
	</div>
	
	<div class="index_news_fbt">
	时间：<?php echo $consult['createdate'];?>&nbsp;&nbsp;&nbsp;&nbsp;发布人：<?php echo $consult['username'];?>
	</div>
	
	<div class="index_news_zw">
	<div class="index_l_xqnr">
	<b>问题内容：</b><?php echo $consult['question'];?>
	<br>
	<b>回答：</b><?php echo $consult['answer'];?>
	</div>
	</div>
	

</div>





</div>

<div id="index_rx">
<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 发布需求，定制你的专属 </div>

<div class="text_k_black text_sjxq" style="margin-top:10px;">
<table width="97%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="15%" height="30" align="center" valign="middle"><img src="<?php echo $base.'img/dot_01.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">创建一个需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"><img src="<?php echo $base.'img/dot_02.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">选择你的需求参数</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"><img src="<?php echo $base.'img/dot_03.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">描述你的需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"><img src="<?php echo $base.'img/dot_04.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">发布需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"></td>
			  <td width="85%" align="left" valign="middle">-> 对外发布，让别人为你服务</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"></td>
			  <td width="85%" align="left" valign="middle">-> 自己动手设计</td>
            </tr>
</table>
</div>

<div  style="text-align:center; margin-bottom:15px; margin-top:15px;"> 
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="100%" height="30" align="center" valign="middle">
			  <div class="anniu_h" style="width:220px; text-align:center;">
<a href="<?php echo $base.'demand/publish';?>" class="White14">发布需求</a></div></td>
            </tr>
			</table>

 </div>

<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 最新动态 </div>


<div class="index_r_xwnr_tpx" style="margin-bottom:15px;">
<img src="<?php echo $base.'img/index_r001.png';?>" align="absmiddle" border="0" width="294" height="201"/><br>
<div class="index_r_sjxq_bt">参与人：<a href="#" class="Red14">李小小</a>  参与时间：2014-03-25</div>
</div>
<br><br>

<div class="index_r_xwnr_tpx">
<img src="<?php echo $base.'img/index_r002.png';?>" align="absmiddle" border="0" width="294" height="201"/><br>
<div class="index_r_sjxq_bt">参与人：<a href="#" class="Red14">李小小</a>  参与时间：2014-03-25</div>
</div>

</div>
</div>
</div>


<!------------ 底部开始 ------------->
<?php include("footer.php");?>

</body>
</html>
