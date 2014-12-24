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
function showModal(id,title,createdate,design_pic,username){
	$('#dd_tjsj').html('提交时间：' + createdate);
	$('#dd_title').html('《'+title+'》的订单');
	$('#dd_username').html('设计人：'+username);
	$('#dd_id').html('订单ID:'+id+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;订单原设计：《'+title+'》');
	$('#dd_img').attr('src',$('#base').val()+$('#base_photoupload_path').val()+'temp/'+design_pic);
	$('#design_id').val(id);
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

	//if(town=='') hint=hint+'请选择地区<br/>';
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
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 

<input type="hidden" id="base" value="<?php echo $base;?>"></input>
<input type="hidden" id="base_photoupload_path" value="<?php echo $base_photoupload_path;?>"></input>
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
							<?php if($item['status']==1){?><a href="javascript:alert('仿真进行中，结果将在第一时间发送给您，谢谢');" class="black">等待仿真</a><?php }?>
							<?php if($item['status']==2){?><a href="<?php echo $base.'design/similar_detail';?>">查看仿真</a><?php }?>
							<a  href="javascript:;" onclick="<?php echo 'showModal('.$item['id'].',\''.$item['title'].'\',\''.$item['createdate'].'\',\''.$item['design_pic'].'\',\''.$item['username'].'\')';?> ">提交订单</a>
							</div>
                            <p><span class="link link-liulan">浏览（<?php echo $item['viewnum']?>）</span><span class="link link-liuyan">留言（<?php echo $item['messnum']?>）</span><span class="pull-right">发布于<?php echo $item['createdate']?></span></p>
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


<!------------提交订单开始-------------->
<div class="modal design" role="modal" id="draggable">
    <div class="design-main">
    	<div class="design-title">
        	订单详情 > 提交订单
            <span class="pull-right">订单提交者：<?php if(isset($user_info['username']))echo $user_info['username']; ?></span>
        </div>
		<input type="hidden" id="design_id" value="">
        <table width="100%" class="design-table">
          <tr>
            <td class="table-title" colspan="2" bgcolor="#454545"><span id="dd_id">订单ID:123456789001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;订单原设计：《》</span><span class="pull-right" id="dd_tjsj">提交时间：</span></td>
          </tr>
          <tr>
            <td>
            	<img id="dd_img" class="pull-left" src="" width="85" height="90" style="margin:8px;" />
                <div class="pull-left" style="padding:15px 5px;">
                	<label style="font-size:18px; display:block;" id="dd_title"></label>
                    <span style="font-size:16px; color:#707070;" id="dd_username">设计人：</span>
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

<div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" onclick="$('#msg_modal').addClass('hide');" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').addClass('hide');">确定</button></div>
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
</html>
