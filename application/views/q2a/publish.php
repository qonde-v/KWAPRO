<html>
<head>
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">

<link rel="stylesheet" href="<?php echo $base.'css/jquery-ui.css';?>">
<script src="<?php echo $base.'js/jquery-1.10.2.js';?>"></script>
<script src="<?php echo $base.'js/jquery-ui.js';?>"></script>
<script>
$(function() {
$( "#slider" ).slider({
value:1.2,
min: 1,
max: 1.5,
step: 0.1,
slide: function( event, ui ) {
$( "#strength" ).val(ui.value );
}
});
$( "#strength" ).val($( "#slider" ).slider( "value" ) );


$( "#slider1" ).slider({
value:1,
min: 0,
max: 2,
step: 0.1,
slide: function( event, ui ) {
$( "#sporttime" ).val(ui.value );
}
});
$( "#sporttime" ).val($( "#slider1" ).slider( "value" ) );

$( "#slider2" ).slider({
value:20,
min: 0,
max: 50,
step: 1,
slide: function( event, ui ) {
$( "#temperature" ).val(ui.value );
}
});
$( "#temperature" ).val($( "#slider2" ).slider( "value" ) );


$( "#slider3" ).slider({
value:20,
min: 0,
max: 100,
step: 1,
slide: function( event, ui ) {
$( "#humidity" ).val(ui.value );
}
});
$( "#humidity" ).val($( "#slider3" ).slider( "value" ) );

$( "#slider4" ).slider({
value:35,
min: 0,
max: 100,
step: 1,
slide: function( event, ui ) {
$( "#proficiency" ).val(ui.value );
}
});
$( "#proficiency" ).val($( "#slider4" ).slider( "value" ) );

$( "#slider5" ).slider({
value:30,
min: 10,
max: 70,
step: 1,
slide: function( event, ui ) {
$( "#age" ).val(ui.value );
}
});
$( "#age" ).val($( "#slider5" ).slider( "value" ) );

$( "#slider6" ).slider({
value:60,
min: 20,
max: 150,
step: 1,
slide: function( event, ui ) {
$( "#weight" ).val(ui.value );
}
});
$( "#weight" ).val($( "#slider6" ).slider( "value" ) );

});
</script>

<script type="text/javascript">
	var onFocusID = "";
	  function showtype(obj,obj_d)
	  {
		jQuery(obj_d).css("left",jQuery(obj).offset().left);
		jQuery(obj_d).css("top",jQuery(obj).offset().top+jQuery(obj).outerHeight());
		jQuery(obj_d).css("z-index",3);
		jQuery(obj_d).show();
		onFocusID = obj.id;
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
						this.checked = "";
					}
					$("#divWeather").hide();
				});
			});
	   });

</script>
<script>
function gonext(bz){
	var ob;
	for(i=1;i<=4;i++){
		ob=document.getElementById('buzhou'+i);
		ob1=document.getElementById('xuqiu'+i);
		if(i==bz){
			ob.style.display='';
			ob1.className='xuqiu_bz1';
		}
		else{
			ob.style.display='none';
			ob1.className='xuqiu_bz2';
		}
	}

}
</script>

</head>
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 

<input type="hidden" id="base" value="<?php echo $base;?>"></input>

<div id="main">
<div id="main_nr">
<div id="index_qp">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">需 &nbsp;&nbsp; 求</div><br>
<br>

<div id="xuqiu1" class="xuqiu_bz1"><a href="#" onclick="javascript:gonext(1)" class="White14">1.选择运动类型</a></div>
<div class="xuqiu_bz_jt"></div>
<div id="xuqiu2" class="xuqiu_bz2"><a href="#" onclick="javascript:gonext(2)" class="White14">2.选择运动场景</a></div>
<div class="xuqiu_bz_jt"></div>
<div id="xuqiu3" class="xuqiu_bz2"><a href="#" onclick="javascript:gonext(3)" class="White14">3.选择着装对象</a></div>
<div class="xuqiu_bz_jt"></div>
<div id="xuqiu4" class="xuqiu_bz2"><a href="#" onclick="javascript:gonext(4)" class="White14">4.提交需求</a></div>

<div class="index_l_xwnrx" style="padding-left:100px; margin-top:50px; margin-bottom:100px;">
<div id="buzhou1" style="float:left; width:550px;" >
	<div class="index_l_xqnr">
	<b>类型： </b> 
	<input id="type" name="type" type="text" style="background:transparent;border:1px solid #000000; height:30px; width:350px; padding-top:5px;" onfocus="showtype(this,$('#divType'));" value='跑步' />
	<!-- <select id="type" name="type" > 
		<option selected value='跑步'>跑步</option>
		<option  value='骑车'>骑车</option>
		<option  value='篮球'>篮球</option>
		<option  value='足球'>足球</option>
	</select> -->
	</div>
	<div class="index_l_xqnr">
	<b>强度：</b> 
	<font size="2" color="f6931f">1(轻松)</font>
	<div id="slider" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">1.5(激烈)</font>
	<input type="hidden" id="strength"  name="sporttime" >
	</div>
	<div class="index_l_xqnr">
	<b>时间： </b>  
	<font size="2" color="f6931f">0Hour</font>
	<div id="slider1" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">2Hour</font>
	<input type="hidden" id="sporttime"  name="sporttime">
	</div>
	<div class="index_l_xqnr" style="width:150px">
	<div class="red_bt15" style="width:45px;text-align:center;float:right"><a href="#" onclick="javascript:gonext(2)" class="White14">下一步</a></div>
	</div>
</div>
<div id="buzhou2" style="float:left; width:550px;display:none">
	<div class="index_l_xqnr">
	<b>天气： </b>  
	<input id="weather" name="weather" type="text" style="background:transparent;border:1px solid #000000; height:30px; width:300px; padding-top:5px;" onfocus="showtype(this,$('#divWeather'));" value='晴天' />
	<!-- <select id="weather" name="weather" > 
		<option selected value='晴天'>晴天</option>
		<option  value='多云'>多云</option>
		<option  value='小雨'>小雨</option>
		<option  value='阴天'>阴天</option>
	</select> -->
	</div>
	<div class="index_l_xqnr">
	<b>温度：</b> 
	<font size="2" color="f6931f">0</font>
	<div id="slider2" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">50</font>
	<input type="hidden" id="temperature" name="temperature"  >
	</div>
	<div class="index_l_xqnr">
	<b>湿度： </b>  
	<font size="2" color="f6931f">0</font>
	<div id="slider3" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">100</font>
	<input type="hidden" id="humidity" name="humidity" >
	</div>

	<div class="index_l_xqnr" style="width:150px">
	<div class="red_bt15" style="width:45px;text-align:center;float:left"><a href="#" onclick="javascript:gonext(1)" class="White14">上一步</a></div>
	<div class="red_bt15" style="width:45px;text-align:center;float:right"><a href="#" onclick="javascript:gonext(3)" class="White14">下一步</a></div>
	</div>

</div>	

<div id="buzhou3" style="float:left; width:550px;display:none">
	<div class="index_l_xqnr">
	<b>性别： </b> 
	<input type="radio" id="target" name="target" value="男" checked="checked" style="margin-left:10px" /> 男
	<input type="radio" id="target" name="target" value="女" style="margin-left:20px" /> 女
	</div>
	<div class="index_l_xqnr">
	<b>熟练度：</b> 
	<font size="2" color="f6931f">0(初学者)</font>
	<div id="slider4" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">100(运动达人)</font>
	<input type="hidden" id="proficiency" name="proficiency" >
	</div>
	<div class="index_l_xqnr">
	<b>年龄：</b> 
	<font size="2" color="f6931f">10</font>
	<div id="slider5" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">70</font>
	<input type="hidden" id="age" name="age" >
	</div>
	<div class="index_l_xqnr">
	<b>体重：</b> 
	<font size="2" color="f6931f">20kg</font>
	<div id="slider6" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">150kg</font>
	<input type="hidden" id="weight" name="weight" >
	</div>
	<div class="index_l_xqnr" style="width:150px">
	<div class="red_bt15" style="width:45px;text-align:center;float:left"><a href="#" onclick="javascript:gonext(2)" class="White14">上一步</a></div>
	<div class="red_bt15" style="width:45px;text-align:center;float:right"><a href="#" onclick="javascript:gonext(4)" class="White14">下一步</a></div>
	</div>

</div>

<div id="buzhou4" style="float:left; width:550px;display:none">
	<div class="index_l_xqnr">
	<b>请一句话描述您的需求： </b> 
	<input id="title" style="background:transparent;border:1px solid #000000; height:30px; width:350px; padding-top:5px;"> 
	</div> 
	<div class="index_l_xqnr" style="width:150px">
	<div class="red_bt15" style="width:45px;text-align:center;float:left"><a href="#" onclick="javascript:gonext(3)" class="White14">上一步</a></div>
	<div class="red_bt15" style="width:45px;text-align:center;float:right"><a id="publish_button" href="#"  onclick="javascript:publishok()"class="White14">提交</a></div>
	</div>
</div>	

<div class="xuqiu_zhuyi" ><font class="fBlack14">不同运动对服装功能有不同的要求</font><br>
例如：篮球运动就需要突出排汗功能与透气性，<br>
而自行车则需要注重保护性，贴身性和舒服性
</div>		
</div>
	
</div>

</div>


</div>


<!------------ 底部开始 ------------->
<?php include("footer.php"); ?>

<div id="divType" style="display:none; position:absolute;background-color:#eeffdd; border:1px solid #BEC0BF;padding:5px;font-size:12px;">
	<img src="<?php echo $base.'img/sport1.jpg';?>" alt="户外山地运动" />
	<img src="<?php echo $base.'img/sport2.jpg';?>" alt="健身运动" />
	<img src="<?php echo $base.'img/sport3.jpg';?>" alt="羽毛球 网球 乒乓球" />
	<img src="<?php echo $base.'img/sport4.jpg';?>" alt="跑步" />
	<img src="<?php echo $base.'img/sport5.jpg';?>" alt="步行" />
	<img src="<?php echo $base.'img/sport6.jpg';?>" alt="游泳" />
	<img src="<?php echo $base.'img/sport7.jpg';?>" alt="水上运动" />
	<img src="<?php echo $base.'img/sport8.jpg';?>" alt="自行车运动" />
	<img src="<?php echo $base.'img/sport9.jpg';?>" alt="轮滑运动" />
	<img src="<?php echo $base.'img/sport10.jpg';?>" alt="高尔夫" />
	<img src="<?php echo $base.'img/sport11.jpg';?>" alt="篮球 足球 排球" />
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
	<img src="<?php echo $base.'img/weather5.png';?>" style="width:70px;height:70px;" alt="小雪转多云" />
	<img src="<?php echo $base.'img/weather6.png';?>" style="width:70px;height:70px;" alt="小雨转阴" />
	<img src="<?php echo $base.'img/weather7.png';?>" style="width:70px;height:70px;" alt="雨夹雪" />
	<img src="<?php echo $base.'img/weather8.png';?>" style="width:70px;height:70px;" alt="阴天" />
     <br>   <span  class="btn primary"  style="width:30px;height:20px; text-align:center;cursor:pointer;" onclick="hidetype($('#divWeather'));">关闭</span>
</div>
</body>
<script type="text/javascript" >
function publishok()
{
	var data = new Array();
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

	var post_str = generate_query_str(data);
	var url = $('#base').val() + 'demand/pubok/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){

	}};
	jQuery.ajax(ajax);
	setTimeout("window.location.href=$('#base').val() + 'demand/products/?"+post_str+"'",200);
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

