<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TIT系统</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<script type="text/javascript" src="<?php echo $base.'js/jquery.qqFace.js';?>"></script>
<script>
function smile(obj,tt){
	var area = 'msg_content_area';
	if(tt>0) area = area + '_' + tt;

	$(obj).qqFace({
		id : 'facebox', 
		assign: area, 
		path:$('#base').val() +'img/arclist/'	//表情存放的路径
	});
}
//查看结果
function replace_em(str){
	str = str.replace(/\</g,'&lt;');
	str = str.replace(/\>/g,'&gt;');
	str = str.replace(/\n/g,'<br/>');
	str = str.replace(/\[em_([0-9]*)\]/g,'<img src="'+$('#base').val()+'img/arclist/$1.gif" border="0" />');
	return str;
}

</script>
<script type="text/javascript">
	$("#effectpic").live("click", function(){
		$("#designpic").removeClass("black");
		$("#effectpic").addClass("black");
		$("#effect_pic").removeClass("hide");
		$("#design_pic").addClass("hide");
	});
	$("#designpic").live("click", function(){
		$("#effectpic").removeClass("black");
		$("#designpic").addClass("black");
		$("#design_pic").removeClass("hide");
		$("#effect_pic").addClass("hide");
	});

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

	
	function control(tt){
		var html = document.getElementById('control_'+tt).innerHTML;
		html = html.substr(0,2);
		if(html=="展开"){
			document.getElementById('control_'+tt).innerHTML="收    起<br>▼";
			document.getElementById('reply_'+tt).style.display="block";
		}else{
			document.getElementById('control_'+tt).innerHTML="展开详情<br>▼";
			document.getElementById('reply_'+tt).style.display="none";
		}
	}


	function send_sec_msg(tt)
	{
		var uId = $('#new_msg_uid_'+tt).val();
		//var username = $('#msg_username_area').val();
		var title = encodeURIComponent($('#msg_title_area_'+tt).val());
		var content = encodeURIComponent($('#msg_content_area_'+tt).val());
		var type = $('#type').val();
		var related_id = $('#related_id').val();
		var p_md_Id = $('#p_md_Id_'+tt).val();
		if(msg_data_check(uId,title,content))//	if(msg_data_check(username,title,content))
		{
			var url = $('#base').val() + 'messages_request/send_message/';
			var post_str = 'uId='+uId+'&title='+title+'&content='+content+'&type='+type+'&related_id='+related_id+'&p_md_Id='+p_md_Id;
			var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
				$('#msg_modal .modal-body').html(html);
				$('#msg_modal').removeClass("hide");
				$('#msg_modal').show();
				//setTimeout("$('#msg_modal').css('display','none')",2000);
			}};
			jQuery.ajax(ajax);
			setTimeout("window.location.reload();$('#msg_content_area_"+tt+"').val('');",1000);
		}
	}

	function update_num(type){
		var num = $('#num').html();
		if(type=='1'){
			if(num>1)$('#num').html(num-1);
		}
		else $('#num').html(parseInt(num)+1);

	}


</script>
<script type="text/javascript">
$(function(){
	$(".selecter").click(function(){//alert($(this).attr('class').split(" ")[1]);
		$(this).toggleClass("active");
	});
	$("li").live("click", function(){
		if($(this).parent().attr('id')=='province'){
			$(this).parents(".selecter").find("span").html($(this).html());
			$(this).parents(".selecter").find("input").val($(this).attr('id'));
			show_city();
		}else if($(this).parent().attr('id')=='city'){
			$(this).parents(".selecter").find("span").html($(this).html());
			$(this).parents(".selecter").find("input").val($(this).attr('id'));
			show_town();
		}else if($(this).parent().attr('id')=='town'){
			$(this).parents(".selecter").find("span").html($(this).html());
			$(this).parents(".selecter").find("input").val($(this).attr('id'));
		}
	});
	$("#i_province").click(function(){
		show_province();
	});
});
function showModal(){
	$('.modal').show();
	$('#login_modal').attr('style','display:none');
	$(".modal-bg").css("height",$("body").height());
	$(".modal-bg").show();
}
function hideModal(){
	$('.modal').hide();
	$(".modal-bg").hide();
}
function submit_order()
{
	var data = new Array();
	var hint = "";
	var price = $('#price').val();
	var num = $('#num').html();
	var postprice = $('#postprice').val();
	var town = $('#town').parent().find('span').html();
	data['realname'] = $('#realname').val();
	data['address'] = town + $('#address').val();
 	data['tel'] = $('#tel').val();
	data['remark'] = $('#remark').val();
	data['num'] = num;
	data['price'] = price;
	data['postprice'] = postprice;
	data['totalprice'] = price * num;
	data['design_id'] = $('#design_id').val();

	if(town=='') hint=hint+'请选择地区<br/>';
	if(data['realname']=='') hint=hint+'请输入收件人<br/>';
	if(data['address']=='') hint=hint+'请输入详细地址<br/>';
	if(data['tel']=='') hint=hint+'请输入电话<br/>';
	if(data['zipcode']=='') hint=hint+'请输入邮编<br/>';

	if(hint!=''){
		$('.modal-body').html(hint);
		$('#msg_modal').removeClass("hide");
		$('#msg_modal').show();
		return;
	}


	var post_str = generate_query_str(data);
	var url = $('#base').val() + 'design/submit_order/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('.modal-body').html(html);
		$('#msg_modal').css('display','block');
	}};
	jQuery.ajax(ajax);
	setTimeout("window.location.href=$('#base').val() + 'order/'",200);

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
<script type="text/javascript">
var _move=false;//移动标记
var _x,_y;//鼠标离控件左上角的相对位置
$(document).ready(function() {
		$("#draggable").click(function(){
        //alert("click");//点击（松开后触发）
        }).mousedown(function(e){
        _move=true;
        _x=e.pageX-parseInt($("#draggable").css("left"));
        _y=e.pageY-parseInt($("#draggable").css("top"));
        //$("#draggable").fadeTo(20, 0.25);//点击后开始拖动并透明显示
    });
    $(document).mousemove(function(e){
        if(_move){
            var x=e.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置
            var y=e.pageY-_y;
            $("#draggable").css({top:y,left:x});//控件新位置
        }
    }).mouseup(function(){
    _move=false;
    //$("#draggable").fadeTo("fast", 1);//松开鼠标后停止移动并恢复成不透明
  });
});
</script>
</head>


<!------------提交订单开始-------------->
<div class="modal design" role="modal" id="draggable">
    <div class="design-main">
    	<div class="design-title">
        	订单详情 > 提交订单
            <span class="pull-right">订单提交者：<?php if(isset($user_info['username']))echo $user_info['username']; ?></span>
        </div>
        <table width="100%" class="design-table">
          <tr>
            <td class="table-title" colspan="2" bgcolor="#454545">订单ID:123456789001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;订单原设计：《<?php echo $design['title']; ?>》<span class="pull-right">提交时间：<?php echo $design['createdate']; ?></span></td>
          </tr>
          <tr>
            <td>
            	<img  class="pull-left" src="<?php echo $base.$base_photoupload_path.'temp/'.$design['design_pic'];?>" width="85" height="90" style="margin:8px;" />
                <div class="pull-left" style="padding:15px 5px;">
                	<label style="font-size:18px; display:block;">《<?php echo $design['title']; ?>》的订单</label>
                    <span style="font-size:16px; color:#707070;">设计人：<?php echo $design['username']; ?></span>
                    <div class="num-box">
                    	<a class="btn minute" href="javascript:;" onclick="update_num(1)">-</a>
                        <label id="num">1</label>
                        <a class="btn plus" href="javascript:;" onclick="update_num(2)">+</a>
                    </div>
                </div>
            </td>
            <td>
            	<div style="padding:35px;">
                	<p>单价：369元</p>
                    <p>合计：<font class="text-red">369元</font>（不含邮寄费用）</p>
                </div>
            </td>
          </tr>
        </table>
		<div class="design-title">
        	订单详情 > 填写收件地址
        </div>
        <table class="add-table" width="100%">
          <tr>
            <td>收件地址：</td>
            <td>
            	<div class="selecter province"> <span></span><i id="i_province"></i>
					<input type="hidden" id="t_province">
                    <ul id="province" style="height:310px;overflow:auto;z-index:100;">
                    </ul>
                  </div>
                  省
                  <div class="selecter city"> <span></span><i id="i_city"></i>
				    <input type="hidden" id="t_city">
                    <ul id="city"  style="height:310px;overflow:auto;">
                    </ul>
                  </div>
                  &nbsp;&nbsp;市&nbsp;&nbsp;
                  <div class="selecter town"> <span></span><i id="i_town"></i>
				    <input type="hidden" id="t_town">
                    <ul id="town" style="height:300px;overflow:auto;">
                    </ul>
                  </div>&nbsp;区/县
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
            	<input type="text" style="width:80%;" id="address"/>&nbsp;&nbsp;详细地址
            </td>
          </tr>
          <tr>
            <td>收件人：</td>
            <td>
            	<input type="text" id="realname"/>&nbsp;&nbsp;联系电话：&nbsp;&nbsp;<input type="text" id="tel"/>&nbsp;&nbsp;邮编：&nbsp;&nbsp;<input type="text" id="zipcode" />
            </td>
          </tr>
          <tr>
            <td>订单留言：</td>
            <td><input type="text" style="width:80%;" id="remark"/></td>
          </tr>
        </table>
		<div class="design-footer">
        	<div class="pull-right">
			    <input type="hidden" id="postprice" value="20">
            	<span style="margin-left:30px;">邮费：<span class="text-red" style="margin-right:30px;">20元</span>共计：<span class="text-red">389元</span>
                <div class="btns">
                	<a href="javascript:;" onclick="hideModal()">取消</a>
                    <a class="black" href="javascript:;" onclick="submit_order()">提交订单</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modalBg" role="modal"></div>
<!------------提交订单结束-------------->
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->





<!------------ 内容开始 -------------> 
<input type="hidden" id="base" value="<?php echo $base;?>"></input>
<input type="hidden" id="design_id" value="<?php echo $design['id'];?>"></input>
<input type="hidden" id="price" value="<?php echo $design['price'];?>"></input>
<input type="hidden" id="type" value="2"/>
<input type="hidden" id="related_id" value="<?php echo $design['id'];?>"/>
<input type="hidden" id="username_empty" value="用户名不能为空"/>
<input type="hidden" id="content_empty" value="内容不能为空"/>

  <div class="main"> 
	<a href="<?php echo $base.'demand/publish';?>"><img src="<?php echo $base.'img/sub_top_p.png';?>" /></a>
    <ul class="breadcrumb">
      <li><a href="<?php echo $base;?>">首页</a></li>
      <li>/</li>
      <li><a href="#">设计详情</a></li>
      <li class="fl-right">浏览（<?php echo $design['viewnum'];?>）</li>
      <li class="fl-right">订单（<?php echo $design['ordernum'];?>）</li>
    </ul>
    <div class="content">
      <div class="panel panel-default">
        <div class="panel-heading2">
        	<div class="panel-header">
                <label class="title"><strong>设计需求：</strong><?php echo $demand['title'];?></label>
                <p>发布人：<strong><?php echo $demand['username'];?></strong>时间：<strong><?php echo $demand['createdate'];?></strong></p>
                <a class="black ab-right" href="<?php echo $base.'demand/demand_detail?id='.$design['demand_id'];?>">点击查看详情</a>
            </div>
        </div>
        <div class="panel-body" style="overflow:auto; padding-top:0; padding-bottom:10px; margin-bottom:2px;">
          <div class="panel-item"> <img src="<?php if($demand['type']=='跑步')echo $base.'img/s_paobu.png';
													if($demand['type']=='步行')echo $base.'img/s_buxing.png';
													if($demand['type']=='钓鱼')echo $base.'img/s_diaoyu.png';
													if($demand['type']=='高尔夫')echo $base.'img/s_gaoerfu.png';
													if($demand['type']=='滑轮')echo $base.'img/s_hualun.png';
													if($demand['type']=='滑雪')echo $base.'img/s_huaxue.png';
													if($demand['type']=='健身运动')echo $base.'img/s_jianshen.png';
													if($demand['type']=='篮球')echo $base.'img/s_lanqiu.png';
													if($demand['type']=='马术')echo $base.'img/s_mashu.png';
													if($demand['type']=='目标运动')echo $base.'img/s_mubiao.png';
													if($demand['type']=='排球')echo $base.'img/s_paiqiu.png';
													if($demand['type']=='乒乓球')echo $base.'img/s_pingpang.png';
													if($demand['type']=='户外山地运动')echo $base.'img/s_shandi.png';
													if($demand['type']=='狩猎运动')echo $base.'img/s_shoulie.png';
													if($demand['type']=='水上运动')echo $base.'img/s_shuishang.png';
													if($demand['type']=='网球')echo $base.'img/s_wangqiu.png';
													if($demand['type']=='游泳')echo $base.'img/s_youyong.png';
													if($demand['type']=='自行车运动')echo $base.'img/s_zixingche.png';
													if($demand['type']=='足球')echo $base.'img/s_zuqiu.png';
													if($demand['type']=='羽毛球')echo $base.'img/s_yumaoqiu.png';
													?>" />
            <div class="pull-right">
			  <p>类型：<span><?php echo $demand['type'];?>°C</span></p>
              <p>强度：<span><?php echo $demand['strength'];?></span></p>
              <p>时间：<span><?php echo $demand['sporttime'];?>小时</span></p>
            </div>
          </div>
          <div class="panel-item">  <img src="<?php if($demand['weather']=='晴天')echo $base.'img/w_qing.png';
													if($demand['weather']=='小雪')echo $base.'img/w_xiaoxue.png';
													if($demand['weather']=='小雨')echo $base.'img/w_xiaoyu.png';
													if($demand['weather']=='下雪')echo $base.'img/w_xiaxue.png';
													if($demand['weather']=='下雨')echo $base.'img/w_xiayu.png';
													if($demand['weather']=='阴天')echo $base.'img/w_yintian.png';
													if($demand['weather']=='雨雪')echo $base.'img/w_yuxue.png';
													?>" />
			<div class="pull-right">
			  <p>天气：<span><?php echo $demand['weather'];?>°C</span></p>
			  <p>温度：<span><?php echo $demand['temperature'];?>°C</span></p>
			  <p>湿度：<span><?php echo $demand['humidity'];?></span></p>
			</div>
          </div>
          <div class="panel-item"> <img src="<?php if($demand['target']=='男')echo $base.'img/sex1.png';
													if($demand['target']=='女')echo $base.'img/sex2.png';
													?>" />
            <div class="pull-right">
			  <p>对象：<span><?php echo $demand['target'];?>°C</span></p>
              <p>熟练度：<span><?php echo $demand['proficiency'];?></span></p>
              <p>年龄：<span><?php echo $demand['age'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;体重：<span><?php echo $demand['weight'];?>KG</span></p>
            </div>
          </div>
        </div>
        <div class="panel-body" style="padding:0 30px 50px;">
            <ul class="breadcrumb breadcrumb-gray">
              <li id="effectpic" class="black" style="cursor:pointer">产品效果图</li>
              <li>/</li>
              <li id="designpic" class="" style="cursor:pointer">产品设计图</li>
            </ul>
			
			<div class="thumb">
				<div class="left">
                	<img id="effect_pic" class="" width="498px" height="498px" src="<?php echo $base.$base_photoupload_path.'temp/'.$design['effect_pic'];?>" />
					<img id="design_pic" class="hide" width="498px" height="498px" src="<?php echo $base.$base_photoupload_path.'temp/'.$design['design_pic'];?>" />
                </div>
                <div class="right">
                	<div class="thumb-text">
                    	<p class="title">《<?php echo $design['title'];?>》</p>
                        <p>发布人：<?php echo $design['username'];?></p>
                        <p>时间：<?php echo $design['createdate'];?></p>
                        <p>产品单价：test</p>
                        <p class="ms">设计描述</p>
                        <p class="content"><?php echo $design['description'];?></p>
                        <p class="buy">购买产品</p>
                        <a href="javascript:;" onclick="<?php if(isset($login))echo 'showModal()';else echo 'showLoginModal()';?> " class="white">提交订单</a>
                    </div>
                </div>
			</div>
            <div class="ysmlxz">样式的面料选择：
			<a class="btn <?php if($design['status']==0) echo 'active';else echo '';?>" href="#" onclick="javascript:subsim(<?php echo $design['id'].','.$design['demand_id'];?>);">提交仿真</a>
			<a class="btn <?php if($design['status']==1) echo 'active';else echo '';?>">等待仿真</a>
			<a class="btn <?php if($design['status']==2) echo 'active';else echo '';?>" href="<?php echo $base.'design/similar_detail';?>">查看仿真</a></div>
            <div class="ysmlxz-content">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <?php if($design['fabric']!=0){?>
                  <tr>
                    <td width="13%" align="center">
                    	<img width="96" height="96" src="<?php echo $base.$base_photoupload_path.'temp/'.$design['effect_pic'];?>" />
                        <label>整套服装</label>
                    </td>
                    <td width="26%" align="center">
                    	<img width="136" height="86" class="ml" src="<?php echo $base.'img/'.$fabric['pic'];?>" />
                        <label><?php echo $fabric['name'];?></label>
                    </td>
                    <td width="61%" valign="top">
                   	  <label style="line-height:40px; margin-top:10px;">面料特点：</label>
                        <?php echo $fabric['feature'];?>
                    </td>
                  </tr>
				  <?php }else{?>
				  <?php if(!empty($design_pic)){foreach($design_pic as $item): ?>
				  <tr>
                    <td width="13%" align="center">
                    	<img width="96" height="96" src="<?php echo $item['pic_url'];?>" />
                        <label><?php echo $item['name'];?></label>
                    </td>
                    <td width="26%" align="center">
                    	<img width="136" height="86" class="ml" src="<?php echo $base.'img/'.$item['fabric']['pic'];?>" />
                        <label><?php echo $item['fabric']['name'];?></label>
                    </td>
                    <td width="61%" valign="top">
                   	  <label style="line-height:40px; margin-top:10px;">面料特点：</label>
                        <?php echo $item['fabric']['feature'];?>
                    </td>
                  </tr>
				  <?php endforeach; }?>
				  <?php }?>
                </table>

            </div>
        </div>
      </div>
      <div class="panel panel-default" style="margin-top:2px;">
        <div class="panel-body mini-body">
		  <input type="hidden" id="new_msg_uid" value="<?php echo $demand['uId'];?>"/>
		  <input type="hidden" id="msg_title_area" value=""></input>
          <textarea class="message-input" id="msg_content_area"></textarea>
          <div class="message-btns"> <a  href="javascript:void(0);" href="#" onclick="javascript:smile(this,0);"><img src="<?php echo $base.'img/xtp_xl.png';?>" /></a> <a href="#"><img src="<?php echo $base.'img/xtp_tp.png';?>" /></a> <span style="margin:0 5px;">已有留言（<font class="text-orange"><?php echo $design['messnum'];?></font>）</span> 
		  <?php if(isset($login)){?><a class="btn" href="javascript:void(0);" id="msg_send_btn" data-loading-text="请稍后">留　言</a>
		  <?php }else{?>
		  <a class="btn" href="javascript:void(0);" onclick="javascript:showLoginModal();" data-loading-text="请稍后">留　言</a>
		  <?php }?>
		  </div>
        </div>
        <div class="list-group">
          <?php $i=0; foreach($message_data as $item): $i++;?>
          <div class="list-group-item">
            <div class="item-body"> <img class="pull-left" src="<?php echo $base.'img/geren_tp.png';?>" /> <span class="username"><?=$item['username']?>:</span><script> document.write(replace_em('<?=$item['content']?>'));</script>
              <p class="time"><?=$item['time']?>&nbsp;<span class="message">（<?php if(!empty($item['sec_data']))echo count($item['sec_data']);else echo 0;?>）</span></p>
			  <a class="detail" href="javascript:void(0)" onclick="javasrcipt:control(<?=$i?>);" id="control_<?=$i?>">展开详情<br>▼</a>
              <div class="reply" id="reply_<?=$i?>" style="display:none;">
              	<div class="reply-list">
					<?php if(!empty($item['sec_data'])){foreach($item['sec_data'] as $secval){?>
                	<div class="reply-item">
                    	<img class="reply-img" src="<?php echo $base.'img/geren_tx.png';?>" />
                        <span class="reply-name"><?=$secval['username']?>：</span><script> document.write(replace_em('<?=$secval['content']?>'));</script>
                    </div>
					<?php }} ?>
                </div>
				<input type="hidden" id="new_msg_uid_<?=$i?>" value="<?php echo $item['from_uId'];?>"/>
				<input type="hidden" id="msg_title_area_<?=$i?>" value=""></input>
				<input type="hidden" id="p_md_Id_<?=$i?>" value="<?php echo $item['md_Id'];?>"></input>
              	<textarea class="message-input"  id="msg_content_area_<?=$i?>"></textarea>
          		<div class="message-btns"> <a href="javascript:void(0)"  onclick="javascript:smile(this,<?=$i?>);"><img src="<?php echo $base.'img/xtp_xl.png';?>" /></a> <a href="#"><img src="<?php echo $base.'img/xtp_tp.png';?>" /></a> <a class="btn" href="javascript:void(0)" onclick="send_sec_msg(<?=$i?>)">回　复</a> </div>
              </div>
			</div>
          </div>
		  <?php  endforeach;?>

        </div>
      </div>
    </div>
  </div>




<div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" onclick="$('#msg_modal').addClass('hide');" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').addClass('hide');">确定</button></div>
</div>

<!------------ 底部开始 ------------->
<?php include("footer.php");?>
<script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
<script src="<?php echo $base.'js/message_other.js';?>"></script>
<script>
function show_province()
{
	$('#province').empty();
	$('#city').empty();
	$('#town').empty();
	$('#city').parent().find('span').html('');
	$('#town').parent().find('span').html('');
	var code = 'zh';
	var type = 'province';
	var attr = 'country';
	var post_str = 'code='+code+'&type='+type+'&attr='+attr;
	var effect_id = $('#province');
	ajax_location_data(post_str,effect_id);
}

function show_city()
{
	$('#city').empty();
	$('#town').empty();
	$('#town').parent().find('span').html('');
	var code = $('#t_province').val();
	var type = 'city';
	var attr = 'province';
	var post_str = 'code='+code+'&type='+type+'&attr='+attr;
	var effect_id = $('#city');
	ajax_location_data(post_str,effect_id);
}

function show_town()
{
	$('#town').empty();
	var code = $('#t_city').val();
	var type = 'town';
	var attr = 'city';
	var post_str = 'code='+code+'&type='+type+'&attr='+attr;
	var effect_id = $('#town');
	ajax_location_data(post_str,effect_id);
}

function ajax_location_data(post_str,effect_id)
{
	var url = $('#base').val() + 'settings_request/get_location_data/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		if(html.trim() != '')
		{
			var arr = html.split('@');
			for(var key in arr)
			{
				var location_data = arr[key].split('#');
				var option_html = "<li id='"+location_data[0]+"'>"+location_data[1]+"</li>";
				effect_id.prepend(option_html);
			}
		}
	}};
	jQuery.ajax(ajax);
}
</script>
</div>
</body>
</html>
