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
		if($(this).attr("id") == "shushidu"){
			$(".Comfort").show();
			$(".surfacePlotDiv").hide();
		}
		else{
			//$(".thumbs").hide();
			//$('#detailname').html('整体');
		}
	});
});
</script>

</head>
<div class="container" >
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->

<!------------ 内容开始 -------------> 
<div id="sjlc" class="main flows"> 
<div class="btns tab-btns">
	<a id="shushidu" href="javascript:;" class="black">舒适度</a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a id="shidu" href="javascript:;">皮肤湿度</a>
	<a id="wendu" href="javascript:;">温度</a>
</div>
<div id="Comfort" class="hide">
</div>
<div id='surfacePlotDiv' class="">
<!-- SurfacePlot goes here... -->
	
</div>
</div>

	  <?php
		   $content = trim(file_get_contents($base.'cgi/SimPlan/ComfortEvaluationRes.DAT'));
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
		<script src="<?php echo $base.'js/highcharts.js';?>"></script>
		<script src="<?php echo $base.'js/exporting.js';?>"></script>
		
		<script type="text/javascript">
		
		$(function () {
		//alert(<?php echo $arr[0][0];?>);
			$('#Comfort').highcharts({
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





<!-------------皮肤湿度开始---------------------->
    <?php
	   $content = trim(file_get_contents($base.'cgi/SimPlan/TempF.dat'));
	   $arr = explode("\n", $content);
	   $idx = 0;
	   foreach ($arr as $v) {
			$tmp = explode("	", $v);
			$arr[$idx]=$tmp;
			unset($tmp);
			$idx++;
	   }
	//print_r($arr);
	?>
    <script type='text/javascript'>
               
      google.load("visualization", "1");
      google.setOnLoadCallback(setUp);
           
        function setUp()
        {		
		  
		  var rdata = new Array();
		  
		  rdata = <?php echo json_encode($arr);?>;
		  
		
          var numRows = 6;
          var numCols = 1171;
                
          var tooltipStrings = new Array();
          var data = new google.visualization.DataTable();
          
		  //var bcol = parseFloat(rdata[1][0]);
//alert(bcol);
          for (var i = 0; i < numCols; i++)
          {
            data.addColumn('number', i);
          }
          
		  	  
          data.addRows(numRows);
                         
          for (var i = 0; i < numCols; i++) 
          {		    
            for (var j = 0; j < numRows; j++)
            { 			  
			  var row = rdata[i*numRows + j];
			  var x = parseFloat(row[0]);
			  var y = parseFloat(row[1]);
			  var z = parseFloat(row[2].replace('\r',''));
              data.setValue(j, i, (z-20)/20.0);
        
              tooltipStrings[j*numCols + i] = "x:" + x + ", y:" + y + " = " + z;
            }
          }

         var surfacePlot = new greg.ross.visualisation.SurfacePlot(document.getElementById("surfacePlotDiv"));

         // Don't fill polygons in IE. It's too slow.
         var fillPly = true;

         // Define a colour gradient.
         var colour1 = {red:0, green:0, blue:255};
         var colour2 = {red:0, green:255, blue:255};
         var colour3 = {red:0, green:255, blue:0};
         var colour4 = {red:255, green:255, blue:0};
         var colour5 = {red:255, green:0, blue:0};
         var colours = [colour1, colour2, colour3, colour4, colour5];

         // Axis labels.
         var xAxisHeader = "X";
         var yAxisHeader = "Y";
         var zAxisHeader = "Z";

         var options = {xPos: 200, yPos: 100, width: 600, height: 500, colourGradient: colours,
           fillPolygons: fillPly, tooltips: tooltipStrings, xTitle: xAxisHeader,
           yTitle: yAxisHeader, zTitle: zAxisHeader, restrictXRotation: false};
                
        surfacePlot.draw(data, options);
      }
            
      </script>
        


<!----------------------------------->
<!------------ 底部开始 ------------->
<?php include("footer.php");?>
</div>
</body>
</html>
