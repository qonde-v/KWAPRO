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

	   $data = array('base'=>$base);
	   $data['login'] = "login";

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

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
		if($this->Demand_management->demand_title_exist($post_arr['title'])){
			echo '1';return;
		}
		$post_arr['createdate'] = date("Y-m-d H:i:s", time());
		$userid=$this->session->userdata('uId');
		$post_arr['uId'] = $userid;
		$post_arr['username'] = $this->User_data->get_username(array('uId'=>$userid));

		$demand_id = $this->Demand_management->demand_record_insert($post_arr);
		
		$base = $this->config->item('base_url');
		$base_photoupload_path = $this->config->item('base_photoupload_path');

		// get similar templet
	   $condition='';
	   $condition=array('strength'=>$post_arr['strength'],'sporttime'=>$post_arr['sporttime'],'temperature'=>$post_arr['temperature'],'humidity'=>$post_arr['humidity'],'proficiency'=>$post_arr['proficiency'],'age'=>$post_arr['age'],'weight'=>$post_arr['weight']);
	   $result_s=array();
	   $result_s=$this->Demand_management->get_similar_design($condition);
	   

		$html="";
		$html .= '<div class="submin-info">';
        $html .= '    	<img src="'.$base.'img/wc_xtb.png" />';
        $html .= '        <strong>成功</strong>';
        $html .= '        <span> </span><span>提交时间：'.$post_arr['createdate'].'</span>';
        $html .= '        <p>详细情况请点击：<a href="'.$base.'demand/demand_detail?id='.$demand_id.'" >查看详情</a></p>';
        $html .= '    </div>';
        $html .= '    <div class="other_title">相关设计产品</div>';
        $html .= '    <ul class="others">';
		foreach($result_s as $item){
            	 $html .= '<li><a href="'.$base.'design/design_detail?id='.$item['id'].'"><img width="130" height="107" src="'.$base.$base_photoupload_path.'temp/'.$item['design_pic'].'" /></a></li>';
	   }
        $html .= '    </ul>';

		echo $html;
	}

	function demandlist()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');

	   $data = array('base'=>$base);
	   $userid=$this->session->userdata('uId');

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($userid);
	   $data = array_merge($right_data,$data);

	   if($userid!='')$data['login'] = "login";

	    $demands=array();;
		$pre_msg_num = $this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('id,title,designnum,viewnum,messnum,createdate');
		$this->db->where('status',1);
		if(!empty($_GET['type']) && $_GET['type']==3){//最新一个月
			$this->db->where('createdate >',date("Y-m-d H:i:s", time()-86400*30));
		}
		if(!empty($_GET['type']) && $_GET['type']==4){//一个月前
			$this->db->where('createdate <',date("Y-m-d H:i:s", time()-86400*30));
		}
 		$t_query=$this->db->get('demand');
		$data['inbox_num']=	$t_query->num_rows();

		$this->db->where('status',1);
		if(empty($_GET['type'])){
			$this->db->order_by('createdate','desc');
		}elseif($_GET['type']==1){//由旧到新
			$this->db->order_by('createdate','asc');
		}elseif($_GET['type']==5){//按设计量多到少
			$this->db->order_by('designnum','desc');
		}else{//由新到旧
			$this->db->order_by('createdate','desc');
		}
		
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('demand'); 
		foreach($query->result_array() as $row)
		{
			array_push($demands,$row);
		}
		$data['demands'] = $demands;
		$data['pre_msg_num'] = $this->pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

		$this->db->select('id');
 		$d_query=$this->db->get('design');
		$data['t_designnum']=	$d_query->num_rows();

		$this->load->view('q2a/demandlist',$data);
	}
	
	function demand_detail()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');
	   $demand_id = $_GET['id'];

		$tmp=$this->session->userdata('dm'.$demand_id);
		if($tmp==''){
			//session
			$tmpsess=array();
			$tmpsess=$this->session->userdata;
			$tmpsess['dm'.$demand_id]=1;
			$this->session->set_userdata($tmpsess,'');
			//浏览量+1
			$this->Demand_management->update_viewnum($demand_id,1);
		}

	   //login permission check
	   //$this->Auth->permission_check("login/");
	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base);
	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

	   if($user_id!='')$data['login'] = "login";
	   $result=array();
	   $result=$this->Demand_management->get_user_demand($demand_id);
	   foreach($result as $val){
		   $data['demand']=$val;
	   }
		
		$this->db->select('id');
 		$t_query=$this->db->get('demand');
		$data['t_demandnum']=	$t_query->num_rows();


	    $this->db->select('id');
 		$d_query=$this->db->get('design');
		$data['t_designnum']=	$d_query->num_rows();


		//get designlist
		$designs=array();;
		$this->db->select('*');
		$this->db->where('demand_id',$demand_id);
		$this->db->order_by('createdate','desc');
		$query = $this->db->get('design');
		foreach($query->result_array() as $row)
		{
			array_push($designs,$row);
		}
		$data['designs'] = $designs;
		
		//get messagelist
	    $condition = array('uId'=>$data['demand']['uId'],'related_id'=>$demand_id,'p_md_Id'=>0,'sort_attr'=>'time','sort_type'=>0,'type'=>1);
	    $message_data = $this->Message_management->get_related_messages($condition);

		$message = array();
		//get second messagelist
		foreach($message_data as $val){
			$con = array('uId'=>$val['from_uId'],'related_id'=>$demand_id,'p_md_Id'=>$val['md_Id'],'sort_attr'=>'time','sort_type'=>0,'type'=>1);
			$sec_data = $this->Message_management->get_related_messages($con);
			if(!empty($sec_data)){
				$val['sec_data'] = $sec_data;
			}else{
				$val['sec_data'] =array();
			}
			array_push($message,$val);
		}
	    $data['message_data'] = $message;


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
		$this->db->select('*');
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
			$html .= '<ul class="main-list">';
			foreach($demands as $item){
				$i++;

				$html .= '	<li>';
				$html .= '		<a href="'.$base.'demand/demand_detail?id='.$item['id'].'" class="title">'. $i.'、'.$item['title'].'</a>';
				$html .= '		<div class="btns">';
				if($item['status']==0){
					$html .= '<a href="#" onclick="javascript:updatestatus('.$item['id'].',1);" >发布</a>';
				}else{
					$html .= '<a href="#" onclick="javascript:updatestatus('.$item['id'].',0);" class="black">不发布</a>';
				}
				$html .= '		<a href=""'.$base.'design/practice?id='.$item['id'].'"">去设计</a>';
				$html .= '		</div>';
				$html .= '		<p><span class="link link-sheji">设计（<a href="#">'.$item['designnum'].'</a>）</span><span class="link link-liulan">浏览（<a href="#">'.$item['viewnum'].'</a>）</span><span class="link link-liuyan">留言（<a href="#">'.$item['messnum'].'</a>）</span><span class="pull-right">发布于'.$item['createdate'].'</span></p>';
				$html .= '	</li>';
				
			}
			$html .= '</ul>';
		}
		echo $html;

	}



	function sort_demandlist()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
		$data = array('uId'=>$user_id,'range'=>$range);

		$demands=array();
		$this->db->select('*');
		$this->db->where('status',1);
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
			$html .= '<ul id="xuqiu-list">';
			foreach($demands as $item){
				$i++;
				$html .= '	<li>';
				$html .= '		<a class="title" href="'.$base.'demand/demand_detail?id='.$item['id'].'">'.$item['title'].'</a>';
				$html .= '		<ul class="views">';
				$html .= '			<li class="view">浏览（'.$item['viewnum'].'）</li>';
				$html .= '			<li class="design">设计（'.$item['designnum'].'）</li>';
				$html .= '		  </ul>';
				$html .= '		  <p></p>';
				$html .= '		  <span class="bottom"><font class="icon-tag">发布人：'.$item['username'].'</font> <font class="icon-clock">发布于'.$item['createdate'].'</font><font class="pull-right">三天后截止</font></span>';
				$html .= '	</li>';
			}
			$html .= '</ul>';
		}
		echo $html;

	}
	
	function update_status()
	{

		$demand_id = $this->input->post('demand_id',TRUE);
		$status = $this->input->post('status',TRUE);
		$this->Demand_management->update_status($demand_id,$status);

		echo '状态更新成功';

	   
	}


 }

 /*End of file*/
  /*Location: ./system/appllication/controller/design.php*/
