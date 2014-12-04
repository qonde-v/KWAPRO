<?php
  class Information extends CI_Controller
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
		 $this->load->model('q2a/Right_nav_data');
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


	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

	   //get information for user 
		$information=array();;
		$pre_msg_num = $this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('*');
		$this->db->where('to_uId',$user_id);
		$t_query=$this->db->get('information');
		$data['inbox_num']=	$t_query->num_rows();

		$this->db->where('to_uId',$user_id);
		$this->db->order_by('createdate','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('information');
		foreach($query->result_array() as $row)
		{
			array_push($information,$row);
		}
		$data['information'] = $information;
		$data['pre_msg_num'] = $this->pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

	   $this->load->view('q2a/information',$data);

	}

	function sort_information()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
		$data = array('uId'=>$user_id,'range'=>$range);

		$information=array();
		$this->db->select('*');
		$this->db->where('to_uId',$user_id);
		$this->db->order_by('createdate','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('information');
		foreach($query->result_array() as $row)
		{
			array_push($information,$row);
		}

		$html = '';
		if(!empty($information))
		{
			$i=0;
			$html .= '<ul class="main-list">';
			foreach($information as $item){
				$i++;
				$html .= '	<li>';
				if($item['type']==1){
					$html .= '		<a href="'.$base.'design/design_detail?id='.$item['relateid'].'" style="color: #fd9300;font-size:16px;">'. $i.'、'.'用户【'.$item['username'].'】对我的需求【'.$item['title'].'】提交了设计'.'</a>';
					$html .= '		<div class="btns"><a href="'.$base.'design/design_detail?id='.$item['relateid'].'">去查看</a></div>';
				}else{
					$html .= '		<a href="'.$base.'demand/demand_detail?id='.$item['relateid'].'" style="color: #fd9300;font-size:16px;">'. $i.'、'.'用户【'.$item['username'].'】对我的需求【'.$item['title'].'】留言'.'</a>';
					$html .= '		<div class="btns"><a href="'.$base.'demand/demand_detail?id='.$item['relateid'].'">去查看</a></div>';
				}
				$html .= '	</li>';
			}
			$html .= '</ul>';
		}
		echo $html;

	}


	function consult_detail()
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
		$query = $this->db->get('consult');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}
		
	   foreach($result as $val){
		   $data['consult']=$val;
	   }
		$this->load->view('q2a/consult_detail',$data);
	}

 }

 /*End of file*/
  /*Location: ./system/appllication/controller/Consult.php*/
