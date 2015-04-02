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
<script type="text/javascript">

$(document).ready(function() {
	$(".nav-tabs li a").click(function(){
		var li = $(this).parent();
		if(!li.hasClass("active")){
			$(".nav-tabs li.active").removeClass("active");
			li.addClass("active");
		}
	});
	refresh();
});
function refresh(){
		for(i=0;i<$("input").length;i++){
		   var a=$("input:eq("+i+")");
		   if(a.attr('type')=='file'){
			   name = a.attr('id');
			   arr = name.split("_");
			   did = arr[1];
			   b = $("#a_"+did);
			   a.css("left",b.offset().left+5);
			   a.css("top",b.offset().top+5);
		   }
	 }

}
function getFileName(path){
	var pos1 = path.lastIndexOf('/');
	var pos2 = path.lastIndexOf('\\');
	var pos  = Math.max(pos1, pos2)
	if( pos<0 )
		return path;
	else
		return path.substring(pos+1);
}

function save_pic(type)
{
	ajaxUpload('form_pic'+type,$('#base').val()+'similarmanage/save_pic/?type='+type, 'photo_pic'+type,'',upload_succ);//shejiwenjian
	setTimeout(refresh(),1000);
}

function upload_succ()
{

	if($("#effect_img").length>0){
		$('#effectimg').attr('src',$('#effect_img').attr('src'));
		$('#effectimg1').attr('src',$('#effect_img').attr('src'));
	}
	if($("#detail_img").length>0){
		$('#a_detail').attr('src',$('#detail_img').attr('src'));
	}
}
</script>
<script src="<?php echo $base.'js/ajaxupload.js';?>"></script>
</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->


<!------------ 内容开始 -------------> 

<input type="hidden" id="base" value="<?php echo $base;?>"></input>
<input type="hidden" id="designid" value=""></input>

  <div id="messager-order" class="main fz">
  	<div class="modal" style="display:none;" id='modalconfirm'>
    	<div class="modal-dialog">
        	<div class="modal-header">仿真结果</div>
            <div class="modal-body">
            	<div class="modal-content">
                	<div class="col-8" style="margin:0 auto; float:none;">
                    	<div class="form-label">
                        	<label>进度：</label><select id='designstatus'>
                                <option value="2">已完成</option>
                                <option value="3">未完成</option>
                        	</select>
                        </div>
                        <div class="form-label">
                        	<label>备注：</label><input type="text" id="memo"/>
                        </div>
                    </div>
                    <div class="btns">
                    	<a href="javascript:;" onclick="$('.modal').hide();">取消</a>
                        <a href="javascript:;" onclick="savestatus();$('.modal').hide();" class="black">保存</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
		<div class="order-info">
        	<div class="messager pull-left">
            	<img src="<?php echo $base.$user_info['headphoto_path'];?>" />
                 <label><img src="<?php if($user_info['gender']==1)echo $base.'img/xtb_nan.png';else echo $base.'img/xtb_nv.png';?>" /><?php echo $user_info['username']; ?></label> 
            </div>
            <div class="order-texts pull-left">
            	<div class="title">管理状态&gt;仿真案例状态<a href="#" class="underline pull-right">订单最新消息（<font color="#f00">5</font>）</a></div>
                <ul class="texts">
                	<li><a href="<?echo $base.'similarmanage'?>" class="underline"><?echo $sum['cnt'];?></a><label>全部仿真案例</label></li>
                    <li><a href="?status=1" class="underline"><?echo $sum['cnt1'];?></a><label>未处理的仿真案例</label></li>
                    <li><a href="?status=2" class="underline"><?echo $sum['cnt2'];?></a><label>完成的仿真案例</label></li>
                </ul>
            </div>
        </div>
      <ul class="nav nav-tabs" role="tablist">
          <li class="tab-item <? if(!isset($_GET['status']))echo 'active'?>"><a href="<?echo $base.'similarmanage'?>" >全部</a></li>
          <li class="tab-item <? if(isset($_GET['status']) && $_GET['status']==1)echo 'active'?>"><a href="?status=1">未处理的仿真案例</a></li>
          <li class="tab-item <? if(isset($_GET['status']) && $_GET['status']==2)echo 'active'?>"><a href="?status=2">完成的仿真案例</a></li>
       </ul>
    
        <div class="tab-content">
          <div class="tab-pane active" id="home">
          	<ul class="header">
            	<li style="width: 12%;">设计产品</li>
                <li style="width: 12%;">已提交的仿真</li>
                <li style="width: 56%;">上传仿真结果</li>
                <li style="width: 10%;">确认结果</li>
                <li style="width: 10%;">仿真状态</li>
            </ul>
			<div id="content">
			<?php $i=0; foreach($designs as $item): $i++?>
            <div class="order-items" id="divcontent">
            	<ul>
                	<li class="img"><img style="width:73px;height:116px;" src="<?php if(!empty($item['design_pic'])) echo $base.$base_photoupload_path.'temp/'.$item['design_pic'];else echo $base.'img/default.jpg';?>" /></li>
                    <li class="xml" style="width:12%;"><label><?php echo $item['uId'].$item['id'].'.xml'?><br /><a class="download" href="<?php echo $base.'similarmanage/downloads?fn='.$item['uId'].$item['id'].'.xml'?>" id="xml_<?php echo $item['id'];?>" >点击下载</a></label></li>
                    <li class="upd">
						
						<form id="form_pic1<?echo $item['id']?>" name="form_pic" action="" method="POST" onsubmit="return false;">
                    	<div class="upload"><label>舒适度文件：</label><input type="text" id="spic1_<?echo $item['id']?>" readonly/><a class="btn" id="a_pic1<?echo $item['id']?>">浏览</a><input type="file"  class="btn" id="f_pic1<?echo $item['id']?>" name="f_pic1<?echo $item['id']?>" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:50px;cursor:pointer;" onchange="document.getElementById('spic1_'+<?echo $item['id']?>).value=getFileName(this.value)" />
						<?if($item['status']==1){?><a href="#" class="ipload_btn" onclick="save_pic(1<?echo $item['id']?>);">上传文件</a><?}?>
						<span id="photo_pic1<?echo $item['id']?>" style="text-align:center;display:;">
						<?if($item['similarpic']){$arr=explode('||',$item['similarpic'])?><img src="<?echo $base.$arr[0];?>" style="width:30px;height:30px"><?}?>
						</span>
						</div>
						
						</form>
						<form id="form_pic2<?echo $item['id']?>" name="form_pic" action="" method="POST" onsubmit="return false;">
                        <div class="upload"><label>皮肤湿度文件：</label><input type="text" id="spic2_<?echo $item['id']?>" readonly /><a class="btn"  id="a_pic2<?echo $item['id']?>">浏览</a><input type="file"  id="f_pic2<?echo $item['id']?>" name="f_pic2<?echo $item['id']?>" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:50px;cursor:pointer;" onchange="document.getElementById('spic2_'+<?echo $item['id']?>).value=getFileName(this.value)" />
						<?if($item['status']==1){?><a href="#" class="ipload_btn" onclick="save_pic(2<?echo $item['id']?>);">上传文件</a><?}?>
						<span id="photo_pic2<?echo $item['id']?>" style="text-align:center;display:">
						<?if($item['similarpic']){$arr=explode('||',$item['similarpic'])?><img src="<?echo $base.$arr[1];?>" style="width:30px;height:30px"><?}?>
						</span>
						</div>
						</form>
						<form id="form_pic3<?echo $item['id']?>" name="form_pic" action="" method="POST" onsubmit="return false;">
                        <div class="upload"><label>湿度文件：</label><input type="text" id="spic3_<?echo $item['id']?>" readonly /><a class="btn"  id="a_pic3<?echo $item['id']?>">浏览</a><input type="file"  id="f_pic3<?echo $item['id']?>" name="f_pic3<?echo $item['id']?>" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:50px;cursor:pointer;" onchange="document.getElementById('spic3_'+<?echo $item['id']?>).value=getFileName(this.value)" />
						<?if($item['status']==1){?><a href="#" class="ipload_btn" onclick="save_pic(3<?echo $item['id']?>);">上传文件</a><?}?>
						<span id="photo_pic3<?echo $item['id']?>" style="text-align:center;display:">
						<?if($item['similarpic']){$arr=explode('||',$item['similarpic'])?><img src="<?echo $base.$arr[2];?>" style="width:30px;height:30px"><?}?>
						</span>
						</div>
						</form>
						
                    </li>
                    <li class="step"><span style="cursor:pointer;" onclick="$('#designid').val(<?echo $item['id'];?>);<?if($item['status']==1) echo '$(\'#modalconfirm\').show();';else echo 'savestatus(3);'?>"><?if($item['status']==1)echo '仿真完成';else echo '重新仿真';?></span></li>
                    <?php if($item['status']==1){?><li class="step text-orange">仿真进行中</li><?}?>
					<?php if($item['status']==2){?><li class="step text-green">仿真完成</li><?}?>
					<?php if($item['status']==3){?><li class="step text-red">仿真失败</li><?}?>
                </ul>
                <div class="bottom">
                	<span>设计编号：<?php echo $item['id'];?></span>
                    <span>提交时间：<?php echo $item['createdate'];?></span>
                    <span>提交人：<?php echo $item['username'];?></span>
                    <a href="<?php echo $base.'design/design_detail?id='.$item['id'];?>" class="pull-right">前往详情《</a>
                </div>
             </div>
			 <?php endforeach; ?>
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
	
	var url = $('#base').val() + 'similarmanage/sort_similar/';
	var post_str = 'index=' + index;
	status =window.location.search;
	status=status.substr(1);
	post_str=post_str+'&'+status;
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'base':$('#base').val(),'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}

function savestatus(tt)
{
	var url = $('#base').val() + 'similarmanage/savestatus/';
	status = $('#designstatus').val();
	var post_str = 'designid=' + $('#designid').val() + '&status=' + status+ '&memo=' + $('#memo').val();
	if(tt==3){
		status=3;
		post_str = 'designid=' + $('#designid').val() + '&status=1&memo=&similarpic=';
	}
	if(status==2){
		type1 = 'img_1'+$('#designid').val();
		type2 = 'img_2'+$('#designid').val();
		type3 = 'img_3'+$('#designid').val();
		if($('#'+type1).length==0 ){alert('请上传舒适度文件');return;}
		if($('#'+type2).length==0 ){alert('请上传皮肤湿度文件');return;}
		if($('#'+type3).length==0 ){alert('请上传湿度文件');return;}
		img1=$('#'+type1).attr('src');img1=img1.replace($('#base').val(),'');
		img2=$('#'+type2).attr('src');img2=img2.replace($('#base').val(),'');
		img3=$('#'+type3).attr('src');img3=img3.replace($('#base').val(),'');
		post_str = post_str+"&similarpic="+img1+"||"+img2+"||"+img3;
	}
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		window.location.reload();
	}};
	jQuery.ajax(ajax);
}

</script>

</html>
