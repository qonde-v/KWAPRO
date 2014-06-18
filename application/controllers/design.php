<?php
  class Design extends CI_Controller
  {
	   var $pre_msg_num=5;
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');

		 $this->load->database();
		 $this->load->library('security');
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
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base);
	   $data['login'] = "login";

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

	   //get designs for user 
		$designs=array();;
		$pre_msg_num = $this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('id,title,viewnum,messnum,status,createdate');
		$this->db->where('uId',$user_id);
		$t_query=$this->db->get('design');
		$data['inbox_num']=	$t_query->num_rows();

		$this->db->order_by('createdate','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('design');
		foreach($query->result_array() as $row)
		{
			array_push($designs,$row);
		}
		$data['designs'] = $designs;
		$data['pre_msg_num'] = $this->pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

	   $this->load->view('q2a/design',$data);

	}

	function practice()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');
	   $base_photoupload_path = $this->config->item('base_photoupload_path');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base,'base_photoupload_path'=>$base_photoupload_path);
	   $data['login'] = "login";
		
		//get demand
	   $result=array();
	   $result=$this->Demand_management->get_user_demand($_GET['id']);
	   foreach($result as $val){
		   $data['demand']=$val;
	   }

	   // get similar templet
	   $condition='';
	   $arr_de=$data['demand'];
	   if(!empty($arr_de)){
			$condition=array('id'=>$arr_de['id'],'strength'=>$arr_de['strength'],'sporttime'=>$arr_de['sporttime'],'temperature'=>$arr_de['temperature'],'humidity'=>$arr_de['humidity'],'proficiency'=>$arr_de['proficiency']);
		   $result_s=array();
		   $result_s=$this->Demand_management->get_similar_data($condition);
		   foreach($result_s as $val){
			   $data['similar']=$val;
		   }
		}


		//get design Pictures
		$design_pic = array();
		$this->db->select('*');
		$query = $this->db->get('design_pic');
		foreach($query->result_array() as $val)
		{
			array_push($design_pic,$val);
		}		
		$data['design_pic']=$design_pic;

		//get fabrics
		$fabric = array();
		$this->db->select('*');
		$this->db->limit(7,0);
		$query = $this->db->get('fabrics');
		foreach($query->result_array() as $val)
		{
			array_push($fabric,$val);
		}		
		$data['fabric']=$fabric;

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);


	   $this->load->view('q2a/practice',$data);

	}

	function sort_design()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
		$data = array('uId'=>$user_id,'range'=>$range);

		$designs=array();
		$this->db->select('id,title,viewnum,messnum,status,createdate');
		$this->db->where('uId',$user_id);
		$this->db->order_by('createdate','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('design');
		foreach($query->result_array() as $row)
		{
			array_push($designs,$row);
		}

		$html = '';
		if(!empty($designs))
		{
			$i=0;
			foreach($designs as $item){
				$i++;
				$html .= '<tr>';
				$html .= '<td width="100%" height="" valign="middle" align="right">';
				$html .= '<table width="100%" border="0" cellpadding="0" cellspacing="10" align="center" style="border:1px #f4f4f7 solid;">';
				$html .= '<tr>';
				$html .= '<td width="100%" height="40" valign="middle" align="left" colspan="2"><a href="'.$base.'design/design_detail?id='.$item['id'].'" class="Red14">'.$i.'、'.$item['title'].'</a></td>';
				$html .= '</tr>';
				$html .= '<tr>';
				$html .= '<td width="50%" height="40" valign="middle" align="left"><a href="#" class="DBlue">'.$item['viewnum'].'</a> 浏览 &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="DBlue">'.$item['messnum'].'</a> 留言 &nbsp;&nbsp;&nbsp;&nbsp;</td>';
				$html .= '<td width="50%" height="40" valign="middle" align="right" class="fGray">'.$item['createdate'].'</td>';
				$html .= '</tr>';
				$html .= '</table>';
				$html .= '</td>';
			    $html .= '</tr>';

			}
		}
		echo $html;

	}


	function design_detail()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');
	   $base_photoupload_path = $this->config->item('base_photoupload_path');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base,'base_photoupload_path'=>$base_photoupload_path);
	   $data['login'] = "login";
	   $result=array();
	   
		$this->db->select('*');
		$this->db->where('id',$_GET['id']);
		$query = $this->db->get('design');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}
	   foreach($result as $val){
		   $data['design']=$val;
	   }


	    $this->db->select('*');
		$this->db->where('design_id',$_GET['id']);
		$query = $this->db->get('design_pic');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}		
		$data['design_pic']=$result;

		$result_s=array();
		$result_s=$this->Demand_management->get_fabric($data['design']['fabric']);
		foreach($result_s as $val){
		   $data['fabric']=$val;
		}

		$result_d=array();
		$result_d=$this->Demand_management->get_user_demand($data['design']['demand_id']);
		foreach($result_d as $val){
			  $data['demand']=$val;
		}


		$this->load->view('q2a/design_detail',$data);
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

			$msg = $this->Photo_upload->user_photo_upload(array('user_id'=>$user_id, 'file_id'=>'design_pic'));
			if(UPDATE_SUCCESS == $msg)
			{
				$file_name = $this->security->sanitize_filename($_FILES['design_pic']['name']);

				 $img_src = $base.$base_photoupload_path.'temp/'.$file_name;

				
				/*$save_thumb_path = "./".$base_photoupload_path.$user_id."/".$post_arr['filename'];
				$temp_thumb_path = "./".$base_photoupload_path."temp/".$post_arr['filename'];

				$new_uid_folder = "./".$base_photoupload_path.$user_id."/";
							if(!file_exists($new_uid_folder))
							{
									mkdir($new_uid_folder,0777);
							}

				if(file_exists($save_thumb_path))
				{
					unlink($save_thumb_path);
				}
				$this->Image_process->resizeThumbnailImage($save_thumb_path,$temp_thumb_path,$post_arr['w'],$post_arr['h'],$post_arr['x1'],$post_arr['y1'],$scale);
				$this->Photo_upload->user_photo_save(array('uId'=>$user_id,'photo_name'=>$post_arr['filename'],'photo_type'=>1));
				$msg = $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_SUCCESS));
				$user_photo_path = $base.$base_photoupload_path.$user_id."/".$post_arr['filename'];
				echo $user_photo_path."##".$msg;*/
				echo "<img id=\"original_img\" border=\"1\" style=\"display:none\" src=\"".$img_src."\"/>";
			}
			else
			  {
				echo $this->Check_process->get_prompt_msg(array('pre'=>'design','code'=> $msg));
			  }
		}
	 }


	function designok()
	{
		$post_arr = array();
		$pic_arr = array();
		$picdata = array();
		foreach($_POST as $key=>$value)
		{
			$post_value = $this->input->post($key,TRUE);
			if(substr($key,0,10)=='design_pic') $pic_arr[$key] = $post_value ? $post_value : 0;
			else $post_arr[$key] = $post_value ? $post_value : 0;
		}
		$post_arr['title'] = str_replace("\n","<BR/>",$post_arr['title']);
		$post_arr['createdate'] = date("Y-m-d H:i:s", time());
		$userid=$this->session->userdata('uId');
		$post_arr['uId'] = $userid;
		$post_arr['username'] = $this->User_data->get_username(array('uId'=>$userid));

		$design_id=$this->Demand_management->design_record_insert($post_arr);
		$picdata['design_id']=$design_id;
		$picdata['createdate'] = date("Y-m-d H:i:s", time());
		foreach($pic_arr as $val)
		{
			$picdata['pic_url']=$val;
			$this->Demand_management->designpic_record_insert($picdata);
		}

		echo '保存设计成功';
	}


}

 /*End of file*/
  /*Location: ./system/appllication/controller/design.php*/
