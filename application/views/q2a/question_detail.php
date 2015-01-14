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




  <div id="qa4" class="main">
	<div class="info">
    	<ul class="tabs">
			<li class="active">运动<i></i></li>
			<li class="active">跑步<i></i></li>
            <li class="active">服装搭配<i></i></li>
            <li class="active">服装设计<i></i></li>
        </ul>
        <span class="title">您的问题是：</span>
        <p>
        	<?php echo $q_data['text'];?>
        </p>
		<input type="hidden" id="question_id" name="question_id" value="<?php echo $q_data['nId']; ?>"/>
    </div>
    <div class="qa-lists">
        	<h3 class="list_title"><?php echo count($reply);?>个回答<a href="#" class="pull-right">按票数顺序<img class="pull-right" src="<?php echo $base.'img/xtb_006.png'?>" /></a></h3>
        	<div class="panel">
                  <div class="panel-body">
                    <ul class="main-list">
						<?php foreach($reply as $item): ?>
                    	<li>
                        	<img class="header" src="<?php echo $base.'img/'.$item['answer']['avatar'];?>" /><span class="text-orange"><?php echo $item['answer']['text'];?></span>
                            <p><?php echo $item['answer']['text'];?></p>
                            <p class="bottom">
                                <font class="view">关注问题</font>
                    			<font class="message">3条评论</font>
                                <font class="icon-clock pull-right">发布于<?php echo $item['answer']['time'];?></font>
                            </p>
                        </li>
						<?php endforeach; ?>
                    </ul>
            	</div>
        </div>
        <h3 class="list_title">我来回答这个问题</h3>
        <textarea class="textarea"  id="answer_input_area" style="width: 100%; height:107px;">
        写回答...
		</textarea>
        <div class="input-footer">
             <label for="niming"><input type="checkbox" id="niming" />匿名</label>
             <a href="#" id="answer_btn" onclick="answer_process();" data-loading-text="请稍后..." class="btn-more">我要回答</a>
        </div>
    </div>
  </div>




    <?php include("footer.php"); ?>

	
	<input type="hidden" id="base" value="<?php echo $base; ?>" />
	<div id="msg_modal" class="modal hide">
		<div class="modal-header"><a href="#" onclick="$('#msg_modal').hide();" class="close">&times;</a><h3>&nbsp;</h3></div>
		<div class="modal-body"></div>
		<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
</div>
</body>
<script src="<?php echo $base.'js/question_detail.js';?>"></script>
</html>   
    
