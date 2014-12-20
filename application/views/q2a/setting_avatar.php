<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/data_picker.css';?>" />
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>

<script type="text/javascript">
$(document).ready(function() {
	$(".heads li").click(function(){
		//var li = $(this).parent();
		if(!$(this).hasClass("active")){
			$(".heads li.active").removeClass("active");
			$(this).addClass("active");
			$('#avatar').attr('src',$(this).find('img').attr('src'));
		}
	});
});

function savepic(){
	var url = $('#base').val() + 'profile/saveavatar/';
	var post_str = 'avatar='+getFileName($('#avatar').attr('src'));
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#msg_modal .modal-body').html(html);
		$('#msg_modal').removeClass("hide");
		$('#msg_modal').show();
		setTimeout("window.location.reload()",100);
	}};
	jQuery.ajax(ajax);
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
<input type="hidden" id="base" value="<?php echo $base;?>">
  <div id="personalSpaceImg" class="main">
	<ul class="breadcrumb">
    	<li><a href="<?php echo $base.'demand';?>">个人空间</a></li>
        <li>&gt;</li>
        <li><a href="#">修改个人头像</a></li>
        <li class="pull-right"><a href="<?php echo $base.'demand';?>">返回</a></li>
    </ul>
    <div class="wrap gray">
    	<div class="warp_title">修改头像</div>
        <div class="warp_body" style="overflow:auto;">
        	<div class="col-5">
            	<div>选择头像</div>
                <ul class="heads">
                	<li class="active"><img src="<?php echo $base.'img/xiugai_tp_001.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_002.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_003.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_004.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_005.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_006.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_007.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_008.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_009.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_010.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_011.png'?>" /></li>
                    <li><img src="<?php echo $base.'img/xiugai_tp_012.png'?>" /></li>
                </ul>
            </div>
            <div class="col-7">
            	<div class="heads-main">
                	<span class="info">选择您喜欢的图片作为个人头像，以下为预览窗口，<br />选择满意的图片后，记得保存哦。</span>
                    <div class="heads-row">
                    	<div class="col-6">
                        	<label>当前头像</label>
                            <img src="<?php echo $base.'img/'.$avatar;?>" />
                        </div>
                        <div class="col-6">
                        	<label>预览窗口</label>
                            <img id="avatar" src="<?php echo $base.'img/xiugai_tp_001.png'?>" />
                        </div>
                    </div>
                    <div class="btns">
                        <!-- <a href="#">取&nbsp;消</a> -->
                        <a href="javascript:;" onclick="javascript:savepic();" class="black">保&nbsp;存</a>
                     </div>
                 </div>
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
    
