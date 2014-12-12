<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIT系统</title>
<link href="<?php echo $base.'css/jquery-ui.css';?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script src="<?php echo $base.'js/jquery.min.js';?>" type="text/javascript"></script>
<script src="<?php echo $base.'js/jquery-ui.min.js';?>" type="text/javascript"></script>

<script>
$(document).ready(function() {
	$("[role=slider]").each(function(){
		var i = $(this).find(".min font").html();
		var a = $(this).find(".max font").html();

		var s = 1;
		var v = 0;
		if($(this).attr("id") == "qiangdu"){
			v = 1;
			i -= 1;
			a -= 1;
		}

		if($(this).attr("id") == "shijian"){
			v = 40;
			i -= 20;
			a -= 20;
		}

		if($(this).attr("id") == "tizhong"){
			i -= 20;
			a -= 20;
		}
		if($(this).attr("id") == "nianling"){
			i -= 8;
			a -= 8;
		}
		if($(this).attr("id") == "wendu"){
			i = parseInt(i) + 20;
			a = parseInt(a) + 20;
		}
		if($(this).attr("id") == "shidu"){
			v = 15;
		}
		$(this).slider({
			orientation: "horizontal",
			range: "min",
			min: i,
			max: a,
			animate: true,
			step: s,
			value: v,
			create: function( event, ui ) {
				$(this).find(".ui-slider-handle").html($("<div class='slider-value'></div>"));
			},
			slide: function( event, ui ) {
				if($(this).attr("id") == "tizhong"){
					$(this).find(".slider-value").html(ui.value + 20);
					$('#weight').val(ui.value + 20);
				}
				else if($(this).attr("id") == "qiangdu"){
					$(this).find(".slider-value").html(ui.value + 1);
					$('#strength').val(ui.value + 1);
				}
				else if($(this).attr("id") == "shijian"){
					$(this).find(".slider-value").html(ui.value + 20);
					$('#sporttime').val(ui.value + 20);
				}else if($(this).attr("id") == "wendu"){
					$(this).find(".slider-value").html(ui.value - 20);
					$('#temperature').val(ui.value - 20);
				}else if($(this).attr("id") == "shidu"){
					$(this).find(".slider-value").html(ui.value);
					$('#humidity').val(ui.value);
				}else if($(this).attr("id") == "shulian"){
					$(this).find(".slider-value").html(ui.value);
					$('#proficiency').val(ui.value);
				}else if($(this).attr("id") == "nianling"){
					$(this).find(".slider-value").html(ui.value + 8);
					$('#age').val(ui.value + 8);
				}
			}
		});
	});
	
	$(".nav-flow li a").click(function(){
		var li = $(this).parent();
		if(!li.hasClass("active")){
			$(".nav-flow li.active").removeClass("active");
			li.addClass("active");
			$(".tab-content.active").removeClass("active");
			$("#"+$(this).attr("class")).addClass("active");
		}
	});
	
	$(".radio-box .img").click(function(){
		if($(this).hasClass("male")){
			$(this).attr("class","img female");
			$('#target').val('女');
		}
		else{
			$(this).attr("class","img male");
			$('#target').val('男');
		}
	});
});
function gonext(bu){
	$(".nav-flow li.active").removeClass("active");
	$("#bu"+bu).addClass("active");
	$(".tab-content.active").removeClass("active");
	$("#flowxq"+bu).addClass("active");
}
function showModal(){
	$(".modal").show();
	$(".modal-bg").css("height",$("body").height());
	$(".modal-bg").show();
}
function hidermodal(){
	$(".modal").hide();
	$(".modal-bg").hide();
}
</script>
<script type="text/javascript">
	var onFocusID = "";
	  function showtype(obj,obj_d,obj_t)
	  {
		jQuery(obj_d).css("left",jQuery(obj).offset().left);
		jQuery(obj_d).css("top",jQuery(obj).offset().top+jQuery(obj).outerHeight());
		jQuery(obj_d).css("z-index",3);
		jQuery(obj_d).show();
		onFocusID = obj_t;
	   }
	  function hidetype(obj_d)
	  {
			jQuery(obj_d).hide();
	  }
	  $(function()
		{
			$("#divType img").each(function()
				{ $(this).click(function(){
					// this.checked="checked";
					//alert(jQuery(this).attr("alt"));
					if(onFocusID != "")
					{
						$("#" + onFocusID).val($(this).attr("alt"));
						$("#span_" + onFocusID).html($(this).attr("alt"));
						this.checked = "";
					}
					$("#divType").hide();
				});
			});

			$("#divWeather img").each(function()
				{ $(this).click(function(){
					// this.checked="checked";
					//alert(jQuery(this).attr("alt"));
					if(onFocusID != "")
					{
						$("#" + onFocusID).val($(this).attr("alt"));
						$("#span_" + onFocusID).html($(this).attr("alt"));
						this.checked = "";
					}
					$("#divWeather").hide();
				});
			});
	   });

</script>
</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 

<input type="hidden" id="base" value="<?php echo $base;?>"></input>
  <div id="xqlc" class="main flows">
	<a href="<?php echo $base.'demand/publish';?>"><img src="<?php echo $base.'img/sub_top_dt.png';?>" /></a>
  	<div class="modal">
        <div class="modal-header">
            <a href="javascript:;" onclick="hidermodal()">X</a>
        </div>
        <div class="modal-content">
            <ul class="ml_list">
                <li>晴天</li>
            </ul>
        </div>
    </div>
    <div class="modal-bg"></div>
    <ul class="breadcrumb" style="background-color:#f1f2f6; margin-top:15px;">
      <li><a href="<?php echo $base;?>">首页</a></li>
      <li>/</li>
      <li><a href="<?php echo $base.'demand/demandlist';?>">需求广场</a></li>
      <li>/</li>
      <li><a href="#">发布需求</a></li>
    </ul>
    <div class="content" style="background-color:#f1f2f6;">
    	<ul class="nav-flow">
        	<li id="bu1" class="active"><a href="javascript:;" class="flowxq1"></a></li>
            <li id="bu2"><a href="javascript:;" class="flowxq2"></a></li>
            <li id="bu3"><a href="javascript:;" class="flowxq3"></a></li>
            <li id="bu4"><a href="javascript:;" class="flowxq4"></a></li>
        </ul>
        <div id="flowxq1" class="tab-content active">
        	<table width="100%">
              <tr>
                <td width="10%" height="80" align="right" class="font16">类型：
                </td>
                <td width="51%">
                	<div class="select-box" onclick="showtype(this,$('#divType'),'type');" >
                   	<span id="span_type">跑步</span><i>&nbsp;</i></div>
					<input id="type" name="type" type="hidden"  value='跑步' />
                </td>
                <td width="39%" rowspan="3">
                    <div class="info">
                    <label>选择运动类型</label>
                    根据运动类型的特点，对面料的功能性要求也会不同，运动强度越大，时间越长，则要求面料的透气，舒适，能更好地调节体温。</div>
                </td>
              </tr>
              <tr>
                <td height="80" align="right" class="font16">强度：</td>
                <td>
                	<div role="slider" id="qiangdu">
                    	<div class="min"><font>1</font>（轻松）</div>
                        <div class="max"><font>8</font>（剧烈）</div>
						<input type="hidden" id="strength"  name="strength" value="2" >
                    </div>
                </td>
              </tr>
              <tr>
                <td height="80" align="right" class="font16">时间：</td>
                <td>
                	<div role="slider" id="shijian">
                    	<div class="min"><font>20</font>&nbsp;分钟</div>
                        <div class="max"><font>120</font>&nbsp;分钟</div>
						<input type="hidden" id="sporttime"  name="sporttime" value="60" >
                    </div>
                </td>
              </tr>
            </table>
            <div class="btns">
                <a href="javascript:gonext(2)">下一步</a>
            </div>
        </div>
        <div id="flowxq2" class="tab-content">
        	<table width="100%">
              <tr>
                <td width="10%" height="80" align="right" class="font16">天气：
                </td>
                <td width="51%">
                	<div class="select-box"  onclick="showtype(this,$('#divWeather'),'weather');">
                   	<span id="span_weather">晴天</span><i>&nbsp;</i></div>
					<input id="weather" name="weather" type="hidden"  value='晴天' />
                </td>
                <td width="39%" rowspan="3">
                    <div class="info">
                    <label>选择运动场景</label>
                    当环境湿度高时，功能性面料能迅速将汗水和湿气导离皮肤表面，保持皮肤干爽舒适，当环境温度低时，在保证透气排汗的同时，能保持体温。</div>
                </td>
              </tr>
              <tr>
                <td height="80" align="right" class="font16">温度：</td>
                <td>
                	<div role="slider" id="wendu">
                    	<div class="min"><font>-20</font>（摄氏度）</div>
                        <div class="max"><font>50</font>（摄氏度）</div>
						<input type="hidden" id="temperature" name="temperature" value="-20" >
                    </div>
                </td>
              </tr>
              <tr>
                <td height="80" align="right" class="font16">湿度：</td>
                <td>
                	<div role="slider" id="shidu">
                    	<div class="min"><font>0</font>（%）</div>
                        <div class="max"><font>100</font>（%）</div>
						<input type="hidden" id="humidity" name="humidity" value="0" >
                    </div>
                </td>
              </tr>
            </table>
            <div class="btns">
            	<a href="javascript:gonext(1)">上一步</a>
                <a href="javascript:gonext(3)">下一步</a>
            </div>
        </div>
        <div id="flowxq3" class="tab-content">
        	<table width="100%">
              <tr>
                <td width="10%" height="80" align="right" class="font16">对象：
                </td>
                <td width="51%">
                	<div class="radio-box">
                   		<span>男</span><span class="img male">&nbsp;</span><span>女</span>
						<input type="hidden" id="target" name="target" value="男" >
                    </div>
                </td>
                <td width="39%" rowspan="4">
                    <div class="info">
                    <label>选择着装对象</label>
                    不同的运动个体排汗，发热，身体代谢率有着明显的差异，合适的功能性服装能使人体保持干爽，调节体温，防止运动损伤。</div>
                </td>
              </tr>
              <tr>
                <td height="80" align="right" class="font16">熟练度：</td>
                <td>
                	<div role="slider" id="shulian">
                    	<div class="min"><font>0</font>（初学者）</div>
                        <div class="max"><font>10</font>（运动达人）</div>
						<input type="hidden" id="proficiency" name="proficiency" value="0">
                    </div>
                </td>
              </tr>
              <tr>
                <td height="80" align="right" class="font16">年龄：</td>
                <td>
                	<div role="slider" id="nianling">
                    	<div class="min"><font>8</font></div>
                        <div class="max"><font>70</font></div>
						<input type="hidden" id="age" name="age"  value="8">
                    </div>
                </td>
              </tr>
              <tr>
                <td height="80" align="right" class="font16">体重：</td>
                <td>
                	<div role="slider" id="tizhong">
                    	<div class="min"><font>20</font>（KG）</div>
                        <div class="max"><font>150</font>（KG）</div>
						<input type="hidden" id="weight" name="weight" value="20" >
                    </div>
                </td>
              </tr>
            </table>
            <div class="btns">
            	<a href="javascript:gonext(2)">上一步</a>
                <a href="javascript:gonext(4)">下一步</a>
            </div>
        </div>
        <div id="flowxq4" class="tab-content">
        	<table width="95%">
              <tr>
                <td height="67" class="font16">您是否还有其他的需求补充：
                </td>
                <td width="39%" rowspan="2">
                    <div class="info">
                    <label></label>
                    </div>
                </td>
              </tr>
              <tr>
                <td height="185" valign="top">
                	<textarea id="title" name="title"></textarea>
                </td>
              </tr>
            </table>
            <div class="btns">
            	<a href="javascript:gonext(3)">上一步</a>
            	<a class="black" href="#" onclick="javascript:if(confirm('确定要发布需求吗？')){publishok();}">提交</a>
            </div>
      </div>
      <div id="flowxq5" class="tab-content">
        	<!-- <div class="submin-info">
            	<img src="<?php echo $base.'img/wc_xtb.png';?>" />
                <strong>成功</strong>
                <span> </span><span>提交时间：2014-05-15</span>
                <p>详细情况请点击<a href="#" >查看详情</a></p>
            </div>
            <div class="other_title">
            	相关设计产品
            </div>
            <ul class="others">
            	<li class="start"><a href="#"><img src="<?php echo $base.'img/xqlc_yifu.png';?>" /></a></li>
                <li><a href="#"><img src="<?php echo $base.'img/xqlc_yifu.png';?>" /></a></li>
                <li><a href="#"><img src="<?php echo $base.'img/xqlc_yifu.png';?>" /></a></li>
                <li><a href="#"><img src="<?php echo $base.'img/xqlc_yifu.png';?>" /></a></li>
                <li><a href="#"><img src="<?php echo $base.'img/xqlc_yifu.png';?>" /></a></li>
                <li class="end"><a href="#"><img src="<?php echo $base.'img/xqlc_yifu.png';?>" /></a></li>
            </ul> -->
      </div>
    </div>
  </div>





<!------------ 底部开始 ------------->
<?php include("footer.php"); ?>

<div id="divType" style="display:none; position:absolute;background-color:#eeffdd; border:1px solid #BEC0BF;padding:5px;font-size:12px;">
	<img src="<?php echo $base.'img/sport1.jpg';?>" alt="户外山地运动" />
	<img src="<?php echo $base.'img/sport2.jpg';?>" alt="健身运动" />
	<img src="<?php echo $base.'img/sport3.jpg';?>" alt="羽毛球" />
	<img src="<?php echo $base.'img/sport4.jpg';?>" alt="跑步" />
	<img src="<?php echo $base.'img/sport5.jpg';?>" alt="步行" />
	<img src="<?php echo $base.'img/sport6.jpg';?>" alt="游泳" />
	<img src="<?php echo $base.'img/sport7.jpg';?>" alt="水上运动" />
	<img src="<?php echo $base.'img/sport8.jpg';?>" alt="自行车运动" />
	<img src="<?php echo $base.'img/sport9.jpg';?>" alt="轮滑运动" />
	<img src="<?php echo $base.'img/sport10.jpg';?>" alt="高尔夫" />
	<img src="<?php echo $base.'img/sport11.jpg';?>" alt="篮球" />
	<img src="<?php echo $base.'img/sport12.jpg';?>" alt="滑雪运动" />
	<img src="<?php echo $base.'img/sport13.jpg';?>" alt="马术" />
	<img src="<?php echo $base.'img/sport14.jpg';?>" alt="钓鱼" />
	<img src="<?php echo $base.'img/sport15.jpg';?>" alt="狩猎运动" />
	<img src="<?php echo $base.'img/sport16.jpg';?>" alt="目标运动" />
     <br>   <span  class="btn primary"  style="width:30px;height:20px; text-align:center;cursor:pointer;" onclick="hidetype($('#divType'));">关闭</span>
</div>

<div id="divWeather" style="display:none;width:300px; position:absolute;background-color:#eeffdd; border:3px solid #BEC0BF;padding:5px;font-size:12px;">
	<img src="<?php echo $base.'img/weather1.png';?>" style="width:70px;height:70px;" alt="下雨" />
	<img src="<?php echo $base.'img/weather2.png';?>" style="width:70px;height:70px;" alt="刮风" />
	<img src="<?php echo $base.'img/weather3.png';?>" style="width:70px;height:70px;" alt="晴天" />
	<img src="<?php echo $base.'img/weather4.png';?>" style="width:70px;height:70px;" alt="下雪" />
	<img src="<?php echo $base.'img/weather5.png';?>" style="width:70px;height:70px;" alt="小雪" />
	<img src="<?php echo $base.'img/weather6.png';?>" style="width:70px;height:70px;" alt="小雨" />
	<img src="<?php echo $base.'img/weather7.png';?>" style="width:70px;height:70px;" alt="雨雪" />
	<img src="<?php echo $base.'img/weather8.png';?>" style="width:70px;height:70px;" alt="阴天" />
     <br>   <span  class="btn primary"  style="width:30px;height:20px; text-align:center;cursor:pointer;" onclick="hidetype($('#divWeather'));">关闭</span>
</div>


<div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" onclick="$('#msg_modal').addClass('hide');" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').addClass('hide');">确定</button></div>
</div>


</div>
</body>
<script type="text/javascript" >
function publishok()
{
	var data = new Array();
	var hint = '';
	data['type'] = $('#type').val();
	data['strength'] = $('#strength').val();
	data['sporttime'] = $('#sporttime').val();
	data['weather'] = $('#weather').val();
	data['temperature'] = $('#temperature').val();
	data['humidity'] = $('#humidity').val();
	data['target'] = $('#target').val();
	data['proficiency'] = $('#proficiency').val();
	data['age'] = $('#age').val();
	data['weight'] = $('#weight').val();
	data['title'] = $('#title').val();

	if(data['title']=='') hint=hint+'请输入对需求的描述<br/>';
	if(hint!=''){
		$('.modal-body').html(hint);
		$('#msg_modal').removeClass("hide");;
		return;
	}

	var post_str = generate_query_str(data);
	var url = $('#base').val() + 'demand/pubok/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		if(html=='1'){
			//alert('需求描述已存在，请重新输入');
			$('.modal-body').html('需求描述已存在，请重新输入');
			$('#msg_modal').removeClass("hide");
			$('#msg_modal').show();
		}else{
			$("#flowxq5").html(html);
			$(".tab-content.active").removeClass("active");
			$("#flowxq5").addClass("active");
		}
	}};
	jQuery.ajax(ajax);
	
	//setTimeout("window.location.href=$('#base').val() + 'demand/products/?"+post_str+"'",200);
	//window.location.href=$('#base').val() + 'demand/demandlist/';
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
</html>

