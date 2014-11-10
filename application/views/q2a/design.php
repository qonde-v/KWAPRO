<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">

<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>

</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 

<input type="hidden" id="base" value="<?php echo $base;?>"></input>

  <div id="personalSpace" class="main">
  	<?php include("subjectpic.php"); ?>
    <div class="lists">
    	<div class="left">
        	<img style="margin-top:5px;" src="<?php echo $base.'img/grkj_p_gg.jpg';?>" />
            <ul class="left-menu">
            	<a href="<?php echo $base.'information/';?>"><li class="dongtai">最新动态</li></a>
                <a href="<?php echo $base.'design/';?>"><li class="sheji active">设　计</li></a>
                <a href="<?php echo $base.'demand/';?>"><li class="xuqiu">需　求</li></a>
                <a href="<?php echo $base.'order/';?>"><li class="dingdan">订　单</li></a>
            </ul>
        </div>
        <div class="right">
        	<div class="panel">
        		<div class="panel-heading">我参与的设计</div>
                  <div class="panel-body">
				    <span id="content">
                    <ul class="main-list">
						<?php $i=0; foreach($designs as $item): $i++?>
                    	<li>
                        	<a href="<?php echo $base.'design/design_detail?id='.$item['id'];?>" class="title"><?php echo $i.'、'.$item['title']?></a>
                            <div class="btns">
							<?php if($item['status']==0){?><a href="#" onclick="javascript:subsim(<?php echo $item['id'].','.$item['demand_id'];?>);">提交仿真</a><?php }?>
							<?php if($item['status']==1){?><a href="#" class="black">等待仿真</a><?php }?>
							<?php if($item['status']==2){?><a href="<?php echo $base.'design/similar_detail';?>">查看仿真</a><?php }?>
							<a href="<?php echo $base.'design/order?id='.$item['id'];?>">提交订单</a>
							</div>
                            <p><span class="link link-liulan">浏览（<a href="#"><?php echo $item['viewnum']?></a>）</span><span class="link link-liuyan">留言（<a href="#"><?php echo $item['messnum']?></a>）</span><span class="pull-right">发布于<?php echo $item['createdate']?></span></p>
                        </li>
						<?php endforeach; ?>
                    </ul>
					</span>
            	</div>

					  <div class="dt_fy">
					  <?php if($inbox_page_num > 1):?>	
					  <div class="pagination" style="padding-right:10px;">
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
<?php include("footer.php");?>
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
	
	var url = $('#base').val() + 'design/sort_design/';
	var post_str = 'index=' + index;
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'base':$('#base').val(),'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}

function subsim(design_id,demand_id)
{
	var url = $('#base').val() + 'design/subsim/';
	var post_str = 'design_id='+design_id+'&demand_id=' + demand_id;
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		subsim_n(html);
		//window.location.reload();
	}};
	jQuery.ajax(ajax);
}

function subsim_n(fname)
{
	var url = 'http://localhost/cgi-bin/GSim.cgi';
	var post_str = 'Simplans='+fname+'&name=Henry';

	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		alert('提交成功');
	}};
	jQuery.ajax(ajax);
}

</script>
</html>
