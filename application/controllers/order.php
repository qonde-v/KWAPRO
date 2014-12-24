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
		 $this->load->model('admin/Core_factory');
		 $this->load->model('admin/Core_order');
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

	   //get factory
	   $data['order']['factory'] = $this->Core_factory->show_one($data['order']['factory_id']);

	   //get status
	   $arr_status = $this->Core_order->get_status();
	   $data['arr_status'] = $arr_status;

	   //get design
	    $result_d=array();
		$result_d=$this->Demand_management->get_user_design($data['order']['design_id']);
		foreach($result_d as $val){
			  $data['design']=$val;
		}

		$this->load->view('q2a/order_detail',$data);
	}

	
	
	function orderlist()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   $data = array('base'=>$base);
	   $userid=$this->session->userdata('uId');

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($userid);
	   $data = array_merge($right_data,$data);

	   if($userid!='')$data['login'] = "login";

	    $orders=array();;
		$pre_msg_num = 3;//$this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('*');
		if(isset($_GET['status'])){
			if($_GET['status']==1){
				$this->db->where('status >=',1);
				$this->db->where('status <=',4);
			}
			else{
				$this->db->where('status',$_GET['status']);
			}
		}

 		$t_query=$this->db->get('orders');
		$data['inbox_num']=	$t_query->num_rows();

		if(isset($_GET['status'])){
			$data['status'] = $_GET['status'];
			if($_GET['status']==1){
				$this->db->where('status >=',1);
				$this->db->where('status <=',4);
			}
			else{
				$this->db->where('status',$_GET['status']);
			}
		}else{
			$data['status'] = 'all';
		}

		$this->db->order_by('createtime','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('orders'); 
		foreach($query->result_array() as $row)
		{
			array_push($orders,$row);
		}
		$data['orders'] = $orders;
		$data['pre_msg_num'] = $pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

		$arr_status = $this->Core_order->get_status();
		$data['arr_status'] = $arr_status;
		
		$sumarr=array();
		$result_s=$this->db->query('SELECT count(1)sum0, sum(if(status=0,1,0)) as sum1,sum(if(status=5,1,0))as sum2,sum(if(status between 1 and 4,1,0)) as sum3 FROM orders');
		foreach($result_s->result_array() as $row)
		{
			$sumarr=$row;
		}
		$data['sumarr'] = $sumarr;
			
		$this->load->view('q2a/orderlist',$data);
	}

	function sort_orderlist()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$status = $this->input->post('status',TRUE);
		$pre_num = 3;//$this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);

		$orders=array();
		$this->db->select('*');
		if($status!='all'){
			if($status==1){
				$this->db->where('status >=',1);
				$this->db->where('status <=',4);
			}
			else{
				$this->db->where('status',$status);
			}
		}
		$this->db->order_by('createtime','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('orders');
		foreach($query->result_array() as $row)
		{
			array_push($orders,$row);
		}

		$arr_status = $this->Core_order->get_status();


		$html = '';
		if(!empty($orders))
		{
			$i=0;
			foreach($orders as $item){
				$i++;
				$html .= '<div class="order-items">';
				$html .= '	<ul>';
				$html .= '		<li class="img"><img src="images/gly_dd_p.png" /></li>';
				$html .= '		<li class="text-left"><strong>订单</strong>l/单布料</li>';
				$html .= '		<li>300</li>';
				$html .= '		<li>2</li>';
				$html .= '		<li>600</li>';
				$html .= '		<li>20</li>';
				$html .= '		<li class="text-red">620</li>';
				$html .= '		<li>'. $arr_status[$item['status']]->name.'</li>';
				$html .= '	</ul>';
				$html .= '	<div class="bottom">';
				$html .= '		<span>订单ID：</span>';
				$html .= '		<span>提交时间：</span>';
				$html .= '		<span>设计人：</span>';
				$html .= '		<a href="'.$base.'order/order_detail?id='.$item['id'].'" class="pull-right">前往详情》》</a>';
				$html .= '	</div>';
				$html .= '</div>';
			}
		}
		echo $html;

	}


	function set_status(){
		$id = $this->input->post('id',TRUE);
		$status = $this->input->post('status',TRUE);
		$data = array('status'=>$status);
		if($status==5)$data['committime'] = date('Y-m-d H:i:s', time()+8*60*60);
		$this->Core_order->update($data,$id);
	}

 }

 /*End of file*/
  /*Location: ./system/appllication/controller/Consult.php*/
