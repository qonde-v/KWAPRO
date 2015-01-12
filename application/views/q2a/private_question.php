<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script src="<?php echo $base.'js/jquery.min.js';?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {

	$(".tab-btns li a").click(function(){
		$(".tab-btns li a").removeClass("active");
		$(this).addClass("active");
		if($(this).attr("id") == "tw"){
			$("#asked").show();
			$("#answered").hide();
		}
		else{
			$("#asked").hide();
			$("#answered").show();
		}
	});
});
</script>
</head>
<div class="container">
<?php include("header.php"); ?>

  <div id="qa2" class="main">
	<div class="info">
    	<div class="left">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td rowspan="2"><img class="user-head" width="133px" height="133px" src="<?php echo $base.$user_info['headphoto_path'];?>" /></td>
                <td width="93px"  style="padding-top:10px;"><span class="user-name <?php if($user_info['gender']==1)echo 'male';else echo 'female';?>"><?php echo $user_info['username']; ?></span></td>
              </tr>
              <tr>
                <td valign="top" style="padding-left:10px;"><span class="qa">3&nbsp;问题<br />
                5&nbsp;回答</span></td>
              </tr>
            </table>
        </div>
      <div class="right"><img src="<?php echo $base.'img/xiugai_d_0'.$user_info['subpic'].'.png';?>" /></div>
    </div>
    <div class="qa-lists">
    	<div class="left">
        	<h3 class="list_title">在线用户</h3>
            <ul class="onlinelists">
			<?php foreach($online_friend as $friend_item): ?>
				<li>
                	<img class="online_user_image"  src="<?php echo $base.$friend_item['headphoto_path'];?>" />
                    <span><strong><?php echo $friend_item['username'];?></strong></span>
                    <span><?php echo $friend_item['question_num'];?>&nbsp;问题</span>
                    <span><?php echo $friend_item['answer_num'];?>&nbsp;回答</span>
                </li>
			<?php endforeach; ?> 
            </ul>
        </div>
        <div class="right">
        	<div class="panel">
        		<div class="panel-heading black relative">
                	<ul class="tab-btns">
                		<li><a href="#" class="active" id="tw">我提问的</a></li>
                        <li><a href="#" class="">我回答的</a></li>
                     </ul>
                	<a href="#" class="pull-right"><img src="<?php echo $base.'img/xtb_006.png'?>" /></a>
                </div>
                <div class="panel-body"  id="asked">
                    <ul class="main-list">
						<?php foreach($my_asked_question as $item):?>
                    	<li>
                        	<a href="<?php echo $base.'question/'.$item['nId'];?>" class="title"><?php echo $item['text'];?></a>
                            <p><?php echo $item['text'];?></p>
                            <p class="bottom">
                            	<img class="pull-left" src="<?php echo $base.'img/'.$item['avatar'];?>" /><span class="text-orange"><?php echo $item['username'];?></span>
                            	<font class="icon-clock">发布于<?php echo $item['time'];?></font>
                                <font class="view">查看数（<?php echo $item['question_view_num'];?>）</font>
                    			<font class="design">回答数（<?php echo $item['question_answer_num'];?>）</font>
                            </p>
                        </li>
						<?php endforeach;?>
                    </ul>
                    <div class="panel-footer">
                    	<a href="#" class="btn-more">更多问题</a>
                    </div>
            	</div>
				<div class="panel-body"  id="answered" style="display:none;">
                    <ul class="main-list">
						<?php foreach($my_answered_question as $item):?>
                    	<li>
                        	<a href="#" class="title"><?php echo $item['text'];?></a>
                            <p><?php echo $item['text'];?></p>
                            <p class="bottom">
                            	<img class="pull-left" src="<?php echo $base.'img/'.$item['avatar'];?>" /><span class="text-orange"><?php echo $item['username'];?></span>
                            	<font class="icon-clock">发布于<?php echo $item['time'];?></font>
                                <font class="view">查看数（<?php echo $item['question_view_num'];?>）</font>
                    			<font class="design">回答数（<?php echo $item['question_answer_num'];?>）</font>
                            </p>
                        </li>
						<?php endforeach;?>
                    </ul>
                    <div class="panel-footer">
                    	<a href="#" class="btn-more">更多问题</a>
                    </div>
            	</div>

            </div>
        </div>
    </div>
  </div>


 
   <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
  </body>

	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
</html>   
    