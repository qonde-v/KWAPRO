<?php
  class Order extends CI_Controller
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


	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

	   //get orders for user 
		$orders=array();;
		$pre_msg_num = $this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('*');
		$this->db->where('uId',$user_id);
		$t_query=$this->db->get('orders');
		$data['inbox_num']=	$t_query->num_rows();

		$this->db->where('uId',$user_id);
		$this->db->order_by('createtime','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('orders');
		foreach($query->result_array() as $row)
		{
			array_push($orders,$row);
		}
		$data['orders'] = $orders;
		$data['pre_msg_num'] = $this->pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

	   $this->load->view('q2a/myorder',$data);

	}

	function sort_order()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
		$data = array('uId'=>$user_id,'range'=>$range);

		$orders=array();
		$this->db->select('*');
		$this->db->where('uId',$user_id);
		$this->db->order_by('createtime','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('orders');
		foreach($query->result_array() as $row)
		{
			array_push($orders,$row);
		}

		$html = '';
		if(!empty($orders))
		{
			$i=0;
			$html .= '<ul class="main-list">';
			foreach($orders as $item){
				$i++;
				$html .= '	<li>';
				$html .= '		<a href="'.$base.'order/order_detail?id='.$item['id'].'" class="title">'. $i.'、'.$item['realname'].'、'.$item['address'].'、'.$item['tel'].'</a>';
				$html .= '		<div class="btns">';
				$html .= '		<a href="'.$base.'order/order_detail?id='.$item['id'].'">查看详情</a>';
				$html .= '		</div>';
				$html .= '		<p><span class="pull-right">提交于'.$item['createtime'].'</span></p>';
				$html .= '	</li>';
			}
			$html .= '</ul>';
		}
		echo $html;

	}


	function order_detail()
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
		$query = $this->db->get('orders');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}
		
	   foreach($result as $val){
		   $data['order']=$val;
	   }
		$this->load->view('q2a/order_detail',$data);
	}

 }

 /*End of file*/
  /*Location: ./system/appllication/controller/Consult.php*/
