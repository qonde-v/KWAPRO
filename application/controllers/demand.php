<?php
	date_default_timezone_set('PRC');
  class Demand extends CI_Controller
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

	   //get demands for user 
		$demands=array();;
		$pre_msg_num = $this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('id,title,designnum,viewnum,messnum,createdate');
		$this->db->where('uId',$user_id);
		$t_query=$this->db->get('demand');
		$data['inbox_num']=	$t_query->num_rows();

		$this->db->order_by('createdate','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('demand');
		foreach($query->result_array() as $row)
		{
			array_push($demands,$row);
		}
		$data['demands'] = $demands;
		$data['pre_msg_num'] = $this->pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

	   $this->load->view('q2a/demand',$data);

	}

	function publish()
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
		$this->load->view('q2a/publish',$data);
	}

	function pubok()
	{
		$post_arr = array();
		foreach($_POST as $key=>$value)
		{
			$post_value = $this->input->post($key,TRUE);
			$post_arr[$key] = $post_value ? $post_value : 0;
		}
		$post_arr['title'] = str_replace("\n","<BR/>",$post_arr['title']);
		$post_arr['createdate'] = date("Y-m-d H:i:s", time());
		$userid=$this->session->userdata('uId');
		$post_arr['uId'] = $userid;
		$post_arr['username'] = $this->User_data->get_username(array('uId'=>$userid));

		$this->Demand_management->demand_record_insert($post_arr);

		echo 'publish OK';
	}

	function demandlist()
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
		$this->load->view('q2a/demandlist',$data);
	}

	
	function demand_detail()
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
	   $result=$this->Demand_management->get_user_demand($_GET['id']);
	   foreach($result as $val){
		   $data['demand']=$val;
	   }
		$this->load->view('q2a/demand_detail',$data);
	}

	function products()
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

		$data['title']=$_GET['title'];
		$data['type']=$_GET['type'];
		$data['weather']=$_GET['weather'];
		$data['target']=$_GET['target'];
		$this->load->view('q2a/products',$data);
	}


	function sort_demand()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
		$data = array('uId'=>$user_id,'range'=>$range);

		$demands=array();
		$this->db->select('id,title,designnum,viewnum,messnum,createdate');
		$this->db->where('uId',$user_id);
		$this->db->order_by('createdate','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('demand');
		foreach($query->result_array() as $row)
		{
			array_push($demands,$row);
		}

		$html = '';
		if(!empty($demands))
		{
			$i=0;
			foreach($demands as $item){
				$i++;
				$html .= '<tr>';
				$html .= '<td width="85%" height="40" valign="middle" align="left" ><a href="#" class="Red14">'. $i.'、'.$item['title'].'</a></td>';
				$html .= '<td width="15%" height="40" valign="middle" align="right">';
				$html .= '<div class="red_bt15" style="width:35px; text-align:center;float:left"><a href="'.$base.'demand/publish" class="White14">发布</a></div> &nbsp;&nbsp;&nbsp;&nbsp;';
				$html .= '<div class="red_bt15" style="width:45px; text-align:center;float:right"><a href="'.$base.'design/practice" class="White14">去设计</a></div>';
				$html .= '</td>';
				$html .= '</tr>';
				$html .= '<tr>';
				$html .= '<td width="50%" height="40" valign="middle" align="left">';
				$html .= '<a href="#" class="DBlue">'.$item['designnum'].'</a> 设计 &nbsp;&nbsp;&nbsp;&nbsp;';
				$html .= '<a href="#" class="DBlue">'.$item['viewnum'].'</a> 浏览 &nbsp;&nbsp;&nbsp;&nbsp;';
				$html .= '<a href="#" class="DBlue">'.$item['messnum'].'</a> 留言 &nbsp;&nbsp;&nbsp;&nbsp;</td>';
				$html .= '<td width="50%" height="40" valign="middle" align="right" class="fGray">'.$item['createdate'].'</td>';
			    $html .= '</tr>';

			}
		}
		echo $html;

	}
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/design.php*/