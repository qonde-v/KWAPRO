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
<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
</head>
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 


<div id="main">
<div id="main_nr">
<div id="index_qp">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">个人空间</div>

<div class="sheji_nr">
<div class="gerenkongjian_l">

<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#f4f4f7" style="padding:10px;">
		  <tr>
            <td width="30%" height="100" valign="middle" align="left"><img src="<?php echo $base.'img/gerentouxiang.png';?>" align="absmiddle" border="0" /></td>
			<td width="70%" height="100" valign="middle" align="left">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="50%" height="33" valign="middle" align="right" class="fGray">用户名：</td>
			<td width="50%" valign="middle" align="left"><?php echo $user_info['username']; ?></td>
          </tr>
		  <tr>
            <td height="33" valign="middle" align="right" class="fGray">性别：</td>
			<td valign="middle" align="left"><?php if($user_info['gender']==0)echo '男'; else echo '女' ?></td>
          </tr>
		  <tr>
            <td height="33" valign="middle" align="right" class="fGray">地点：</td>
			<td valign="middle" align="left">广州</td>
          </tr>
</table>
			</td>
          </tr>
		  <tr>
            <td width="100%" height="30" valign="middle" align="left" colspan="2"><font class="fGray">标签</font></td>
          </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="2">
			<?php foreach($hot_tags as $tag_item): ?>
				<a href="<?php echo $base.'question_pool/question4tag/'.$tag_item['tag_id'];?>"><?php echo $tag_item['tag_name'];?></a>
			<?php endforeach; ?>
			<a href="#" class="Blue">爬山</a>&nbsp;&nbsp;<a href="#" class="Blue">跑步</a>&nbsp;&nbsp;<a href="#" class="Blue">羽毛球</a>&nbsp;&nbsp;<a href="#" class="Blue">跑步</a>&nbsp;&nbsp;<a href="#" class="Blue">羽毛球</a></td>
          </tr>
</table>
<br>

<table width="100%" border="0" cellpadding="0" cellspacing="00" align="center" bgcolor="#f4f4f7">
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_h"><a href="<?php echo $base.'demand/';?>" class="Black16">需&nbsp;&nbsp;求</a></td>
		  </tr>
		  <tr>
            <td width="100%" height="5" valign="middle" align="center" bgcolor="#FFFFFF"><font style="font-size:4px;">&nbsp;</font></td>
		  </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_hui"><a href="<?php echo $base.'design/';?>" class="Red16">设&nbsp;&nbsp;计</a></td>
		  </tr>
		  <tr>
            <td width="100%" height="5" valign="middle" align="center" bgcolor="#FFFFFF"><font style="font-size:4px;">&nbsp;</font></td>
		  </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_hui"><a href="<?php echo $base.'material/';?>" class="Red16">素&nbsp;&nbsp;材</a></td>
		  </tr>
		  <tr>
            <td width="100%" height="5" valign="middle" align="center" bgcolor="#FFFFFF"><font style="font-size:4px;">&nbsp;</font></td>
		  </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_hui"><a href="<?php echo $base.'consult/';?>" class="Red16">咨&nbsp;&nbsp;询</a></td>
		  </tr>
		  <tr>
            <td width="100%" height="5" valign="middle" align="center" bgcolor="#FFFFFF"><font style="font-size:4px;">&nbsp;</font></td>
		  </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_hui"><a href="<?php echo $base.'messages/';?>" class="Red16">留&nbsp;&nbsp;言</a></td>
		  </tr>
</table>

</div>

<div class="gerenkongjian_r">
<input type="hidden" id="base" value="<?php echo $base;?>"></input>
<font class="fDBlack16">&nbsp;&nbsp;我提交的需求</font><br><br>
<table width="100%" border="0" cellpadding="0" cellspacing="10" align="center">
          <tr>
            <td width="100%" height="" valign="middle" align="right">
<table width="100%" border="0" cellpadding="0" cellspacing="10" align="center" style="border:1px #f4f4f7 solid;">
<tbody id="content">
		  <?php $i=0; foreach($demands as $item): $i++?>
          <tr>
            <td width="85%" height="40" valign="middle" align="left" ><a href="<?php echo $base.'demand/demand_detail?id='.$item['id'];?>" class="Red14"><?php echo $i.'、'.$item['title']?></a></td>
			<td width="15%" height="40" valign="middle" align="right">
			<div class="red_bt15" style="width:35px; text-align:center;float:left"><a href="<?php echo $base.'demand/publish';?>" class="White14">发布</a></div> &nbsp;&nbsp;&nbsp;&nbsp;
			<div class="red_bt15" style="width:45px; text-align:center;float:right"><a href="<?php echo $base.'design/practice?id='.$item['id'];?>" class="White14">去设计</a></div>
			</td>
          </tr>
		  <tr>
            <td width="50%" height="40" valign="middle" align="left">
			<a href="#" class="DBlue"><?php echo $item['designnum']?></a> 设计 &nbsp;&nbsp;&nbsp;&nbsp;
			<a href="#" class="DBlue"><?php echo $item['viewnum']?></a> 浏览 &nbsp;&nbsp;&nbsp;&nbsp;
			<a href="#" class="DBlue"><?php echo $item['messnum']?></a> 留言 &nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td width="50%" height="40" valign="middle" align="right" class="fGray"><?php echo $item['createdate']?></td>
          </tr>
		  <?php endforeach; ?>
</tbody>		  
</table>
</td></tr>
<tr><td>
					  <?php if($inbox_page_num > 1):?>	
					  <div class="pagination" >
						    <ul id="<?php echo $inbox_page_num;?>">
						    	<li class="first"><a href="#" id="pagination_1">首页</a></li>
						    	<li class="prev disabled"><a href="#" id="pagination_0">&larr; 上一页</a></li>
								<li class="active"><a href="#" id="pagination_1">1</a></li>
								<?php if($inbox_page_num > 10):?>
								<?php for($i=2;$i<=10;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
								<?php else:?>
								<?php for($i=2;$i<=$inbox_page_num;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
								<?php endif;?>
								<li class="next"><a href="#" id="pagination_2">下一页&rarr;</a></li>
								<li class="last"><a href="#" id="<?php echo 'pagination_'.$inbox_page_num;?>">尾页</a></li>
						    </ul>
					  </div>
					  <?php endif;?>

</td></tr>	

</table>

</div>


		 
</div>
	

	
</div>




</div>


</div>


<!------------ 底部开始 ------------->
 <div class="foot">
	    <?php include("footer.php");?>
 </div><!--footer-->
</body>
<script>
$(function(){
	$('.pagination ul li').live('click',switch_page);
});

function switch_page()
{
	var index = parseInt($(this).children().attr('id').split('_')[1]);
	var ul_obj = $(this).parent();
	if(index == $('.active',ul_obj).children().attr('id').split('_')[1])
	{
		return;
	}
	var total_page_num = parseInt(ul_obj.attr('id'));

	var lang = {'lang_first':$('.first a').html(),'lang_previous':$('.prev a').html(),'lang_next':$('.next a').html(),'lang_last':$('.last a').html()};
	var pagena_num = (total_page_num > 5) ? 5 : total_page_num;
	
	var url = $('#base').val() + 'demand/sort_demand/';
	var post_str = 'index=' + index;
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}

</script>

</html>
