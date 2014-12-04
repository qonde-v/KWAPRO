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
<input type="hidden" id="status" value="<?php echo $status;?>"></input>

  <div id="messager-order" class="main">
		<div class="order-info">
        	<div class="messager pull-left">
            	<img src="<?php echo $base.$user_info['headphoto_path'];?>" width="115px" height="115px"  />
                <label><?php echo $user_info['username'];?></label>
            </div>
            <div class="order-texts pull-left">
            	<div class="title">管理状态&gt;订单状态<a href="#" class="underline pull-right">订单最新消息（<font color="#f00">5</font>）</a></div>
                <ul class="texts">
                	<li><a href="<?php echo $base.'order/orderlist';?>" class="underline"><?=$sumarr['sum0']?></a><label>全部订单</label></li>
                    <li><a href="<?php echo $base.'order/orderlist?status=0';?>" class="underline"><?=$sumarr['sum1']?></a><label>未处理的订单</label></li>
                    <li><a href="<?php echo $base.'order/orderlist?status=1';?>" class="underline"><?=$sumarr['sum3']?></a><label>进行中的订单</label></li>
                    <li class="noborder"><a href="<?php echo $base.'order/orderlist?status=5';?>" class="underline"><?=$sumarr['sum2']?></a><label>完成的订单</label></li>
                </ul>
            </div>
        </div>
      <ul class="nav nav-tabs" role="tablist">
          <li class="tab-item <?php if($status=='all')echo 'active';else echo'';?>"><a href="<?php echo $base.'order/orderlist';?>" >全部</a></li>
          <li class="tab-item <?php if($status=='0')echo 'active';else echo'';?>"><a href="<?php echo $base.'order/orderlist?status=0';?>">未处理的订单</a></li>
          <li class="tab-item <?php if($status=='1')echo 'active';else echo'';?>"><a href="<?php echo $base.'order/orderlist?status=1';?>">进行中的订单</a></li>
          <li class="tab-item <?php if($status=='5')echo 'active';else echo'';?>"><a href="<?php echo $base.'order/orderlist?status=5';?>">完成的订单</a></li>
       </ul>
    
        <div class="tab-content">
          <div class="tab-pane active" id="home">
          	<ul class="header">
            	<li>产品</li>
                <li>订单源设计</li>
                <li>产品单价（元）</li>
                <li>产品件数</li>
                <li>产品价格（元）</li>
                <li>订单邮费（元）</li>
                <li>订单总价（元）</li>
                <li>订单状态</li>
            </ul>
			<span id="content">
			<?php foreach($orders as $item):?>
            <div class="order-items">
            	<ul>
                	<li class="img"><img src="images/gly_dd_p.png" /></li>
                    <li class="text-left"><strong>订单</strong>l/单布料</li>
                    <li>300</li>
                    <li>2</li>
                    <li>600</li>
                    <li>20</li>
                    <li class="text-red">620</li>
                    <li><?php echo $arr_status[$item['status']]->name;?></li>
                </ul>
                <div class="bottom">
                	<span>订单ID：</span>
                    <span>提交时间：</span>
                    <span>设计人：</span>
                    <a href="<?php echo $base.'order/order_detail?id='.$item['id'];?>" class="pull-right">前往详情》》</a>
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
	var pagena_num = (total_page_num > 3) ? 3 : total_page_num;
	
	var url = $('#base').val() + 'order/sort_orderlist/';
	var post_str = 'index=' + index + '&status=' + $('#status').val();
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'base':$('#base').val(),'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}

</script>

</html>
