<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>人员信息管理</title>
<!-- <link href="<?php echo $base."css/style_1.css";?>" rel="stylesheet" type="text/css" id="cssfile"/> -->
<link href="<?php echo $base."css/tag.css";?>" rel="stylesheet"
	type="text/css" />
<link href="<?php echo $base."css/jquery/jquery.ui.all.css";?>" rel="stylesheet"
	type="text/css" />

<link href="<?php echo $base."css/jquery/autocomplete.css";?>" rel="stylesheet"
	type="text/css" />

<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/utils_date.js";?>"></script>
<script language="javascript" type="text/javascript" 
	src="<?php echo $base."js/public.js";?>" charset="gb2312"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery-1.7.1.min.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.core.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.widget.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.position.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.autocomplete.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.button.js";?>"></script>

<style type="text/css">
<!--
#table_list{font-size:13px;}
#table_list th{background:url("<?php echo $base."images/TableThBg.jpg";?>") repeat;border:1px solid #ffffff;color:#ffffff;height:40px;}
#table_list tbody tr{background:#ffffff;border:1px solid #ffffff;height:40px;}
-->
</style>
<script language="javascript" type="text/javascript">
	function MouseTr(){
		$("#table_list tbody tr").css("background","#ffffff");
		$("#table_list tbody tr:odd").css("background","#e5f1f4");
	}
	$(document).ready(function(){
		$( "input:submit, a, button", "#com_but" ).button();
		$("#table_list tbody tr").css("background","#ffffff");
		$("#table_list tbody tr:odd").css("background","#e5f1f4");
		$("#table_list tbody tr").mouseover(
		function(){
			  $(this).css("background-color","#bce774");}
			);
		$("#table_list tbody tr").mouseout(
		function(){
			  MouseTr();}
			);
	});

	function delete_record(id){
		var url = document.getElementById("uri").value + "delete/?id="+ id;
		var result = window.confirm("是否删除该记录");
		if (result) {
			window.location.href = url;  
		}
	} 

	function search(){
		var cdt = document.frm_search.submit();
		
	}
</script>

</head>
<body>

<?include("page_head.php");?>
<input type="hidden" id="uri" value="<?php echo $base."admin/user/"?>"/>
	<div class="container-fluid">
	<div class="row-fluid">
		<?include(dirname(__FILE__).'/nav.php');?>
		<div id="content" style="padding-left:230px;">
			<div style="text-align:center;">
				<ul class="breadcrumb">
					<li><h3>人员管理</h3></li>
				</ul>
			</div>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h4>人员列表</h4>
					</div>
					<div style="display:inline;float:right">
						<a class="ajax-link" href="http://localhost/TIT/admin/user/edit/-1">
							<i class="icon-edit"></i>
							<span class="hidden-tablet"> 增加管理员</span>
						</a>
					</div>
					<div class="box-content">
						<div class="row-fluid">
							<div class="span10">
								<div id="DataTables_Table_0_filter" class="dataTables_filter">
								<form action="<?php echo $base."admin/user/search/"?>" name="frm_search" method="get">
								<label>昵称/用户名过滤：
								<input type="text" aria-controls="DataTables_Table_0"name="cdt_name" id="cdt_name" value="">
								<input type="hidden" name="createid" id="createid" value="<?php echo $createid;?>"  />
								<img border="0" style="cursor:pointer;" align="absmiddle" onclick="search()" src="<?php echo $base."img/search.png";?>" alt="人员快速查询" />（总共找到<span style="color:blue"><?php echo $total_num?></span>条记录）
								 <?php if($this->session->userdata('roleId') == 0) {?><?php }?>
								</label>
								</form>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th scope="col" style="width:2%;">ID</th>
								  <th scope="col" style="width:10%;">昵称</th>
								  <th scope="col" style="width:10%;">工号</th>
								  <th scope="col" style="width:13%;">时间</th>
								  <th scope="col" style="width:5%;">修改</th>
								  <th scope="col" style="width:5%;">删除</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php $i=0;
							foreach ($list as $record) {?>
							<tr>
								<td ><?=++$i?></td>
								<td ><?=$record->nickname?></td>
								<td ><?=$record->userCode?></td>
								<td ><?= date('Y-m-d H:i:s', strtotime($record->createTime))?></td>
								
								<td >
									<?php if(1 == $this->session->userdata('roleId')){?>
										<a class="btn btn-info" href="<?php echo $base."admin/user/edit?createid=".$record->id?>"><i class="icon-edit icon-white"></i> 编辑</a>
									<?php }?>
								</td>
								<td style="width:5%;">
									<?php if($this->session->userdata('roleId') == 1) {?>
										<a class="btn btn-danger"  href="javaScript:delete_record(<?php echo $record->id?>)"><i class="icon-trash icon-white"></i> 删除</a>
									<?php }?>
								</td>
							</tr>
							<?php }?>

						  </tbody>
					  </table> 
					  <div class=" pagination-centered">
						  <?php echo $pagination;?>
							<p style="font-size:14px;">（总共找到<span style="color:blue"><?php echo $total_num?></span>条记录，<span style="color:blue">	<?php echo ceil($total_num/20)?></span>页）</p>
						</div>     
					</div>
				</div><!--/span-->
				</div><!--/row-->

		</div>
		</div>
	</div>
</body>

</html>