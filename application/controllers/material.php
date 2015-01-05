<?php
	date_default_timezone_set('PRC');
  class Material extends CI_Controller
  {
	  var $pre_msg_num=9;
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
		 $this->load->model('q2a/Right_nav_data');
		 $this->load->model('q2a/Invite_data_process');
         $this->load->model('q2a/Load_common_label');
		 $this->load->model('q2a/Friend_manage');
		 $this->load->model('q2a/Kpc_manage');
         $this->load->model('q2a/Ip_location');
         $this->load->model('q2a/User_privacy');
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
		//get material string 
		$materials=array();;
		$pre_msg_num = $this->get_pre_msg_num();
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('*');
		$this->db->where('uId',$user_id);
		$t_query=$this->db->get('material');
		$data['inbox_num']=	$t_query->num_rows();
			
		$this->db->where('uId',$user_id);
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('material');
		foreach($query->result_array() as $row)
		{
			array_push($materials,$row['material']);
		}
		$data['material'] = $materials;


		$data['pre_msg_num'] = $this->get_pre_msg_num();
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);




		$right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	    $data = array_merge($right_data,$data);

		$this->load->view('q2a/material',$data);

	}
	function col_material()
	{
		//login permission check
		if(!$this->Auth->login_check())
		 {
		    echo "请先登录";return;
		 }
		$time = date("Y-m-d H:i:s", time());
		$p_material = $_POST['material'];
		$this->db->select('material');
	 	$this->db->where(array('uId'=>$this->session->userdata('uId'), 'material'=>$p_material));
	 	$query = $this->db->get('material');

		if($query->num_rows > 0)
		{
			//if exits
			echo "此图片您已经收集过";
			return;
		}
		else
		{
			$this->db->set('uId',$this->session->userdata('uId'));
			$this->db->set('material',$p_material);
			$this->db->set('createdate',$time);
			$this->db->insert('material');
			echo "收集成功";return;
		}
	 }


	  //
    function get_pre_msg_num()
    {
     	if(empty($this->pre_msg_num))
     	{
     	   $this->pre_msg_num = $this->config->item('pre_message_num');
     	}
     	return $this->pre_msg_num;
    }

	function sort_material()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->get_pre_msg_num();
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
		$data = array('uId'=>$user_id,'range'=>$range);

		$materials=array();
		$this->db->select('*');
		$this->db->where('uId',$user_id);
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('material');
		foreach($query->result_array() as $row)
		{
			array_push($materials,$row['material']);
		}

		$html = '';
		if(!empty($materials))
		{
			foreach($materials as $item){
				$html .= '<li><img width="215" height="135" src="'.$base.'img/'.$item.'" /></li>';
			}
		}
		echo $html;

	}


 }

 /*End of file*/
  /*Location: ./system/appllication/controller/material.php*/
