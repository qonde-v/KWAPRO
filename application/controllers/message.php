<?php

class Message extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		
		$this->load->model('q2a/Auth');
		$this->load->model('q2a/Right_nav_data');
		$this->load->model('q2a/Load_common_label');
		$this->load->model('q2a/Check_process');
		$this->load->model('q2a/Ip_location');
		$this->load->model('q2a/Message_management');
		$this->load->model('q2a/User_data');
	}
	
	function index()
	{
	}
	
	function detail()
	{
		$base = $this->config->item('base_url');
       	$language = $this->Ip_location->get_language();
		$segs = $this->uri->segment_array();
		$data['message_id'] = $segs[2];

	   	//check if user has been login
	   	$this->Auth->permission_check("login/");
	   	$user_id = $this->session->userdata('uId');
	   	$data['base'] = $base;
	   	$data['login'] = "login";
		$data['user_id'] = $user_id;
		
		$data['message_manage_data'] = $this->Message_management->load_message_manage_data(array('message_id'=>$data['message_id'],'to_uId'=>$user_id));
		$data['message_data'] = $this->Message_management->load_message_data($data['message_id']);
		
		if($data['message_manage_data']['from_uId'] == $user_id)
		{
			$data['type'] = 'outbox';
			$data['msg_user_id'] = $data['message_manage_data']['to_uId'];
		}
		else
		{
			$data['type'] = 'inbox';
			$data['msg_user_id'] = $data['message_manage_data']['from_uId'];
		}
		$data['msg_user_username'] = $this->User_data->get_username(array('uId'=>$data['msg_user_id']));
		$data['msg_user_headphoto'] = $this->User_data->get_user_headphotopath($data['msg_user_id']);
		$data['message_view'] = $this->generate_message_view($data);

	   	$right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
       	$label = $this->load_label($language);
	   	$data = array_merge($right_data,$data,$label);

	   	$this->load->view('q2a/message_detail',$data);
	}
	
	function load_label($lang)
	{
		$this->lang->load('messages',$lang);
		$data['message_detail_page_title'] = $this->lang->line('message_detail_page_title');
		$data['messages_back2messageinbox'] = $this->lang->line('messages_back2messageinbox');
        $data['messages_reply'] = $this->lang->line('messages_reply');
		$data['messages_new_body_empty'] = $this->lang->line('messages_new_body_empty');
		$data['messages_wait'] = $this->lang->line('messages_wait');
		$data['messages_in_msg_title1'] = $this->lang->line('messages_in_msg_title1');
		$data['messages_in_msg_title2'] = $this->lang->line('messages_in_msg_title2');
        $data['messages_out_msg_title1'] = $this->lang->line('messages_out_msg_title1');
		$data['messages_out_msg_title2'] = $this->lang->line('messages_out_msg_title2');
		
		$common_label = $this->Load_common_label->load_common_label($lang);
		return array_merge($data,$common_label);
	}
	
	function generate_message_view($data)
	{
		$html = '';
		foreach($data['message_data'] as $message_item)
		{
			$message_item['username'] = $data['msg_user_username'];
			$message_item['uId'] = $data['msg_user_id'];
			$html .= $this->load->view('q2a/mainleft/message_detail_item',$message_item,TRUE);
		}
		return $html;
	}
}