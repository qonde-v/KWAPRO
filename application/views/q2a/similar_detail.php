<!DOCTYPE html>
<html>
<head>
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<style>



.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}



.line {
  fill: none;
  stroke: steelblue;
  stroke-width: 1.5px;
}

</style>
<script>
function gonext(val){
	var ob;
	for(i=0;i<=2;i++){
		ob=document.getElementById('svg'+i);
		ob1=document.getElementById('tab'+i);
		if(i==val){
			ob.setAttribute("display","");
			ob1.className='sheji_bz1';
		}
		else{
			ob.setAttribute("display","none");
			ob1.className='sheji_bz2';
		}
	}

}
</script>

</head>
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->

<!------------ 内容开始 -------------> 


<div id="index_lx">
<div id="tab0" class="sheji_bz2" style="width:150px; margin-bottom:10px;"><a href="#" onclick="javascript:gonext(0)" class="White14">舒适度</a></div>
<div id="tab1" class="sheji_bz1" style="width:150px; margin-bottom:10px;"><a href="#" onclick="javascript:gonext(1)" class="White14">皮肤湿度</a></div>
<div id="tab2" class="sheji_bz1" style="width:150px; margin-bottom:10px;"><a href="#" onclick="javascript:gonext(2)" class="White14">温度</a></div>

</div>

<script src="http://d3js.org/d3.v3.js"></script>
<script> 

var margin = {top: 20, right: 80, bottom: 30, left: 50},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var parseDate = d3.time.format("%Y%m%d").parse;

var x = d3.scale.linear()
    .range([0, width]);

var y = d3.scale.linear()
    .range([height, 0]);

var color = d3.scale.category10();

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");

var line = d3.svg.line()
    .interpolate("basis")
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.temperature); });

var svg = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
	.attr('id','svg0')
	.append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv("<?=$ComfortEvaluationRes?>", function(error, data) {
  color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

  data.forEach(function(d) {
    d.date = d.date;//parseDate(d.date);
  });

  var cities = color.domain().map(function(name) {
    return {
      name: name,
      values: data.map(function(d) {
        return {date: d.date, temperature: +d[name]};
      })
    };
  });

  x.domain(d3.extent(data, function(d) { return (new Number(d.date)); }));

  y.domain([
    d3.min(cities, function(c) { return d3.min(c.values, function(v) { return v.temperature; }); }),
    d3.max(cities, function(c) { return d3.max(c.values, function(v) { return v.temperature; }); })
  ]);

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
  .append("text")
      .attr("x", 420)
      .attr("dy", "2em")
      .style("text-anchor", "start")
      .text("Time(min.)");

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Perception and Sensation Rathings");

  var city = svg.selectAll(".city")
      .data(cities)
    .enter().append("g")
      .attr("class", "city");

  city.append("path")
      .attr("class", "line")
      .attr("d", function(d) { return line(d.values); })
      .style("stroke", function(d) { return color(d.name); });

  city.append("text")
      .datum(function(d) { return {name: d.name, value: d.values[d.values.length - 1]}; })
      .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
      .attr("x", 3)
      .attr("dy", ".35em")
      .text(function(d) { return d.name; });
});

</script>

<script> 

var margin = {top: 20, right: 80, bottom: 30, left: 50},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var parseDate = d3.time.format("%Y%m%d").parse;

var x = d3.scale.linear()
    .range([0, width]);

var y = d3.scale.linear()
    .range([height, 0]);

var color = d3.scale.category10();

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");

var line = d3.svg.line()
    .interpolate("basis")
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.temperature); });

var svg1 = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
	.attr('id','svg1')
	.attr('display','none')
	.append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv("<?=$SkinWetness?>", function(error, data) {
  color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

  data.forEach(function(d) {
    d.date = d.date;//parseDate(d.date);
  });

  var cities = color.domain().map(function(name) {
    return {
      name: name,
      values: data.map(function(d) {
        return {date: d.date, temperature: +d[name]};
      })
    };
  });

  x.domain(d3.extent(data, function(d) { return (new Number(d.date)); }));

  y.domain([
    d3.min(cities, function(c) { return d3.min(c.values, function(v) { return v.temperature; }); }),
    d3.max(cities, function(c) { return d3.max(c.values, function(v) { return v.temperature; }); })
  ]);

  svg1.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
  .append("text")
      .attr("x", 420)
      .attr("dy", "2em")
      .style("text-anchor", "start")
      .text("Time(min.)");

  svg1.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Skin Wetness");

  var city = svg1.selectAll(".city")
      .data(cities)
    .enter().append("g")
      .attr("class", "city");

  city.append("path")
      .attr("class", "line")
      .attr("d", function(d) { return line(d.values); })
      .style("stroke", function(d) { return color(d.name); });

  city.append("text")
      .datum(function(d) { return {name: d.name, value: d.values[d.values.length - 1]}; })
      .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
      .attr("x", 3)
      .attr("dy", ".35em")
      .text(function(d) { return d.name; });
});

</script>

<script> 

var margin = {top: 20, right: 80, bottom: 30, left: 50},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var parseDate = d3.time.format("%Y%m%d").parse;

var x = d3.scale.linear()
    .range([0, width]);

var y = d3.scale.linear()
    .range([height, 0]);

var color = d3.scale.category10();

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");

var line = d3.svg.line()
    .interpolate("basis")
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.temperature); });

var svg2 = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
	.attr('id','svg2')
	.attr('display','none')
	.append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv("<?=$Temperature?>", function(error, data) {
  color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

  data.forEach(function(d) {
    d.date = d.date;//parseDate(d.date);
  });

  var cities = color.domain().map(function(name) {
    return {
      name: name,
      values: data.map(function(d) {
        return {date: d.date, temperature: +d[name]};
      })
    };
  });

  x.domain(d3.extent(data, function(d) { return (new Number(d.date)); }));

  y.domain([
    d3.min(cities, function(c) { return d3.min(c.values, function(v) { return v.temperature; }); }),
    d3.max(cities, function(c) { return d3.max(c.values, function(v) { return v.temperature; }); })
  ]);

  svg2.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
  .append("text")
      .attr("x", 420)
      .attr("dy", "2em")
      .style("text-anchor", "start")
      .text("Time(min.)");

  svg2.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Temperature(deg C)");

  var city = svg2.selectAll(".city")
      .data(cities)
    .enter().append("g")
      .attr("class", "city");

  city.append("path")
      .attr("class", "line")
      .attr("d", function(d) { return line(d.values); })
      .style("stroke", function(d) { return color(d.name); });

  city.append("text")
      .datum(function(d) { return {name: d.name, value: d.values[d.values.length - 1]}; })
      .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
      .attr("x", 3)
      .attr("dy", ".35em")
      .text(function(d) { return d.name; });
});

</script>
<div id="index_rx">
<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 发布需求，定制你的专属 </div>

<div class="text_k_black text_sjxq" style="margin-top:10px;">
<table width="97%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"><img src="<?php echo $base.'img/dot_01.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">创建一个需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"><img src="<?php echo $base.'img/dot_02.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">选择你的需求参数</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"><img src="<?php echo $base.'img/dot_03.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">描述你的需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"><img src="<?php echo $base.'img/dot_04.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">发布需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"></td>
			  <td width="85%" align="left" valign="middle">-> 对外发布，让别人为你服务</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"></td>
			  <td width="85%" align="left" valign="middle">-> 自己动手设计</td>
            </tr>
</table>
</div>

<div  style="text-align:center; margin-bottom:15px; margin-top:15px;"> 
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="100%" height="30" align="center" valign="middle">
			  <div class="anniu_h" style="width:220px; text-align:center;">
<a href="<?php echo $base.'demand/publish';?>" class="White14">发布需求</a></div></td>
            </tr>
			</table>

 </div>

<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 最新动态 </div>


<div class="index_r_xwnr_tpx" style="margin-bottom:15px;">
<img src="<?php echo $base.'img/index_r001.png';?>" align="absmiddle" border="0" width="294" height="201"/><br>
<div class="index_r_sjxq_bt">参与人：<a href="#" class="Red14">李小小</a>  参与时间：2014-03-25</div>
</div>
<br><br>

<div class="index_r_xwnr_tpx">
<img src="<?php echo $base.'img/index_r002.png';?>" align="absmiddle" border="0" width="294" height="201"/><br>
<div class="index_r_sjxq_bt">参与人：<a href="#" class="Red14">李小小</a>  参与时间：2014-03-25</div>
</div>

</div>

<!------------ 底部开始 ------------->
<?php include("footer.php");?>

</body>
</html>
