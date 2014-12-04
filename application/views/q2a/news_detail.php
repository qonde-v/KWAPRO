<!DOCTYPE html>

<html>
<head>
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" /> -->
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>


</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->



<!------------ 内容开始 -------------> 

  <div class="main"> <img src="<?php echo $base.'img/sub_top_p.png';?>" />
    <ul class="breadcrumb">
      <li><a href="<?php echo $base;?>">首页</a></li>
      <li>/</li>
      <li><a href="<?php echo $base.'news/?type='.$news['type'];?>"><?php echo $status[substr($news['type'],0,1)].'广场';?></a></li>
      <li>/</li>
      <li><a href="<?php echo $base.'news/?type='.$news['type'];?>"><?php echo $status[$news['type']];?></a></li>
      <li class="pull-right"><?php echo $news['viewnum'];?></li>
    </ul>
    <div class="content"> <a class="title"><?php echo $news['title'];?></a>
      <ul class="links">
        <li>发布时间：<span class="time"><?php echo $news['createTime'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
        <li><a href="javascript:copyUrl()">【复制链接】</a></li>
        <li><a href="<?php if($lastid>0)echo $base.'news/news_detail?id='.$lastid; else echo '#';?>">【上个知识】</a></li>
        <li><a href="<?php if($nextid>0)echo $base.'news/news_detail?id='.$nextid; else echo '#';?>">【下个知识】</a></li>
      </ul>
      <div class="jumbotron"> 
			<?php echo $news['content'];?>	
      </div>
    </div>
  </div>



<!------------ 底部开始 ------------->
<?php include("footer.php");?>
</div>
</body>
</html>
