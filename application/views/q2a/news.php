<!DOCTYPE html>

<html>
<head>
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" /> -->
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>


</head>
<div class="container">

<?php include("header.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 
<input type="hidden" id="base" value="<?php echo $base;?>"></input>
<input type="hidden" id="type" value="<?php echo $type;?>"></input>
<div class="main">
	<img src="<?php if(substr($type,0,1)==1) echo $base.'img/dt_top.png';else echo $base.'img/zs_top.png';?>" />
	<ul class="nav1 nav-tabs" role="tablist">
	  <?php if(substr($type,0,1)==1){?>
	  <li class="tab-item <?php if($type==11)echo 'active'; else echo '';?>"><a href="<?php echo $base.'news?type=11';?>" >行业动态</a></li>
	  <li class="tab-item <?php if($type==12)echo 'active'; else echo '';?>"><a href="<?php echo $base.'news?type=12';?>">潮流资讯</a></li>
	  <li class="tab-item <?php if($type==13)echo 'active'; else echo '';?>"><a href="<?php echo $base.'news?type=13';?>">明星动态</a></li>
	  <?php }else{?>
	  <li class="tab-item <?php if($type==21)echo 'active'; else echo '';?>"><a href="<?php echo $base.'news?type=21';?>" >运动与服装</a></li>
	  <li class="tab-item <?php if($type==22)echo 'active'; else echo '';?>"><a href="<?php echo $base.'news?type=22';?>">纤维与面料</a></li>
	  <li class="tab-item <?php if($type==23)echo 'active'; else echo '';?>"><a href="<?php echo $base.'news?type=23';?>">服装设计与打理</a></li>
	  <?php }?>
	  <li class="search-box">
		<input type="text" value="搜索你感兴趣的" />
		<a class="search-btn" href="javascript:void(0);" onclick="alert('search');"></a>
	  </li>
    </ul>


	<div class="tab-content">
	  <div class="tab-pane active" id="home">
		<span id="content">
		<?php foreach($news as $item):?>
		<div class="media">
		  <a class="media-pic" href="#">
			<img src="<?php echo $base.'upload/uploadimages/'.$item['pricefilename'];?>" alt="..." width="250" height="185">
		  </a>
		  <div class="media-body">
			<a href="<?php echo $base.'news/news_detail?id='.$item['ID'];?>" class="media-heading"><?=$item['title']?></a>
			<span><?=utf8Substr($item['content'],0,100)?>...........</span>
			<div class="media-footer">阅览（<?=$item['viewnum']?>）</div>
		  </div>
		</div>
		<?php endforeach;?>
		</span>
			
	    <div class="dt_fy">
		  <?php if($inbox_page_num > 1):?>	
		  <div class="pagination">
				<ul id="<?php echo $inbox_page_num;?>">
					<li class="unactive disabled"><a href="#" id="pagination_0"><img src="<?php echo $base.'img/dot_dj.png';?>" align="absmiddle" border="0"/></a></li>
					<li class="active"><a href="#" id="pagination_1">1</a></li>
					<?php if($inbox_page_num > 10):?>
					<?php for($i=2;$i<=10;$i++):?>
						<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
					<?php endfor;?>
					<?php else:?> 
					<?php for($i=2;$i<=$inbox_page_num;$i++):?>
						<li class="unactive"><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
					<?php endfor;?>
					<?php endif;?>
					<li class="unactive"><a href="#" id="pagination_2"><img src="<?php echo $base.'img/dot_dz.png';?>" align="absmiddle" border="0"/></a></li>
				</ul>
		  </div>
		  <?php endif;?>
		</div>

	  </div>
	</div>

	
	<?php   
   //截取utf8字符串   
   function utf8Substr($str, $from, $len)   
   {   
      return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.   
                         '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',   
                         '$1',$str);   
   }   
   ?>

	
</div>

        


<!------------ 底部开始 ------------->
<?php include("footer.php");?>

</div>
</body>
<script>
$(function(){
	$('.dt_fy ul li').live('click',switch_page);
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
		pagenation_controller_update(ul_obj,{'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang,'base':$('#base').val()});
	}};
	jQuery.ajax(ajax);
}

</script>
</html>
