<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/data_picker.css';?>" />
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<script src="<?php echo $base.'js/jquery-ui.min.js';?>" type="text/javascript"></script>
<script src="<?php echo $base.'js/DatePicker.js';?>"></script>
<script src="<?php echo $base.'js/setting.js';?>"></script>
<script type="text/javascript">
	$(function(){
		$(".radio").click(function(){
			var name = $(this).attr("name");
			if($(".radio[name="+name+"]").size() > 1){
				$(this).siblings(".radio-checked").removeClass("radio-checked");
				$(this).addClass("radio-checked");
				$('#gender').val($(this).attr('value'));
			}
			else{
				$(this).toggleClass("radio-checked");
			}
		});
		$("#pwbtn").click(function(){
			if($(this).hasClass("radio-checked")){
				document.getElementById("name").type="password"; 
				//$(this).prev().attr("type","password");
			}
			else{
				document.getElementById("name").type="text"; 
				//$(this).prev().attr("type","text");
			}
		});
		$(".tabs li").click(function(){
			$(this).toggleClass("active");
			var tag = $('#tag').val();
			var i = $(this).text();
			if($(this).hasClass("active")){
				tag = tag + ' ' + i;
			}else{
				tag = tag.replace(' ' + i,'')
			}
			$('#tag').val(tag);
		});

	});

function reset(){
	$('#nickname').val('');
	$('#realname').val('');
	$('#old_password').val('');
	$('#new_password').val('');
	$('#new_passwordc').val('');
	$('#email').val('');
	$('#qq').val('');
	$('#birthday').val('');
	$('#address').val('');
	$('#address_now').val('');
	$('#tel').val('');
	$('#age').val('');
	$('#school').val('');
	$('#description').val('');
}


</script>
</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->
<input type="hidden" id="base" value="<?php echo $base;?>">
  <div id="personalSpaceImg" class="main">
	<ul class="breadcrumb">
    	<li><a href="<?php echo $base.'demand'?>">个人空间</a></li>
        <li>&gt;</li>
        <li><a href="#">修改个人资料</a></li>
        <li class="pull-right"><a href="<?php echo $base.'demand'?>">返回</a></li>
    </ul>
    <div class="wrap gray">
    	<div class="warp_title">资料卡</div>
        <div class="warp_body">
        	<table width="100%" border="0" class="edit_table">
              <tbody>
                <tr>
                  <td width="12%">昵称：</td>
                  <td width="38%"><input id="nickname" type="text" value="<?php echo $nickname;?>"/></td>
                  <td width="12%">性别：</td>
                  <td width="38%">
                  	<div class="input-group">
                    	<div class="radio <?php if($gender == 1){echo "radio-checked";} ?>" name="sex" value="1">男</div>
                        <div class="radio <?php if($gender == 0){echo "radio-checked";} ?>" name="sex" value="0">女</div>
						<input type="hidden" id="gender" value="<?php echo $gender;?>">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>姓名：</td>
                  <td>
                  	<div class="input-group">
                  		<input id="realname" type="text"  value="<?php echo $realname;?>"/><div class="radio" id="pwbtn">保密</div>
                    </div>
                    </td>
                  <td>生日：</td>
				  <input id="day_name_str" type="hidden" value="<?php for($i=0;$i<7;$i++){echo $day_name[$i];if($i<6)echo ",";}?>">
				  <input id="month_name_str" type="hidden" value="<?php for($i=0;$i<12;$i++){echo $month_name[$i];if($i<11)echo ",";}?>">
                  <td><input id="birthday" type="text" value="<?php echo $birthday;?>"/></td>
                </tr>
                <tr>
                  <td>年龄：</td>
                  <td><input type="text" id="age"  value="<?php echo $age;?>"/></td>
                  <td>现居城市：</td>
                  <td><input type="text" id="address_now"  value="<?php echo $address_now;?>"/></td>
                </tr>
                <tr>
                  <td>手机：</td>
                  <td><input type="text" id="tel" value="<?php echo $tel;?>"/></td>
                  <td>家乡城市：</td>
                  <td><input type="text" id="address" value="<?php echo $address;?>"/></td>
                </tr>
                <tr>
                  <td>毕业院校：</td>
                  <td colspan="3"><input type="text" id="school"  value="<?php echo $school;?>"/></td>
                </tr>
                <tr>
                  <td>邮箱：</td>
                  <td><input type="text" id="email"  value="<?php echo $email;?>"/></td>
                  <td>QQ：</td>
                  <td><input type="text" id="qq" value="<?php echo $qq;?>"/></td>
                </tr>
                <tr>
				  <input type="hidden" id="tag" value="<?php echo $tag;?>">
                  <td valign="top">标签：</td>
                  <td colspan="3"> 
                  	<ul class="tabs">
                    	<li <?php if(strpos($tag,"户外山地运动") > 0){ echo "class='active'";}?>>户外山地运动<i></i></li>
                        <li <?php if(strpos($tag,"自行车运动") > 0){ echo "class='active'";}?>>自行车运动<i></i></li>
                        <li <?php if(strpos($tag,"跑步") > 0){ echo "class='active'";}?>>跑步<i></i></li>
                        <li <?php if(strpos($tag,"水上运动") > 0){ echo "class='active'";}?>>水上运动<i></i></li>
                        <li <?php if(strpos($tag,"游泳") > 0){ echo "class='active'";}?>>游泳<i></i></li>
                        <li <?php if(strpos($tag,"健身运动") > 0){ echo "class='active'";}?>>健身运动<i></i></li>
                        <li <?php if(strpos($tag,"目标运动") > 0){ echo "class='active'";}?>>目标运动<i></i></li>
                        <li <?php if(strpos($tag,"步行") > 0){ echo "class='active'";}?>>步行<i></i></li>
                        <li <?php if(strpos($tag,"滑轮") > 0){ echo "class='active'";}?>>滑轮<i></i></li>
                        <li <?php if(strpos($tag,"钓鱼") > 0){ echo "class='active'";}?>>钓鱼<i></i></li>
                        <li <?php if(strpos($tag,"羽毛球") > 0){ echo "class='active'";}?>>羽毛球<i></i></li>
                        <li <?php if(strpos($tag,"网球") > 0){ echo "class='active'";}?>>网球<i></i></li>
                        <li <?php if(strpos($tag,"高尔夫") > 0){ echo "class='active'";}?>>高尔夫<i></i></li>
                        <li <?php if(strpos($tag,"狩猎运动") > 0){ echo "class='active'";}?>>狩猎运动<i></i></li>
                        <li <?php if(strpos($tag,"排球") > 0){ echo "class='active'";}?>>排球<i></i></li>
                        <li <?php if(strpos($tag,"马术") > 0){ echo "class='active'";}?>>马术<i></i></li>
                        <li <?php if(strpos($tag,"滑雪") > 0){ echo "class='active'";}?>>滑雪<i></i></li>
                        <li <?php if(strpos($tag,"足球") > 0){ echo "class='active'";}?>>足球<i></i></li>
                        <li <?php if(strpos($tag,"乒乓球") > 0){ echo "class='active'";}?>>乒乓球<i></i></li>
                        <li <?php if(strpos($tag,"篮球") > 0){ echo "class='active'";}?>>篮球<i></i></li>
						<li <?php if(strpos($tag,"服装设计") > 0){ echo "class='active'";}?>>服装设计<i></i></li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td>简介：</td>
                  <td colspan="3"><input type="text" id="description" value="<?php echo $description;?>"/></td>
                </tr>
                <tr>
                  <td>旧密码：</td>
                  <td>
                  	<div class="input-group">
                  		<input id="old_password" type="password" />
                    </div>
                  </td>
				</tr>
                <tr>
				  <td>新密码：</td>
                  <td>
                  	<div class="input-group">
                  		 <input id="new_password" type="password" />
                    </div>
                  </td>

				  <td>确认密码：</td>
				  <td>
                  	<div class="input-group">
                  		<input id="new_passwordc" type="password" />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="btns">
                <a href="#" onclick="javascript:reset();">重&nbsp;置</a>
                <a href="#"  onclick="javascript:basic_info_save();" id="basic_save_btn" class="black">保&nbsp;存</a>
              </div>
        </div>
    </div>
     
  </div>

<div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" onclick="$('#msg_modal').addClass('hide');" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').addClass('hide');">确定</button></div>
</div>

	<?php include("footer.php");?>

  </div>
  </body>
</html>   
    
