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
		 $this->load->library('session');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Auth');
		 $this->load->library('account_format_check');

         $this->load->model('q2a/User_profile');
		$this->load->model('q2a/User_data');
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

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base);
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
		$condition =  'strength between '.($arr_de['strength']-1).' and '.($arr_de['strength']+1);
		$condition .=  ' and sporttime between '.($arr_de['sporttime']-1).' and '.($arr_de['sporttime']+1);
		$condition .=  ' and temperature between '.($arr_de['temperature']-1).' and '.($arr_de['temperature']+1);
		$condition .=  ' and humidity between '.($arr_de['humidity']-1).' and '.($arr_de['humidity']+1);
		$condition .=  ' and proficiency between '.($arr_de['proficiency']-1).' and '.($arr_de['proficiency']+1);
	   }
	   $result_s=array();
	   $result_s=$this->Demand_management->get_similar_data($condition);
	   foreach($result_s as $val){
		   $data['similar']=$val;
	   }
print_r($data['similar']);

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

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base);
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
		$this->load->view('q2a/design_detail',$data);
	}

}

 /*End of file*/
  /*Location: ./system/appllication/controller/design.php*/
