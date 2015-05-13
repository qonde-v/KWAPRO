<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIT系统</title>
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script src="<?php echo $base.'js/jquery.min.js';?>" type="text/javascript"></script>
<script type="text/javascript">
var _move=false;//移动标记
var _x,_y;//鼠标离控件左上角的相对位置
$(document).ready(function() {
	/*$(".nav-flow li a").click(function(){
		var li = $(this).parent();
		if(!li.hasClass("active")){
			if(li.index()>=1){
				if($("#design_img").length==0 || $("#effect_img").length==0 || $("#title").val()==''){
					$('.modal-body').html('请将步骤一里的信息填写完整');
					$('#msg_modal').removeClass("hide");
					return;
				}
			}
			$(".nav-flow li.active").removeClass("active");
			li.addClass("active");
			$(".tab-content.active").removeClass("active");
			$("#"+$(this).attr("class")).addClass("active");
		}
		if(li.index()==2){
			$('.thumbs').find("li").remove(); 
			var inputlist=document.getElementById("detailpics").getElementsByTagName("input"); 
			var list=document.getElementById("detailpics").getElementsByTagName("img"); 
			for (var i = 0; i < list.length; i++) {
				var img=list[i];
				var input=inputlist[i];
				var num = i+1;
				var html = '<li><img id="crop_photo'+num+'" width="100px" height="96px" src="'+img.src+'" onclick="showthumb(this)"/><input id="crop_name'+num+'" type="hidden" value="'+input.value+'"></li>';
				$('.thumbs').append(html);
				
				if(!($('#crop_fabric'+num).length>0)){
					var html1 = '<input id="crop_fabric'+num+'" type="hidden" value="">';
					$('#flow3').append(html1);
				}
			}
		}
	});*/
	
	$(".ml_list li").click(function(){
		$(".ml_list li.active").removeClass("active");
		$(this).addClass("active");
		var ff = $(this).find('input').val();
		array = ff.split("||");
		var base = $('#base').val();
		
	    $("#fab_name").html('名称：' + array[1]);
		$("#fab_pic").attr('src',base.substr(0,base.lastIndexOf('TIT')) + 'PDB/uploads/fabric/2DImages//' + array[2]);
		$("#fab_description").html(array[3]);
		$("#fab_feature").html(array[4]);
		$("#fab_price").html(array[5]);

		if($('#path').attr('class')=='black'){
			var id=$('#cropid').val();
			$("#crop_fabric"+id).val(array[0]);
		}else{
			$("#fabric").val(array[0]);
		}

	});
	
	$(".tab-btns a").click(function(){
		$(".tab-btns a.black").removeClass("black");
		$(this).addClass("black");
		if($(this).attr("id") == "path"){
			$(".thumbs").show();
		}
		else{
			$(".thumbs").hide();
			$('#detailname').html('整体');
		}
	});
	$(".selecter ul li").click(function(){
		$(".tab-btns a.black").removeClass("black");
		$(".selecter ul").hide();
		$(".selecter span").html($(this).text());
		$("#type").val($(this).text());
	});
	$(".selecter i").click(function(){
		$(".selecter ul").show();
	});

	jQuery($('#f_design')).css("left",jQuery($('#a_design')).offset().left);
	jQuery($('#f_design')).css("top",jQuery($('#a_design')).offset().top);
	jQuery($('#f_effect')).css("left",jQuery($('#a_effect')).offset().left);
	jQuery($('#f_effect')).css("top",jQuery($('#a_effect')).offset().top);
	jQuery($('#f_detail')).css("left",jQuery($('#a_detail')).offset().left);
	jQuery($('#f_detail')).css("top",jQuery($('#a_detail')).offset().top);
	$("#a_design").click(function(){
		$("#f_design").click();
	});
	$("#a_effect").click(function(){
		$("#f_effect").click();
	});
	$("#a_detail").click(function(){
		$("#f_detail").click();
	});


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
function gonext(bu){
	if(bu>=2){
		//if($("#design_img").length==0 || $("#effect_img").length==0 || $("#title").val()==''){
		if($("#title").val()==''){
			$('.modal-body').html('请填写设计作品名称');
			$('#msg_modal').removeClass("hide");
			return;
		}
	}
	$(".nav-flow li.active").removeClass("active");
	$("#bu"+bu).addClass("active");
	$(".tab-content.active").removeClass("active");
	$("#flow"+bu).addClass("active");
	if(bu==3){
		$('.thumbs').find("li").remove(); 
		var inputlist=document.getElementById("detailpics").getElementsByTagName("input"); 
		var list=document.getElementById("detailpics").getElementsByTagName("img"); 
		for (var i = 0; i < list.length; i++) {
			var img=list[i];
			var input=inputlist[i];
			var num = i+1;
			var html = '<li><img id="crop_photo'+num+'" width="100px" height="96px" src="'+img.src+'" onclick="showthumb(this)"/><input id="crop_name'+num+'" type="hidden" value="'+input.value+'"></li>';
			$('.thumbs').append(html);
			
			if(!($('#crop_fabric'+num).length>0)){
				var html1 = '<input id="crop_fabric'+num+'" type="hidden" value="">';
				$('#flow3').append(html1);
			}
		}
		
	}
}
function showthumb(obj){
	$(".thumbs li.active").removeClass("active");
	$(obj).parent().addClass("active");
	$('#effectimg1').attr('src',$(obj).attr('src'));
	$('#detailname').html($(obj).parent().find('input').val());

	var i = $(obj).parent().index() + 1;
	$('#cropid').val(i);

	if($('#crop_fabric'+i).length>0){
		var fab = $('#crop_fabric'+i).val();
		if(fab!=''){
			var post_str = 'id='+fab;
			var url = $('#base').val() + 'design/getfabric/';
			var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
				array = html.split("||");
				$("#fab_name").html('名称：' + array[1]);
				$("#fab_pic").attr('src',$('#base').val() + 'img/' + array[2]);
				$("#fab_description").html(array[3]);
				$("#fab_feature").html(array[4]);
				$("#fab_price").html(array[5]);
			}};
			jQuery.ajax(ajax);
		}

	}

}
function showModal(){
	$('.modal').show();
	$('#login_modal').attr('style','display:none');
	$(".modal-bg").css("height",$("body").height());
	$(".modal-bg").show();
}
function hidermodal(){
	$('.modal').hide();
	$(".modal-bg").hide();
}
</script>

<script>

function save_pic(type)
{
	if(type==1){
		ajaxUpload('form_designpic',$('#base').val()+'design/save_pic/?type=1', 'design_photo','',upload_succ);//shejiwenjian
	}else if(type==2){
		ajaxUpload('form_effectpic',$('#base').val()+'design/save_pic/?type=2', 'effect_photo','',upload_succ);//shejiwenjian
	}else if(type==3){
		ajaxUpload('form_detailpic',$('#base').val()+'design/save_pic/?type=3', 'detail_photo','',upload_succ);//shejiwenjian
	}
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

function save_detailpic()
{
	var src = $('#detail_img').attr('src');
	var text = $('#detail_name').val();
	if(text==''){
		$('.modal-body').html('请输入细节名称');
		$('#msg_modal').removeClass("hide");;
		return;
	}
	if($('#picNumber').val()>=5){
		$('.modal-body').html('最多上传五张设计图');
		$('#msg_modal').removeClass("hide");
		return;
	}
	if(src.indexOf('.')>=0)
	{
		//$('#crop_photo').attr('src',src);		
		var html = '<span><dt><img width="100px" height="100px" src="'+src+'" /><dt><dd><div class="form-items"><label>细节：</label><input type="text" value="'+text+'" readonly="readonly"/><a href="#" onclick="del_pic(this)">删除</a></div></dd></span>';

		$('#detailpics').append(html);

		var num=document.getElementById("detailpics").getElementsByTagName("img").length; 		
		$('#picNumber').val(num);

		$('#detail_name').val('');
		$('#a_detail').attr('src',$('#base').val()+'img/sjlc_yifu_tj.png');
	}
}
function del_pic(obj)
{
	var tb = obj.parentNode.parentNode.parentNode.parentNode;
	tb.removeChild(obj.parentNode.parentNode.parentNode);
	var num=document.getElementById("detailpics").getElementsByTagName("img").length; 
	$('#picNumber').val(num);
}


function designok()
{
	var data = new Array();
	var hint = '';
	data['title'] = $('#title').val();
	//data['design_pic'] = getFileName($('#design_img').attr('src'));
	//data['effect_pic'] = getFileName($('#effect_img').attr('src'));
	defaultimg='default_yundong.jpg';
	if($('#sporttype')=='跑步')defaultimg='default_paobu.jpg';
	if($('#sporttype')=='步行')defaultimg='default_jianxing.jpg';
	if($('#sporttype')=='健身运动')defaultimg='default_yujia.jpg';
	if($('#sporttype')=='自行车运动')defaultimg='default_zixingche.jpg';
	if($('#design_img').length>0)data['design_pic'] = getFileName($('#design_img').attr('src'));else data['design_pic']=defaultimg;
	if($('#effect_img').length>0)data['effect_pic'] = getFileName($('#effect_img').attr('src'));else data['effect_pic']=defaultimg;

	data['demand_id'] = $('#demand_id').val();
	data['description'] = $('#description').val();
	data['fabric'] = $('#fabric').val();
	data['type'] = $('#type').val();
	if(data['title']=='') hint=hint+'请输入作品名称<br/>';
	//if(data['design_pic']=='' || data['effect_pic']=='') hint=hint+'请上传设计文件或产品效果图<br/>';
	//if(data['effect_pic']=='') hint=hint+'请上传产品效果图<br/>';
	if(data['description']=='') hint=hint+'请输入对设计的描述<br/>';
	if($('#path').attr('class')=='' && data['fabric']=='') hint=hint+'请选择整体面料<br/>';
	
	if($('#crop_photo1').length>0){
		data['crop_photo1'] = $('#crop_photo1').attr('src');
		data['crop_name1'] = $('#crop_name1').val();
		data['crop_fabric1'] = $('#crop_fabric1').val();
		if($('#path').attr('class')=='black' && data['crop_fabric1']=='') hint=hint+'请选择细节面料<br/>';
	}
	if($('#crop_photo2').length>0){
		data['crop_photo2'] = $('#crop_photo2').attr('src');
		data['crop_name2'] = $('#crop_name2').val();
		data['crop_fabric2'] = $('#crop_fabric2').val();
		if($('#path').attr('class')=='black' && data['crop_fabric2']=='') hint=hint+'请选择细节面料<br/>';
	}
	if($('#crop_photo3').length>0){
		data['crop_photo3'] = $('#crop_photo3').attr('src');
		data['crop_name3'] = $('#crop_name3').val();
		data['crop_fabric3'] = $('#crop_fabric3').val();
		if($('#path').attr('class')=='black' && data['crop_fabric3']=='') hint=hint+'请选择细节面料<br/>';
	}
	if($('#crop_photo4').length>0){
		data['crop_photo4'] = $('#crop_photo4').attr('src');
		data['crop_name4'] = $('#crop_name4').val();
		data['crop_fabric4'] = $('#crop_fabric4').val();
		if($('#path').attr('class')=='black' && data['crop_fabric4']=='') hint=hint+'请选择细节面料<br/>';
	}
	if($('#crop_photo5').length>0){
		data['crop_photo5'] = $('#crop_photo5').attr('src');
		data['crop_name5'] = $('#crop_name5').val();
		data['crop_fabric5'] = $('#crop_fabric5').val();
		if($('#path').attr('class')=='black' && data['crop_fabric5']=='') hint=hint+'请选择细节面料<br/>';
	}
	if(hint!=''){
		$('.modal-body').html(hint);
		$('#msg_modal').removeClass("hide");
		$('#msg_modal').show();
		return;
	}


	var post_str = generate_query_str(data);
	var url = $('#base').val() + 'design/designok/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		if(html=='1'){
			//alert('设计名称已存在，请重新输入');
			$('.modal-body').html('设计名称已存在，请重新输入');
			$('#msg_modal').removeClass("hide");
			$('#msg_modal').show();
		}else{
			var strs= new Array(); //定义一数组
			strs=html.split("&&&&"); //字符分割 
	
			$("#flow5").html(strs[0]);
			$(".tab-content.active").removeClass("active");
			$("#flow5").addClass("active");
			if(confirm('是否要分享到微博')){
				window.open('http://v.t.sina.com.cn/share/share.php?title=嗨，我刚才发布了一个休闲服装设计'+$('#base').val()+'design/design_detail?id='+strs[1]+'，来来提提意见呗？&url=&source=bookmark');
			}
		}

	}};
	jQuery.ajax(ajax);
	//setTimeout("window.location.href=$('#base').val() + 'design/'",200);

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
function getFileName(path){
	var pos1 = path.lastIndexOf('/');
	var pos2 = path.lastIndexOf('\\');
	var pos  = Math.max(pos1, pos2)
	if( pos<0 )
		return path;
	else
		return path.substring(pos+1);
}
</script>

</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->





<!------------ 内容开始 -------------> 
<input type="hidden" id="base" value="<?php echo $base;?>"></input>
<input type="hidden" id="demand_id" value="<?php echo $demand['id'];?>"></input>
<input type="hidden" id="sporttype" value="<?php echo $demand['type'];?>"></input>
  <div id="sjlc" class="main flows"> 
	<img src="<?php echo $base.'img/sub_top_dt.png';?>" />
  	<div class="modal" id="draggable" style="position:absolute;">
        <div class="modal-header">
            选择面料
            <a href="javascript:;" onclick="hidermodal()">保存</a>
        </div>
        <div class="modal-content">
            <ul class="ml_list">
				<?php foreach($fabric as $item):?>
                <li>
                    <img width="106px" height="106px" src="<?php echo substr($base,0,strpos($base,"TIT")).'PDB/uploads/fabric/2DImages/'.$item['fabricFigure'];?>"/>
                    <label><?php echo $item['fabricName'];?></label>
					<input type="hidden" value="<?php echo $item['fabricId'].'||'.$item['fabricName'].'||'.$item['fabricFigure'].'||'.$item['fabricStruct'].'||'.$item['fabricFunctionNote'].'||'.$item['price'];?>">
                </li>
				<?php endforeach;?>
            </ul>
        </div>
        <div class="modal-footer">
        	<a class="more" href="#">展开更多面料▶</a>
        </div>
    </div>
    <div class="modal-bg"></div>
    <ul class="breadcrumb" style="background-color:#f1f2f6; margin-top:15px;">
      <li><a href="<?php echo $base;?>">首页</a></li>
      <li>/</li>
      <li><a href="<?php echo $base.'demand/demandlist';?>">需求广场</a></li>
      <li>/</li>
      <li><a href="#">发布设计</a></li>
    </ul>
    <div class="content" style="background-color:#f1f2f6;">
    	<ul class="nav-flow">
        	<li id="bu1" class="active"><a href="javascript:;" class="flow1"></a></li>
            <li id="bu2"><a href="javascript:;" class="flow2"></a></li>
            <li id="bu3"><a href="javascript:;" class="flow3"></a></li>
            <li id="bu4"><a href="javascript:;" class="flow4"></a></li>
        </ul>
        <div id="flow1" class="tab-content active">
        	<div class="panel-top">
                	<p class="pull-left">
                    	需求：<?php echo $demand['title'];?><br />
                        需求发布者：<?php echo $demand['username'];?>
                    </p>
                    <a href="<?php echo $base.'demand/demand_detail?id='.$demand['id'];?>" class="pull-right">查看详情》</a>
            </div>
       	  <div class="panel panel-default"> 
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
													if($demand['type']=='户外山地')echo $base.'img/s_shandi.png';
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
                </div>
              </div>
        	<table width="100%" style="margin-bottom:30px;">
              <tr>
                <td width="15%" height="52" >设计作品名称<span style="color:red;">(必填)</span>:
                </td>
                <td width="39%">
                	<input id="title" name="title" type="text" value="<?php echo $demand['title'].'-'.$user_info['username'].'-'.$designnum?>"/>
                </td>
                <td width="15%">设计的产品类型：</td>
                <td width="34%">
                  <div class="selecter"> 
				  <span>上衣</span><i></i>
				    <input id="type" name="type" type="hidden"  value='上衣' />
                    <ul style="display:none">
                      <li>上衣</li>
                      <li>裤子</li>
                    </ul>
                  </div>
                  </td>
              </tr>
              <tr>
                <td height="52">上传设计<span style="color:red;">(选填)</span>:</td>
				<form id="form_designpic" name="form_pic" action="" method="POST" onsubmit="return false;">
                <td><input name="design_pic" id="design_pic" type="text" readonly /></td>
                <td colspan="2" class="btns">
                    <a id="a_design" href="#" class="black" >浏览</a>
					<input type="file" id="f_design" name="f_design" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:50px;cursor:pointer;" onchange="document.getElementById('design_pic').value=getFileName(this.value)" />
                    <a href="#" onclick="save_pic(1);">上传设计文件</a>
					<div id="design_photo" style="text-align:center;display:inline-block"></div>
                </td>
				</form>
              </tr>
              <tr>
                <td height="52">产品效果图<span style="color:red;">(选填)</span>:</td>
				<form id="form_effectpic" name="form_pic" action="" method="POST" onsubmit="return false;">
                <td><input name="effect_pic" id="effect_pic" type="text" readonly/></td>
                <td colspan="2" class="btns">
                    <a id="a_effect" href="#" class="black">浏览</a>
					<input type="file" id="f_effect" name="f_effect" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:50px;cursor:pointer;" onchange="document.getElementById('effect_pic').value=getFileName(this.value)" />
                    <a href="#" onclick="save_pic(2);">上传效果图</a>
					<div id="effect_photo" style="text-align:center;display:inline-block"></div>
                </td>
				</form>
              </tr>
            </table>
            <div class="btns">
                <a href="javascript:gonext(2)">下一步</a>
            </div>
        </div>
        <div id="flow2" class="tab-content">
        	<div class="impression">
            	<div class="left">
                	<div class="title">产品效果图</div>
                    <img id="effectimg" width="498" height="498" src="<?if($demand['type']=='跑步')$img='1_default_paobu.jpg';elseif($demand['type']=='自行车运动')$img='1_default_zixingche.jpg';elseif($demand['type']=='健身运动')$img='1_default_yujia.jpg';if($demand['type']=='步行')$img='1_default_jianxing.jpg';else $img='1_default_paobu.jpg';echo $base.$base_photoupload_path.'temp/'.$img;?>"/>
                </div>
                <div class="right">
                	<div class="title">添加产品特色样式：<small>（添加细节图片）</small></div>
					<input type="hidden" id="picNumber" name="picNumber">
                    <dl>
					    <span id="detailpics">
                    	<!-- <dt><img src="<?php echo $base.'img/sjlc_yifu_01.png';?>" /><dt>
                        <dd>
                        	<div class="form-items">
                        	<label>细节：</label><input type="text" value="衣领" /><a href="#">删除</a>
                            </div>
                        </dd> -->
						</span>
						<form id="form_detailpic" name="form_pic" action="" method="POST" onsubmit="return false;">
                        <dt><img id="a_detail" width="100px" height="100px" src="<?php echo $base.'img/sjlc_yifu_tj.png';?>" />
							<input type="file" id="f_detail" name="f_detail" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:100px;height:100px;cursor:pointer;" disabled />
						<dt>
                        <dd>
                        	<div class="form-items">
                        	<label>细节：</label><input type="text" id="detail_name" disabled />
                            </div>
                            <div class="btns">
                            	<a  href="#">上传细节</a>
                    			<a href="#">保存</a>
								<div id="detail_photo" style="text-align:center;display:inline-block"></div>
                            </div>
                        </dd>
						</form>
                    </dl>
                </div>
            </div>
            <div class="btns">
            	<a href="javascript:gonext(1)">上一步</a>
                <a href="javascript:gonext(3)" class="black">下一步</a>
            </div>
        </div>
        <div id="flow3" class="tab-content">
        	<div class="impression">
            	<div class="left">
                	<div class="btns tab-btns">
                        <!-- <a id="path" href="javascript:;" class="">各部位多面料设计</a>&nbsp;&nbsp;&nbsp;&nbsp; -->
                        <a href="javascript:;" class="black" style="float:left;">样式设计图</a>
                    </div>
                    <img id="effectimg1" src="<?if($demand['type']=='跑步')$img='1_default_paobu.jpg';elseif($demand['type']=='自行车运动')$img='1_default_zixingche.jpg';elseif($demand['type']=='健身运动')$img='1_default_yujia.jpg';if($demand['type']=='步行')$img='1_default_jianxing.jpg';else $img='1_default_paobu.jpg';echo $base.$base_photoupload_path.'temp/'.$img;?>" width="498" height="498"/>
					<input type="hidden" id="cropid" value="">
                    <ul class="thumbs">
                    	<!-- <li class="active"><img src="<?php echo $base.'img/sjlc_yifu_01.png';?>" /></li>
                        <li><img src="<?php echo $base.'img/sjlc_yifu_02.png';?>" /></li>
                        <li><img src="<?php echo $base.'img/sjlc_yifu_03.png';?>" /></li>
                        <li><img src="<?php echo $base.'img/sjlc_yifu_04.png';?>" /></li>
                        <li><img src="<?php echo $base.'img/sjlc_yifu_01.png';?>" /></li> -->
                    </ul>
                </div>
                <div class="right">
                	<h3 id="detailname"></h3><input type="hidden" id="fabric" >
                    <a class="btn-fabric" href="javascript:;" onClick="showModal()">点击选择面料&nbsp;▶&nbsp;</a>
                    <div class="fabric"><img id="fab_pic" width="230" height="120"></div>
                    <h4 id="fab_name"></h4>
                    <h4>介绍：</h4>
                    <p id="fab_description"></p>
                    <h4>特点：</h4>
                    <p id="fab_feature"></p>
					<h4>参考价格：</h4>
                    <p id="fab_price"></p>
                </div>
            </div>
            <div class="btns">
            	<a href="javascript:gonext(2)">上一步</a>
                <a href="javascript:gonext(4)">下一步</a>
            </div>
        </div>
        <div id="flow4" class="tab-content">
        	<table width="95%">
              <tr>
                <td height="67" class="font16">一句话描述您的设计：
                </td>
                <td width="39%" rowspan="2">
                    <div class="info">
                    <label> </label>
                     </div>
                </td>
              </tr>
              <tr>
                <td height="185" valign="top">
                	<textarea id="description"></textarea>
                </td>
              </tr>
            </table>
            <div class="btns">
            	<a href="javascript:gonext(3)">上一步</a>
            	<a class="black" href="#" onclick="javascript:if(confirm('确定要提交设计吗？')){designok();}">提交</a>
            </div>
      </div>
      <div id="flow5" class="tab-content">
        	<!-- <div class="submin-info">
            	<img src="images/wc_xtb.png" />
                <strong>成功</strong>
                <span>提交者：小宅</span><span>提交时间：2014-05-15</span>
                <p>详细情况请点击<a href="#" >查看详情</a></p>
            </div>
            <div class="other_title">
            	相关设计产品
            </div>
            <ul class="others">
            	<li class="start"><a href="#"><img src="images/xqlc_yifu.png" /></a></li>
                <li><a href="#"><img src="images/xqlc_yifu.png" /></a></li>
                <li><a href="#"><img src="images/xqlc_yifu.png" /></a></li>
                <li><a href="#"><img src="images/xqlc_yifu.png" /></a></li>
                <li><a href="#"><img src="images/xqlc_yifu.png" /></a></li>
                <li class="end"><a href="#"><img src="images/xqlc_yifu.png" /></a></li>
            </ul> -->
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
</div>
</body>
	<script src="<?php echo $base.'js/ajaxupload.js';?>"></script>

</html>
