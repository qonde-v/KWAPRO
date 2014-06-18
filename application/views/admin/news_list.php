<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIT新闻</title>

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

<script language="javascript" type="text/javascript">
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
<input type="hidden" id="uri" value="<?php echo $base."admin/news/"?>"/>
	<div class="container-fluid">
	<div class="row-fluid">

		<!-- <div  class="mid_content"> -->
		<?include(dirname(__FILE__).'/nav.php');?>
		<div id="content"  style="padding-left:230px;">
				<div style="text-align:center;">
					<ul class="breadcrumb">
						<li><h3>新闻管理</h3></li>
					</ul>
				</div>
				<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h4>新闻列表</h4>
					</div>
					<div class="box-content">
						<div class="row-fluid">
							<div class="span10">
								<div id="DataTables_Table_0_filter" class="dataTables_filter">
								<form action="<?php echo $base."admin/news/search/"?>" name="frm_search" method="get">
								<label>新闻标题/内容过滤：<input type="text" aria-controls="DataTables_Table_0"name="cdt_name" id="cdt_name" value=""><img border="0" style="cursor:pointer;" align="absmiddle" onclick="search()" src="<?php echo $base."img/search.png";?>" alt="新闻快速查询" />（总共找到<span style="color:blue"><?php echo $total_num?></span>条记录）
								 <?php if($this->session->userdata('roleId') == 0) {?><?php }?>
								<input type="button" value="发布新闻"  onclick="window.location.href='<?php echo $base."admin/news/edit/-1"?>';" />
								</label>
								</form>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th scope="col" style="width:2%;">ID</th>
								  <th scope="col" style="width:8%;">新闻标题</th>
								  <th scope="col" style="width:8%;">作者</th>
								  <th scope="col" style="width:8%;">类型</th>
								  <th scope="col" style="width:8%;">发布时间</th>
							   	  <th scope="col" style="width:5%;">修改</th>
								  <th scope="col" style="width:5%;">删除</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php $i=0;
							foreach ($list as $record) {?>
							<tr>
								<td ><?=++$i?></td>
								<td ><?=$record->title?></td>
								<td ><?=$record->author?></td>
								<td ><?php if($record->type==1)echo '运动';elseif($record->type==2)echo '服装'; else echo '明星'; ?></td>
								<td ><?= date('Y-m-d H:i', strtotime($record->createTime))?></td>
								<td >
									<a class="btn btn-info"  href="<?php echo $base."admin/news/edit/".$record->ID."?createid=".$createid?>"><i class="icon-edit icon-white"></i> 编辑</a>
								</td>
								<td style="width:5%;">
									<?php if($this->session->userdata('roleId') == 1) {?>
										<a class="btn btn-danger"  href="javaScript:delete_record(<?php echo $record->ID?>)"><i class="icon-trash icon-white"></i> 删除</a>
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