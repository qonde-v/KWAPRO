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
<script>
	function set_status(id,status){
		var url = $('#base').val() + 'order/set_status/';
		var post_str = 'id='+id+'&status=' + status;

		var result = window.confirm("是否进行此操作");
		if (result) {
			var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
				//alert(html);
				window.location.reload();
			}};
			jQuery.ajax(ajax);
		}

	


	}
</script>
</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->


<!------------ 内容开始 ------------->
<input type="hidden" id="base" value="<?php echo $base;?>"/>

  <div class="main">
	<ul class="breadcrumb">
      <li><a href="<?php echo $base;?>">首页</a></li>
      <li>/</li>
      <li><a href="<?php echo $base.'order/';?>">我的订单</a></li>
      <li>/</li>
      <li><a href="#">订单详情</a></li>
    </ul>
    <ul class="steps">
    	<li class="start">
        	<label>提交</label>
            <div class="inline"><?=$order['createtime']?></div>
        </li>
        <li>
        	<label>已确认</label>
            <div class="inline <?php if($order['status']>=1) echo 'show';?>"><?=$order['confirmtime']?></div>
        </li>
        <li>
        	<label>制作中</label>
            <div class="inline <?php if($order['status']>=2) echo 'show';?>">2014-10-21 09:10:12</div>
        </li>
        <li>
        	<label>制作完成</label>
            <div class="inline <?php if($order['status']>=3) echo 'show';?>"><?=$order['completetime']?></div>
        </li>
        <li style="width:196px;">
        	<label>已寄出</label>
            <div class="inline <?php if($order['status']>=4) echo 'show';?>"><?=$order['posttime']?></div>
        </li>
        <li class="end">
        	<label>完成</label>
            <div class="inline <?php if($order['status']==5) echo 'show';?>"><?=$order['committime']?></div>
        </li>
    </ul>
    <div class="order-detail">
    	<div class="left">
       	  <div class="title">订单详情</div>
          <div class="detail">
          	<div class="detail-form">
            	<label style="width:21%;">订单编号：</label>
                <div class="info" style="width:79%;"><?php echo $order['id'];?>
                </div>
            </div>
            <div class="detail-form">
            	<label style="width:25%;">订单收件人：</label>
                <div class="info" style="width:75%;"><?php echo $order['realname'];?>
                </div>
            </div>
            <div class="detail-form">
            	<label style="width:21%;">收货地址：</label>
                <div class="info" style="width:79%;"><?php echo $order['address'];?>，<?php echo $order['tel'];?>
                </div>
            </div>
            <div class="detail-form bottomline">
            	<label style="width:21%;">订单留言：</label>
                <div class="info" style="width:79%;"><?php echo $order['remark'];?>
                </div>
            </div>
            <div class="detail-form">
                <label style="width:14%;">厂家：</label>
                <div class="info" style="width:86%;"><?php echo $order['factory']['name'];?></div>
              </div>
              <div class="detail-form">
                <label style="width:14%;">厂址：</label>
                <div class="info" style="width:86%;"><?php echo $order['factory']['address'];?></div>
              </div>
          </div>
        </div>
        <div class="right">
        	<img class="status-img" src="<?php echo $base.'img/wc_xtb.png';?>" />
            <strong class="status">订单状态：<?php echo $arr_status[$order['status']]->name;?></strong>
            <div class="wuliu">
            	<label>物流信息：</label>
                <div class="wuliu-info">
                <p>圆通速递   单号：200016076840 </p>
                <br />
                <p>寄件单位：广州XXXX公司（工厂）</p>
				<p>发出地点：XX省XX市XX区XX路XXXX号</p>
                </div>
            </div>
            <div>快递状态：<strong>未签收</strong></div>
            <div>订单提交者确认：<?php if($order['status']==5) { echo '<strong>订单已确认</strong>'; }else{?><a class="queren"  href="javascript:set_status(<?=$order['id']?>,5)">确认签收</a><?php }?></div>
        </div>
    </div>
    <div class="products-detail">
    	<label>
        	<span>订单者： <?php echo $order['realname'];?></span>
            <span>订单ID：<?php echo $order['id'];?></span>
            <span>设计：《<?php echo $design['title'];?>》</span>
            <span>设计者：<?php echo $design['username'];?></span>
        </label>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th class="borderleft0" width="25%">设计产品</th>
            <th width="15%">单价</th>
            <th width="15%">件数</th>
            <th width="14%">价格</th>
            <th width="15%">邮寄费用</th>
            <th class="borderright0" width="16%">共计</th>
          </tr>
          <tr>
            <td class="borderleft0"><img width="82px" height="82px" class="pull-left" src="<?php echo $base.$base_photoupload_path.'temp/'.$design['design_pic'];?>" /><span style="line-height: 83px;">《<?php echo $design['title'];?>》的订单</span></td>
            <td class="text-red"><?php echo $order['price'];?>元</td>
            <td><?php echo $order['num'];?></td>
            <td class="text-red"><?php echo $order['totalprice'];?>元</td>
            <td class="text-red"><?php echo $order['postprice'];?>元</td>
            <td class="borderright0 text-red"><?php echo $order['totalprice']+$order['postprice'];?>元</td>
          </tr>
        </table>
		<label>
        	<p>
        		<span>制作厂家：<?php echo $order['factory']['name'];?></span>
            	<span>厂址：<?php echo $order['factory']['address'];?></span>
            </p>
            <p>
        		<span>电话：<?php echo $order['factory']['tel'];?></span>
            	<span>联系人：<?php echo $order['factory']['contacts'];?></span>
            </p>
            <p class="yewu">
            	<span style="width:7%;">主要业务：</span>
        		<span style="width:91%;"><?php echo $order['factory']['business'];?></span>
            </p>
        </label>
    </div>
  </div>





<!------------ 底部开始 ------------->
<?php include("footer.php");?>
</div>
</body>
</html>
