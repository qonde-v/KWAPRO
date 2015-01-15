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


	  <div id="qa1" class="main">
  <div class="outer">
  	<div class="left">
        <div class="info">
                <img class="pull-left" src="<?php echo $base.$user_info['headphoto_path'];?>" />
                <span>您搜索的内容是：</span>
                <p><?php echo isset($keyword)?$keyword: ""; ?></p>
            
        </div>
        <div class="info-bottom">
            下面的信息没有给您带来帮助，您可以直接点击提问按钮进行问题的咨询
            <a href="#"  id="question_submit" class="btn">提　问</a>
        </div>
    </div>
    <div class="right">
    	<h1>熟悉该内容的用户</h1>
    	<ul>
        	<li>
            	<img src="images/xiugai_tp_010.png" />
                <label>test</label>
                <p>1问题</p>
                <p>0回答</p>
            </li>
            <li>
            	<img src="images/xiugai_tp_010.png" />
                <label>test</label>
                <p>1问题</p>
                <p>0回答</p>
            </li>
            <li>
            	<img src="images/xiugai_tp_010.png" />
                <label>test</label>
                <p>1问题</p>
                <p>0回答</p>
            </li>
            <li>
            	<img src="images/xiugai_tp_010.png" />
                <label>test</label>
                <p>1问题</p>
                <p>0回答</p>
            </li>
        </ul>
       	</div>
    </div>
    <div class="qa-lists">
        	<div class="panel">
            	<div class="panel-heading black">相关问题与回复（3）
                	<ul>
                    	<li><a href="#">相关知识（2）</a></li>
                        <li><a href="#">来自站内需求/设计库（3）</a></li>
                        <li><a href="#">网上参考信息（5）</a></li>
                    </ul>
                	<a href="#" class="pull-right"><img src="<?php echo $base.'img/xtb_006.png'?>" /></a>
                </div>
                  <div class="panel-body">
                    <ul class="main-list">
                    	<?php if(!empty($mashup_data) && isset($mashup_data['data'])):
						foreach($mashup_data['data'] as $item): 
						if($item['type_string'] == $type_arr[$i]): 
						?>                                            
                    	<li>
                        	<a href="<?php echo $item['url']; ?>" class="title"><?php echo $item['desc']; ?></a>
                            <p>留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言留言</p>
                            <p class="bottom">
                            	<img class="pull-left" src="images/geren_tx.png" /><span class="text-orange">111</span>
                            	<font class="icon-clock">发布于2014-10-03</font>
                                <font class="view">查看数（28）</font>
                    			<font class="design">回答数（4）</font>
                            </p>
                        </li>
						<?php 
						endif;
						endforeach; 
						endif;
						?>
                    </ul>
                    <div class="panel-footer">
                    	<a href="#" class="btn-more">更多问题</a>
                    </div>
            	</div>
        </div>
    </div>
  </div>


 	<input type="hidden" value="<?php echo $base; ?>" id="header_base" />     
    	
<?php include("footer.php"); ?>


</div>
</body>

    <script src="<?php echo $base.'js/question_asking_process.js';?>"></script>    
    <script src="<?php echo $base.'js/kwapro_search.js';?>" ></script> 
   <script>
	$(function() {
		question_ask_process({submit_id:'question_submit',expert_cname:'experts',text_id:'question_text',tag_id:'keyword', finish_tips:'<?php echo $asking_finish_tip;?>', base:'<?php echo $base; ?>'});
	});
   </script>
</html>   
    