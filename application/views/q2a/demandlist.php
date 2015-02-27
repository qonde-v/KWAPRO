<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIT系统</title>
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<!-- <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
 --><link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 
<input type="hidden" id="base" value="<?php echo $base;?>"></input>

<div class="main">
	<a href="<?php if(isset($login)) echo $base.'demand/publish';else echo 'javascript:showLoginModal()';?>"><img src="<?php echo $base.'img/sub_top_p.png';?>" /></a>
	<div class="navbar">
    	<ul class="navbar-nav pull-left">
        	<li class="drop">
            	<a href="#" class="dropdown-toggle">按发布时间排列</a>
                <ul class="nav-menu">
                    <li><a class="icon icon-down" href="<?php echo $base.'demand/demandlist?type=1';?>">由旧到新发布的排列<span></span></a></li>
                    <li><a class="icon icon-up" href="<?php echo $base.'demand/demandlist?type=2';?>">由新到旧发布的排列<span></span></a></li>
                    <li><a class="icon icon-left" href="<?php echo $base.'demand/demandlist?type=3';?>">最新一个月内的排列<span></span></a></li>
                    <li><a class="icon icon-right" href="<?php echo $base.'demand/demandlist?type=4';?>">一个月前发布的排列<span></span></a></li>
                  </ul>
            </li>
            <li class="drop">
            	<a href="<?php echo $base.'demand/demandlist?type=5';?>" class="dropdown-toggle">按设计量排列</a>
            </li>
        </ul>
        <a class="pull-right" style="margin-right:10px; margin-top:10px;" href="#" alt="全部"><img src="<?php echo $base.'img/xtb_006.png';?>" /></a>
    </div>

	<div class="content">
		<span id="content">
    	<ul id="xuqiu-list">
		    <?php foreach($demands as $item):?>
        	<li>
            	<a class="title" href="<?php echo $base.'demand/demand_detail?id='.$item['id'];?>"><?=$item['title']?></a>
                <ul class="views">
                    <li class="view">浏览（<?=$item['viewnum']?>）</li>
                    <li class="design">设计（<a href="<?php echo $base.'demand/demand_detail?id='.$item['id'];?>"><?=$item['designnum']?></a>）</li>
                  </ul>
                  <p></p>
                  <span class="bottom"><font class="icon-tag">发布人：<?=$item['username']?></font> <font class="icon-clock">发布于<?=$item['createdate']?></font><font class="pull-right"><?php $days=round((time()-strtotime($item['createdate']))/3600/24); if($days<15)echo (15-$days).'天后截止';else echo '已截止';?></font></span>
            </li>
			<?php endforeach;?>
        </ul>
		</span>
        <div class="xuqiu-list-bottom">
        	<div class="search-box">
          		<input type="text" value="搜索关键字" />
            	<a class="search-btn" href="javascript:void(0);" onclick="alert('search');"></a>
          	</div>
            <div class="dt_fy">
			  <?php if($inbox_page_num > 1):?>	
			  <div class="pagination">
					<ul id="<?php echo $inbox_page_num;?>">
						<li class="unactive disabled"><a href="#" id="pagination_0"><img src="<?php echo $base.'img/dot_dj.png';?>" align="absmiddle" border="0"/></a></li>
						<li class="active"><a href="#" id="pagination_1">1</a></li>
						<?php if($inbox_page_num > 5):?>
						<?php for($i=2;$i<=5;$i++):?>
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

	
</div>

        
















<!------------ 底部开始 ------------->
<?php include("footer.php"); ?>
</div>
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
	
	var url = $('#base').val() + 'demand/sort_demandlist/';
	var post_str = 'index=' + index;
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'base':$('#base').val(),'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}

</script>

</html>
