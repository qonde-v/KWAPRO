<?php
	date_default_timezone_set('PRC');
  class Similarmanage extends CI_Controller
  {
	   var $pre_msg_num=5;
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');

		 $this->load->database();
		 $this->load->library('session');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Auth');
		 $this->load->library('account_format_check');

         $this->load->model('q2a/User_profile');
		$this->load->model('q2a/User_data');
		$this->load->model('q2a/Photo_upload');
		 $this->load->model('q2a/Right_nav_data');
		 $this->load->model('q2a/Invite_data_process');
         $this->load->model('q2a/Load_common_label');
		 $this->load->model('q2a/Check_process');
		 $this->load->model('q2a/Friend_manage');
		 $this->load->model('q2a/Kpc_manage');
         $this->load->model('q2a/Ip_location');
         $this->load->model('q2a/User_privacy');
		 $this->load->model('q2a/Demand_management');
	 }

	function index()
	{
	   $base = $this->config->item('base_url');
	   $base_photoupload_path = $this->config->item('base_photoupload_path');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base,'base_photoupload_path'=>$base_photoupload_path);
	   $data['login'] = "login";


	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

	   //get designs for user 
		$designs=array();;
		$pre_msg_num = $this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('*');
		if(isset($_GET['status']) && $_GET['status']==1)
			$this->db->where('status = 1');
		elseif(isset($_GET['status']) && $_GET['status']==2)
			$this->db->where('status >= 2');
		else
			$this->db->where('status >',0);
		$t_query=$this->db->get('design');
		$data['inbox_num']=	$t_query->num_rows();

		$this->db->order_by('createdate','desc');
		if(isset($_GET['status']) && $_GET['status']==1)
			$this->db->where('status = 1');
		elseif(isset($_GET['status']) && $_GET['status']==2)
			$this->db->where('status >= 2');
		else
			$this->db->where('status >',0);
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('design');
		foreach($query->result_array() as $row)
		{
			array_push($designs,$row);
		}
		$data['designs'] = $designs;
		$data['pre_msg_num'] = $this->pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

		$query = $this->db->query("select count(1)cnt, sum(if(status=1,1,0))cnt1,sum(if(status>=2,1,0))cnt2 from design where status>0");
		$sum =$query->row_array();
		$data['sum'] = $sum;
	   $this->load->view('q2a/similarmanage',$data);

	}

	function downloads(){
		$name = $_GET['fn'];
		$base_dir='D:/xampp/htdocs/TIT/cgi/SimPlan/SP';
		$filename = $base_dir.$name;
		if (!file_exists($filename)){
			header("Content-type: text/html; charset=utf-8");
			echo "<script>alert('未找到文件!');history.go(-1);</script>";
			exit;
		} else {
			$file = fopen($filename,"r");
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: ".filesize($filename));
			Header("Content-Disposition: attachment; filename=".basename($filename));
			echo fread($file, filesize($filename));
			fclose($file);
		}
	}
	function savestatus()
	{
		$post_arr = array();
		
		foreach($_POST as $key=>$value)
		{
			$post_value = $this->input->post($key,TRUE);
			$post_arr[$key] = $post_value ? $post_value : 0;
		}
		$this->Demand_management->savesimilar($post_arr['designid'],$post_arr['status'],$post_arr['memo'],$post_arr['similarpic']);
	}

	function save_pic()
	 {
	 	if($this->Auth->request_access_check())
		{
			$post_arr = array();
			foreach($_POST as $key => $value)
			{
				$post_value = $this->input->post($key);
				$post_arr[$key] = $post_value;
			}
			

			$scale = 1;
			$base = $this->config->item('base_url');
			$base_photoupload_path = $this->config->item('base_photoupload_path');
			$user_id = $this->session->userdata('uId');
			//print_r($_FILES);
			$msg = $this->Photo_upload->user_photo_upload(array('user_id'=>$user_id, 'file_id'=>'f_pic'.$_GET['type']));
			if($msg['msg'] == 'UPDATE_SUCCESS')
			{
				/*if($_GET['type']==1){
					$file_name = $this->security->sanitize_filename($_FILES['f_design']['name']);
				}elseif($_GET['type']==2){
					$file_name = $this->security->sanitize_filename($_FILES['f_effect']['name']);
				}elseif($_GET['type']==3){
					$file_name = $this->security->sanitize_filename($_FILES['f_detail']['name']);
				}*/

				$file_name = $msg['file_name'];

				 $img_src = $base.$base_photoupload_path.'temp/'.$file_name;

				echo "<img id=\"img_".$_GET['type']."\" width=50 height=50 border=\"1\" style=\"display:\" src=\"".$img_src."\"/>";
				
			}
			else
			  {
				echo $this->Check_process->get_prompt_msg(array('pre'=>'design','code'=> $msg));
			  }
		}
	 }

	function sort_similar()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
		$data = array('uId'=>$user_id,'range'=>$range);

		$designs=array();
		$this->db->select('*');
		if(isset($_GET['status']) && $_GET['status']==1)
			$this->db->where('status = 1');
		elseif(isset($_GET['status']) && $_GET['status']==2)
			$this->db->where('status >= 2');
		else
			$this->db->where('status >',0);
		$this->db->order_by('createdate','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('degign');
		foreach($query->result_array() as $row)
		{
			array_push($designs,$row);
		}

		$html = '';
		if(!empty($designs))
		{
			$i=0;
			foreach($demands as $item){
				$i++;

				$html .= '<div class="order-items" id="divcontent">';
            	$html .= '<ul>';
                $html .= '	<li class="img"><img style="width:73px;height:116px;" src="'.$base.$base_photoupload_path.'temp/'.$item['design_pic'].'" /></li>';
				$html .= '     <li class="xml"><label>'.$item['uId'].$item['id'].'.xml<br /><a class="download" href="'.$base.'similarmanage/downloads?fn='.$item['uId'].$item['id'].'.xml" id="xml_'.$item['id'].'" >点击下载</a></label></li>';
                $html .= '    <li class="upd">';
				$html .= '		<form id="form_pic1'.$item['id'].'" name="form_pic" action="" method="POST" onsubmit="return false;">';
                $html .= '    	<div class="upload"><label>舒适度文件：</label><input type="text" id="spic1_<'.$item['id'].'" readonly/><a class="btn" id="a_pic1'.$item['id'].'">浏览</a><input type="file"  class="btn" id="f_pic1'.$item['id'].'" name="f_pic1'.$item['id'].'" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:50px;cursor:pointer;" onchange="document.getElementById(\'spic1_\'+'.$item['id'].').value=getFileName(this.value)" /><a href="#" class="ipload_btn" onclick="save_pic(1'.$item['id'].');">上传文件</a>';
				$html .= '		<div id="photo_pic1'.$item['id'].'" style="text-align:center;display:none;"></div>';
				$html .= '		</div>';
				$html .= '		</form>';
				$html .= '		<form id="form_pic2'.$item['id'].'" name="form_pic" action="" method="POST" onsubmit="return false;">';
                $html .= '    	<div class="upload"><label>舒适度文件：</label><input type="text" id="spic2_<'.$item['id'].'" readonly/><a class="btn" id="a_pic2'.$item['id'].'">浏览</a><input type="file"  class="btn" id="f_pic2'.$item['id'].'" name="f_pic2'.$item['id'].'" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:50px;cursor:pointer;" onchange="document.getElementById(\'spic2_\'+'.$item['id'].').value=getFileName(this.value)" /><a href="#" class="ipload_btn" onclick="save_pic(2'.$item['id'].');">上传文件</a>';
				$html .= '		<div id="photo_pic2'.$item['id'].'" style="text-align:center;display:none;"></div>';
				$html .= '		</div>';
				$html .= '		</form>';
				$html .= '		<form id="form_pic3'.$item['id'].'" name="form_pic" action="" method="POST" onsubmit="return false;">';
                $html .= '    	<div class="upload"><label>舒适度文件：</label><input type="text" id="spic3_<'.$item['id'].'" readonly/><a class="btn" id="a_pic3'.$item['id'].'">浏览</a><input type="file"  class="btn" id="f_pic3'.$item['id'].'" name="f_pic3'.$item['id'].'" style="position:absolute;filter:alpha(opacity:0);opacity: 0;width:50px;cursor:pointer;" onchange="document.getElementById(\'spic3_\'+'.$item['id'].').value=getFileName(this.value)" /><a href="#" class="ipload_btn" onclick="save_pic(3'.$item['id'].');">上传文件</a>';
				$html .= '		<div id="photo_pic3'.$item['id'].'" style="text-align:center;display:none;"></div>';
				$html .= '		</div>';
				$html .= '		</form>';
                $html .= '    </li>';
                $html .= '    <li class="step"><span style="cursor:pointer;" onclick="$(\'#designid\').val('. $item['id'].');$(\'#modalconfirm\').show();">仿真完成</span></li>';
				if($item['status']==1) $html .= '<li class="step text-orange">仿真进行中</li>';
				if($item['status']==2) $html .= '<li class="step text-green">仿真完成</li>';
				if($item['status']==3) $html .= '<li class="step text-red">仿真失败</li>';
                $html .= '</ul>';
                $html .= '<div class="bottom">';
                $html .= '	<span>设计编号：'.$item['id'].'</span>';
                $html .= '    <span>提交时间：'.$item['createdate'].'</span>';
                $html .= '    <span>提交人：'.$item['username'].'</span>';
                $html .= '    <a href="'.$base.'design/design_detail?id='.$item['id'].'" class="pull-right">前往详情《</a>';
                $html .= '</div>';
				$html .= '</div>';
			}
		}
		echo $html;

	}


 }

 /*End of file*/
  /*Location: ./system/appllication/controller/design.php*/
