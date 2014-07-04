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
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 


<div id="main">
<div id="main_nr">
<div id="index_lx">
<br>
<br>

<input type="hidden" id="base" value="<?php echo $base;?>"></input>
<input type="hidden" id="type" value="<?php echo $type;?>"></input>
<div class="index_news">
	<div class="index_liebiao_zw">
	<span id="content">
	<?php foreach($news as $item):?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="20%" height="120" valign="top" align="center"><img src="<?php echo $base.'upload/uploadimages/'.$item['pricefilename'];?>" align="absmiddle" border="0" width="93" height="126" class="img_k"/></td>
			<td width="80%" valign="top" align="left" style="line-height:22px;"><a href="<?php echo $base.'news/news_detail?id='.$item['ID'];?>" class="Red14"><font class="fDOrange14"><?=$item['title']?></font></a><br><br>
			<?=$item['content']?>...<br>
          </tr>
		  <tr>
            <td width="100%" height="50" valign="top" align="right" colspan="2"><?=$item['viewnum']?> 浏览   &nbsp;&nbsp; 分享到： <a href="#"><img src="<?php echo $base.'img/fenx_001.png';?>" align="absmiddle" border="0" /> </a>   <a href="#"><img src="<?php echo $base.'img/fenx_002.png';?>" align="absmiddle" border="0" /> </a>   <a href="#"><img src="<?php echo $base.'img/fenx_003.png';?>" align="absmiddle" border="0" /> </a>   <a href="#"><img src="<?php echo $base.'img/fenx_004.png';?>" align="absmiddle" border="0" /> </a>   <a href="#"><img src="<?php echo $base.'img/fenx_005.png';?>" align="absmiddle" border="0" /> </a></td>
			
			
          </tr>
	</table>
	<?php endforeach;?>
	</span>

		<?php if($inbox_page_num > 1):?>	
		  <div class="pagination">
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
        


	</div>
	
	
</div>





</div>

<div id="index_rx">
<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 发布需求，定制你的专属 </div>

<div class="text_k_black text_sousuo" style="margin-top:10px;">
<table width="97%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="15%" height="30" align="center" valign="middle">搜索：</td>
			  <td width="85%" align="left" valign="middle"><INPUT id="" type=text value="" class="u_text"></td>
            </tr>
			
</table>
</div>


<div class="black_bt22" style="text-align:center; margin-top:10px; margin-bottom:15px;"> 最新动态 </div>


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
	
	var url = $('#base').val() + 'news/sort_news/' ;
	var post_str = 'index=' + index + '&type=' + $('#type').val();
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}

</script>
</html>
