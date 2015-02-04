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

	$("#tab-btns li a").click(function(){
		$("#tab-btns li a").css("color","#000");
		$(this).css("color","#fff");
		li=$(this).parent();
		cur=li.index();
		for(i=0;i<5;i++){
			if(i==cur){
				$('#tab'+i).css("display","");
			}else{
				$('#tab'+i).css("display","none");
			}
		}
		/*if($(this).attr("id") == "tw"){
			$("#asked").show();
			$("#answered").hide();
		}
		else{
			$("#asked").hide();
			$("#answered").show();
		}*/
	});
});
</script>
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
				<p><input type="hidden" id="question_text" value="<?php echo isset($keyword)?$keyword: ""; ?>"/></p>
                <p><input type="hidden" id="keyword" value="<?php $tags= isset($mashup_data['tags'])?$mashup_data['tags']:array(); echo implode(',',$tags); ?>" /></p>
            
        </div>
        <div class="info-bottom">
            下面的信息没有给您带来帮助，您可以直接点击提问按钮进行问题的咨询
            <a href="#"  id="question_submit" class="btn">提　问</a>
        </div>
    </div>
    <div class="right">
    	<h1>熟悉该内容的用户</h1>
	 <?php if(!empty($expert_data)):?>
		<?php foreach($expert_data as $sc_id=>$subcate_expert_data): ?>
		   <div class="span3">
				<h6><?php echo $subcate_expert_data['subcate_name']; ?><?php echo $asking_area_label;?></h6>
				<ul class="media-grid">
					<?php foreach($subcate_expert_data['expert_data'] as $item): ?>
						<li>
							<a>
								  <img src="<?php echo $base.'img/expert_avatar/expert_'.$item['uId'].'.jpg'; ?>" alt=""/>
								  <input type="checkbox" style="margin-left:10px" name="experts" value="<?php echo 'expert_'.$item['uId']; ?>" checked/>
							</a>
						</li>
					 <?php endforeach; ?>
				</ul> 
			</div>
		<?php endforeach; ?>
	  
	  <?php else:?>
		   <?php echo $asking_no_expert_found; ?>  	
	  <?php endif; ?>
       	</div>
    </div>
    <div class="qa-lists">
        	<div class="panel">
            	<div class="panel-heading black">
                	<ul id='tab-btns'>
						<li><a href="#" style="color:#fff">相关问题与回复</a></li>
                    	<li><a href="#">相关知识</a></li>
                        <li><a href="#">来自站内需求库</a></li>
                        <li><a href="#">来自站内设计库</a></li>
						<li><a href="#">网上参考信息</a></li>
                    </ul>
                	<a href="#" class="pull-right"><img src="<?php echo $base.'img/xtb_006.png'?>" /></a>
                </div>
                  <div class="panel-body">
                    <ul class="main-list">
						<span id='tab0'>
                    	<?php if(!empty($mashup_data) && isset($mashup_data['data'])):
						foreach($mashup_data['data'] as $item): 
						if($item['type_string'] == 'Q'): 
						?> 
                    	<li>
                        	<a href="<?php echo $item['url']; ?>" class="title"><?php echo $item['desc']; ?></a>
                            <p><?php echo $item['desc']; ?></p>
                            <p class="bottom">
                            	<!-- <img class="pull-left" src="images/geren_tx.png" /><span class="text-orange"><?php echo $item['username']; ?></span> -->
                            	<font class="icon-clock">发布于<?php echo $item['time']; ?></font>
                                <!-- <font class="view">查看数（28）</font>
                    			<font class="design">回答数（4）</font> -->
                            </p>
                        </li>
						<?php 
						endif;
						endforeach; 
						endif;?>
						</span>

						<span id='tab1' style="display:none;">
                    	<?php if(!empty($mashup_data) && isset($mashup_data['data'])):
						foreach($mashup_data['data'] as $item): 
						if($item['type_string'] == 'N'): 
						?> 
                    	<li>
                        	<a href="<?php echo $item['url']; ?>" class="title"><?php echo $item['desc']; ?></a>
                            <p><?php echo $item['desc']; ?></p>
                            <p class="bottom">
                            	<!-- <img class="pull-left" src="images/geren_tx.png" /><span class="text-orange"><?php echo $item['username']; ?></span> -->
                            	<font class="icon-clock">发布于<?php echo $item['time']; ?></font>
                                <!-- <font class="view">查看数（28）</font>
                    			<font class="design">回答数（4）</font> -->
                            </p>
                        </li>
						<?php 
						endif;
						endforeach; 
						endif;?>
						</span>

						<span id='tab2' style="display:none;">
                    	<?php if(!empty($mashup_data) && isset($mashup_data['data'])):
						foreach($mashup_data['data'] as $item): 
						if($item['type_string'] == 'D'): 
						?> 
                    	<li>
                        	<a href="<?php echo $item['url']; ?>" class="title"><?php echo $item['desc']; ?></a>
                            <p><?php echo $item['desc']; ?></p>
                            <p class="bottom">
                            	<!-- <img class="pull-left" src="images/geren_tx.png" /><span class="text-orange"><?php echo $item['username']; ?></span> -->
                            	<font class="icon-clock">发布于<?php echo $item['time']; ?></font>
                                <!-- <font class="view">查看数（28）</font>
                    			<font class="design">回答数（4）</font> -->
                            </p>
                        </li>
						<?php 
						endif;
						endforeach; 
						endif;?>
						</span>

						<span id='tab3' style="display:none;">
                    	<?php if(!empty($mashup_data) && isset($mashup_data['data'])):
						foreach($mashup_data['data'] as $item): 
						if($item['type_string'] == 'S'): 
						?> 
                    	<li>
                        	<a href="<?php echo $item['url']; ?>" class="title"><?php echo $item['desc']; ?></a>
                            <p><?php echo $item['desc']; ?></p>
                            <p class="bottom">
                            	<!-- <img class="pull-left" src="images/geren_tx.png" /><span class="text-orange"><?php echo $item['username']; ?></span> -->
                            	<font class="icon-clock">发布于<?php echo $item['time']; ?></font>
                                <!-- <font class="view">查看数（28）</font>
                    			<font class="design">回答数（4）</font> -->
                            </p>
                        </li>
						<?php 
						endif;
						endforeach; 
						endif;?>
						</span>

						<span id='tab4' style="display:none;">
						<?php if(!empty($net_data)):
						foreach($net_data as $item): ?> 
						<li>
							<a href="<?php echo $item['link']; ?>" target="_blank" class="title"><?php echo $item['title']; ?></a>
                            <p><?php echo utf8Substr($item['content'],0,100) ?></p>
                            <p class="bottom">
                            	<!-- <img class="pull-left" src="images/geren_tx.png" /><span class="text-orange"><?php echo $item['username']; ?></span> 
                            	<font class="icon-clock">发布于<?php echo $item['time']; ?></font>
                                <font class="view">查看数（28）</font>
                    			<font class="design">回答数（4）</font> -->
                            </p>
						</li>
						<?php endforeach; endif;?>
						</span>

                    </ul>
                    <div class="panel-footer">
                    	<a href="#" class="btn-more">更多问题</a>
                    </div>
            	</div>
        </div>
    </div>
  </div>

<?php   
   //截取utf8字符串   
   function utf8Substr($str, $from, $len)   
   {   
      return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.   
                         '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',   
                         '$1',$str);   
   }   
   ?>

 	<input type="hidden" value="<?php echo $base; ?>" id="header_base" />     
    	
<?php include("footer.php"); ?>


</div>
</body>

    <script src="<?php echo $base.'js/question_asking_process.js';?>"></script>    
    <script src="<?php echo $base.'js/kwapro_search.js';?>" ></script> 
   <script>
	$(function() {
		question_ask_process({submit_id:'question_submit',expert_cname:'experts',text_id:'question_text',tag_id:'keyword', finish_tips:'您的问题已提交，请等待回复！', base:'<?php echo $base; ?>'});
	});
   </script>
</html>   
    