<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TIT系统</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <link href="<?php echo $base.'css/style.css';?>" rel="stylesheet">
<link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet"> -->
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>

</head>
<div class="container">
 <?php include("header.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 

  <div class="main">
  	<div class="carousel">
    	<div class="carousel-indicators">
        	<div class="carousel-info">
            	<img src="<?php echo $base.'img/text.png';?>" /><br />
                <a href="#">前往定制</a>
            </div>
            <a class="carousel-arrow" href="#"><img src="<?php echo $base.'img/arrow-right.png';?>" /></a>
        </div>
    	<div class="carousel-inner">
        	<div class="item active">
              <img src="<?php echo $base.'img/pictures_01.jpg';?>" alt=""/>
            </div>
            <div class="item">
              <img src="<?php echo $base.'img/pictures_01.jpg';?>" alt=""/>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-4 left">
        	<a href="<?php echo $base.'news?type=11';?>"><img src="<?php echo $base.'img/index_tp02.png';?>" alt=""/></a>
        </div>
        <div class="col-4">
        	<a href="<?php echo $base.'news?type=21';?>"><img src="<?php echo $base.'img/index_tp01.png';?>" alt=""/></a>
        </div>
        <div class="col-4 right">
        	<a href="<?php echo $base.'demand/demandlist';?>"><img src="<?php echo $base.'img/index_tp03.png';?>" alt=""/></a>
        </div>
    </div>
  </div>


<!------------ 底部开始 ------------->
<?php include("footer.php"); ?>
</div>
</body>
</html>

