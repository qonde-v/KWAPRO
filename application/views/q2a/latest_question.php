<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script src="<?php echo $base.'js/jquery.min.js';?>" type="text/javascript"></script>

</head>
<div class="container">
<?php include("header.php"); ?>


  <div id="qa2" class="main">
	<div class="info">
    	<div class="left">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td rowspan="2"><img class="user-head" src="<?php echo $base.$user_info['headphoto_path'];?>" /></td>
                <td width="93px" style="padding-top:10px;"><span class="user-name <?php if($user_info['gender']==1)echo 'male';else echo 'female';?>"><?php echo $user_info['username']; ?></span></td>
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
        		<div class="panel-heading black">最新问题<input type="text" placeholder="搜索休闲服装知识、动态" /><a href="#" class="pull-right"><img src="<?php echo $base.'img/xtb_006.png'?>" /></a></div>
                  <div class="panel-body">
                    <ul class="main-list">
						<?php foreach($question_view as $item):?>
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
            </div>
        </div>
    </div>
  </div>

  <?php include("footer.php"); ?>
</div>
</body>
</html>
