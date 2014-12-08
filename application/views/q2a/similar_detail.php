<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIT系统</title>
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script src="<?php echo $base.'js/jquery.min.js';?>" type="text/javascript"></script>
<script>
$(document).ready(function() {
	$(".tab-btns a").click(function(){
		$(".tab-btns a.black").removeClass("black");
		$(this).addClass("black");
		if($(this).attr("id") == "path"){
			//$(".thumbs").show();
		}
		else{
			//$(".thumbs").hide();
			//$('#detailname').html('整体');
		}
	});
});
</script>

</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->

<!------------ 内容开始 -------------> 
<div id="sjlc" class="main flows"> 
<div class="btns tab-btns">
	<a id="path" href="javascript:;" class="black">舒适度</a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="javascript:;">皮肤湿度</a>
	<a href="javascript:;">温度</a>
</div>
</div>

		<?php
		   $content = trim(file_get_contents('http://localhost/TIT/SimResult/ComfortEvaluationRes.DAT'));
		   $arr = explode("\n", $content);
		   $idx = 0;
		   foreach ($arr as $v) {
				$tmp = explode("	", $v);
				$arr[$idx]=$tmp;
				unset($tmp);
				$idx++;
		   }
	
	  ?>

		<script type="text/javascript" src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
		<script src="javascript/highcharts.js"></script>
		<script src="javascript/exporting.js"></script>
		
		<script type="text/javascript">
		
		$(function () {
		//alert(<?php echo $arr[0][0];?>);
			$('#container').highcharts({
				chart: {
					type: 'spline'
				},
				title: {
					text: '舒适度'
				},
				subtitle: {
					text: '仿真预测'
				},
				legend: { 
					labelFormatter: function () {
						if(this.name=='R_th')
							return this.name + ' 热感知度';
						if(this.name=='R_dp')
							return this.name + ' 湿感知度';
						if(this.name=='R_tc')
							return this.name + ' 热舒适度';
					}
				},
				xAxis: {
					type:'linear',
					title: {
						text: 'Time (Min)'
					}
				},
				yAxis: {
					title: {
						text: 'Perception and Sensative Ratings'
					}
					
				},
				tooltip: {
					crosshairs: true,
					shared: true
				},
				plotOptions: {
					spline: {
						marker: {
							radius: 4,
							lineColor: '#666666',
							lineWidth: 1
						}
					}
				},
				series: [{
					name: 'R_th',
					
					data: [
					<?php
					   for($i=0;$i<$idx;$i++)
					   {
							echo '[';
							echo $arr[$i][0];
							echo ',';
							echo $arr[$i][7];
							echo ']';
							if($i<($idx-1))
								echo ',';
					   }
					   
				  ?>
					]
		
				}, {
					name: 'R_dp',
					
					data: [
					<?php
					   for($i=0;$i<$idx;$i++)
					   {
							echo '[';
							echo $arr[$i][0];
							echo ',';
							echo $arr[$i][8];
							echo ']';
							if($i<($idx-1))
								echo ',';
					   }
					   
				  ?>
					]
				}, {
					name: 'R_tc',
					
					data: [
					<?php
					   for($i=0;$i<$idx;$i++)
					   {
							echo '[';
							echo $arr[$i][0];
							echo ',';
							echo $arr[$i][9];
							echo ']';
							if($i<($idx-1))
								echo ',';
					   }
					   
				  ?>
					]
				}]
			});
		});
    

		</script>


<!------------ 底部开始 ------------->
<?php include("footer.php");?>
</div>
</body>
</html>
