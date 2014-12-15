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
function chgpanel(tt){
	if(tt=='m'){
		document.getElementById('messpanel1').style.display="block";
		document.getElementById('messpanel2').style.display="block";
		document.getElementById('designpanel').style.display="none";
		document.getElementById('am').style.color="#333";
		document.getElementById('ad').style.color="#aeaeae";
	}
	if(tt=='d'){
		document.getElementById('messpanel1').style.display="none";
		document.getElementById('messpanel2').style.display="none";
		document.getElementById('designpanel').style.display="block";
		document.getElementById('ad').style.color="#333";
		document.getElementById('am').style.color="#aeaeae";
	}
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

</script>
</head>
<div class="container">

<?php include("header.php"); ?>
<!------------ 头部结束 ------------->





<!------------ 内容开始 -------------> 
<input type="hidden" id="base" value="<?php echo $base;?>"></input>

  <div class="main"> 
	<a href="<?php echo $base.'demand/publish';?>"><img src="<?php echo $base.'img/sub_top_p.png';?>" /></a>
    <ul class="breadcrumb">
      <li><a href="<?php echo $base;?>">首页</a></li>
      <li>/</li>
      <li><a href="<?php echo $base.'demand/demandlist';?>">需求广场</a></li>
      <li>/</li>
      <li><a href="#">需求详情</a></li>
    </ul>
	<input type="hidden" id="type" value="1"/>
	<input type="hidden" id="related_id" value="<?php echo $demand['id'];?>"/>
	<input type="hidden" id="username_empty" value="用户名不能为空"/>
	<input type="hidden" id="content_empty" value="内容不能为空"/>

    <div class="content"> <a class="title"><?php echo $demand['title'];?></a>
      <ul class="views">
        <li class="view">浏览（<?php echo $demand['viewnum'];?>）</li>
        <li class="design">设计（<?php echo $demand['designnum'];?>）</li>
      </ul>
      <div class="panel panel-default">
        <div class="panel-heading">时间：<font><?php echo $demand['createdate'];?></font>&nbsp;&nbsp;&nbsp;&nbsp;发布人<font class="text-orange"><?php echo $demand['username'];?></font> <span class="pull-right clock"><font class="text-orange"><?php $days=round((time()-strtotime($demand['createdate']))/3600/24); if($days<15)echo (15-$days).'天后';else echo '已';?></font>&nbsp;&nbsp;截止</span> </div>
        <div class="panel-body" style="*overflow:visible;">
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
			  <p>类型：<span><?php echo $demand['type'];?></span></p>
              <p>强度：<span><?php echo $demand['strength'];?></span></p>
              <p>时间：<span><?php echo $demand['sporttime'];?>分钟</span></p>
            </div>
          </div>
          <div class="panel-item"> <img src="<?php if($demand['weather']=='晴天')echo $base.'img/w_qing.png';
													if($demand['weather']=='小雪')echo $base.'img/w_xiaoxue.png';
													if($demand['weather']=='小雨')echo $base.'img/w_xiaoyu.png';
													if($demand['weather']=='下雪')echo $base.'img/w_xiaxue.png';
													if($demand['weather']=='下雨')echo $base.'img/w_xiayu.png';
													if($demand['weather']=='阴天')echo $base.'img/w_yintian.png';
													if($demand['weather']=='雨雪')echo $base.'img/w_yuxue.png';
													?>" />
            <div class="pull-right">
			  <p>天气：<span><?php echo $demand['weather'];?></span></p>
              <p>温度：<span><?php echo $demand['temperature'];?>°C</span></p>
              <p>湿度：<span><?php echo $demand['humidity'];?>%</span></p>
            </div>
          </div>
          <div class="panel-item"> <img src="<?php if($demand['target']=='男')echo $base.'img/sex1.png';
													if($demand['target']=='女')echo $base.'img/sex2.png';
													?>" />
            <div class="pull-right">
              <p>熟练度：<span><?php echo $demand['proficiency'];?></span></p>
              <p>年龄：<span><?php echo $demand['age'];?></span></p>
			  <p>体重：<span><?php echo $demand['weight'];?>KG</span></p>
            </div>
          </div>
          <div class="text-center"> <?php $days=round((time()-strtotime($demand['createdate']))/3600/24); if($days<15){;?><a href="<?php if(isset($login)) echo $base.'design/practice?id='.$demand['id'];else echo 'javascript:showLoginModal();';?>" class="">去设计</a><?php }else{?><a class="" style="background-color:#f1f2f6"></a> <?php }?>
		  <a href="<?php if(isset($login)) echo $base.'demand';else echo 'javascript:showLoginModal();';?>" class="">去我的空间</a>
		  </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading"> <a id="am" href="javascript:void(0)" onclick="javasrcipt:chgpanel('m');" style="color: #333;font-size: 16px;">留言（<?php echo $demand['messnum'];?>）</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="ad" href="javascript:void(0)" onclick="javasrcipt:chgpanel('d');" style="color:#aeaeae;font-size: 16px;">设计（<?php echo $demand['designnum'];?>）</a></div>

		<!-- ################################################## -->
        <div class="panel-body mini-body" id="messpanel1" >
		  <input type="hidden" id="new_msg_uid" value="<?php echo $demand['uId'];?>"/>
		  <input type="hidden" id="msg_title_area" value=""></input>
          <textarea class="message-input" id="msg_content_area"></textarea>
          <div class="message-btns"> <a href="javascript:void(0);" onclick="javascript:smile(this,0);" ><img src="<?php echo $base.'img/xtp_xl.png';?>" /></a> <a href="#"><img src="<?php echo $base.'img/xtp_tp.png';?>" /></a> 
		  <?php if(isset($login)){?><a class="btn" href="javascript:void(0);" id="msg_send_btn" data-loading-text="请稍后">留　言</a>
		  <?php }else{?>
		  <a class="btn" href="javascript:void(0);" onclick="javascript:showLoginModal();" data-loading-text="请稍后">留　言</a>
		  <?php }?> 
		  </div>
        </div>
        <div class="list-group" id="messpanel2" >
		  <?php $i=0; foreach($message_data as $item): $i++;?>
          <div class="list-group-item">
            <div class="item-body"> <img class="pull-left" src="<?php echo $base.'img/geren_tp.png';?>" /> <span class="username"><?=$item['username']?>:</span> <script> document.write(replace_em('<?=$item['content']?>'));</script>
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
          		<div class="message-btns"> <a  href="javascript:void(0)"  onclick="javascript:smile(this,<?=$i?>);"><img src="<?php echo $base.'img/xtp_xl.png';?>" /></a> <a href="#"><img src="<?php echo $base.'img/xtp_tp.png';?>" /></a> <a class="btn" href="javascript:void(0);" onclick="send_sec_msg(<?=$i?>)">回　复</a> </div>
              </div>
			</div>
          </div>
		  <?php  endforeach;?>
        </div>
		<!-- ################################################## -->
        <div class="panel-body nopadding" id="designpanel" style="display:none;">
        	<table class="design-list" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <?php  foreach($designs as $item):?>
              <tr>
                <td>
                    <a class="title" href="<?php echo $base.'design/design_detail?id='.$item['id'];?>"><?=$item['title'];?></a>
                    <span class="view">浏览（<?=$item['viewnum'];?>）</span>
                </td>
                <td class="text-right">
                	<p class="font16">发布人：<a class="fbr" href="#"><?=$item['username'];?></a></p>
                    <span>发布于<?=$item['createdate'];?></span>
                </td>
              </tr>
			  <?php endforeach; ?>
            </table>
        </div>
		<!-- ################################################## -->


      </div>
    </div>
  </div>






<div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').css('display','none');">确定</button></div>
</div>


<input type="hidden" value="<?php echo $base; ?>" id="header_base" />
<input type="hidden" value="请稍候" id="login_wait"/>


<!------------ 底部开始 ------------->
<?php include("footer.php");?>
<script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
<script src="<?php echo $base.'js/message_other.js';?>"></script>
</div>
</body>
</html>
