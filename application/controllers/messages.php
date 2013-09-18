<?php
  class Messages extends CI_Controller
  {
  	var $pre_msg_num;

    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('prompt');
		 $this->load->database();
		 $this->load->library('session');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Message_management');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Right_nav_data');
         $this->load->model('q2a/Load_common_label');
		 $this->load->model('q2a/Check_process');
         $this->load->model('q2a/Ip_location');
	 }

	function index()
	{
	 //  $this->output->enable_profiler(TRUE);
	   $base = $this->config->item('base_url');
       $language = $this->Ip_location->get_language();

	   //check if user has been login
	   $this->Auth->permission_check("login/");
	   $user_id = $this->session->userdata('uId');
	   $data['base'] = $base;
	   $data['login'] = "login";

	   $data['view'] = $this->message_views_load($user_id);

	   $data['pre_msg_num'] = $this->get_pre_msg_num();

	   $data['inbox_num'] = $this->Message_management->get_inbox_msg_num($user_id);

	   $data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
       $label = $this->load_label($language);
	   $data = array_merge($right_data,$data,$label);

	   $this->load->view('q2a/message',$data);
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

	//load message html views
	function message_views_load($user_id)
	{
	   $html_view = "";

	   $pre_msg_num = $this->get_pre_msg_num();
	   $range = array('start'=>0,'end'=>$pre_msg_num-1);
	   $data = array('uId'=>$user_id,'sort_attr'=>'time','sort_type'=>0,'range'=>$range);
	   $message_data = $this->Message_management->get_user_messages($data);

	   if(count($message_data))
	   {
		   foreach($message_data as $key=>$message_item)
		   {
		      $message_item['base'] = $this->config->item('base_url');			
			  $html_view .= $this->load->view('q2a/mainleft/message_item',$message_item,true);
		   }

		   return $html_view;
	  }
	  else
	  {
	     //return "You have not message!";
		 return $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> NO_MESSAGE));
	  }
	}

    //
	function new_message()
	{
	   if($this->Auth->request_access_check())
	   {
          $language = $this->Ip_location->get_language();
	      $data = array();
		  $data['base'] = $this->config->item('base_url');
	      $label = $this->load_label($language);
		  $data = array_merge($data,$label);

		  $user_id = $this->input->post('user_id',TRUE);
		  $username = $this->input->post('username',TRUE);

		  $data['user_id'] = $user_id;
		  $data['username'] = $username;

		  echo $this->load->view('q2a/mainleft/new_message',$data,true);
	   }
	   else
	   {
	      echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	   }
	}
	
	function sort_message()
	{
		if($this->Auth->request_access_check())
		{
			$user_id = $this->session->userdata('uId');
			$sort_attr = $this->input->post('sort_attr',TRUE);
		    $index = $this->input->post('index',TRUE);
			$sort_type = $this->input->post('sort_type',TRUE);
			$pre_num = $this->config->item('pre_message_num');
		    $range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
			$data = array('uId'=>$user_id,'sort_attr'=>$sort_attr,'sort_type'=>$sort_type,'range'=>$range);
			echo $this->sorted_message_view_load($data);
		}
		else
	   	{
	      	echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	   	}
	}
	
	function sorted_message_view_load($data)
    {
     	$msg_view_data = $this->Message_management->get_user_messages($data);

     	$retStr = "";
	    foreach($msg_view_data as $item)
	    {
			$item['base'] = $this->config->item('base_url');
	      	$retStr .= $this->load->view('q2a/mainleft/message_item',$item,true);
	    }
	    return $retStr;
    }


    function load_label($lang)
    {
        $messages_label = $this->load_messages_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = array_merge($messages_label,$common_label);
        return $result;
    }

    function load_messages_label($lang)
    {
        $this->lang->load('messages',$lang);
        $data['messages_page_title'] = $this->lang->line('messages_page_title');
		
		$data['messages_private_label'] = $this->lang->line('messages_private_label');
        $data['messages_private_date'] = $this->lang->line('messages_private_date');
        $data['messages_private_sender'] = $this->lang->line('messages_private_sender');
        $data['messages_private_title'] = $this->lang->line('messages_private_title');
		
        $data['messages_messages'] = $this->lang->line('messages_messages');
        $data['messages_new'] = $this->lang->line('messages_new');
        $data['messages_search'] = $this->lang->line('messages_search');
        $data['messages_mark'] = $this->lang->line('messages_mark');
        $data['messages_delete'] = $this->lang->line('messages_delete');
        $data['messages_filter'] = $this->lang->line('messages_filter');
        $data['messages_select'] = $this->lang->line('messages_select');
        $data['messages_date'] = $this->lang->line('messages_date');
        $data['messages_user'] = $this->lang->line('messages_user');
        $data['messages_unread'] = $this->lang->line('messages_unread');
		$data['messages_back2messageinbox'] = $this->lang->line('messages_back2messageinbox');

		$data['message_inbox_button'] = $this->lang->line('message_inbox_button');
        $data['message_outbox_button'] = $this->lang->line('message_outbox_button');
		$data['messages_delete_confirm'] = $this->lang->line('messages_delete_confirm');
		$data['messages_check_empty'] = $this->lang->line('messages_check_empty');
        //new message
        $data['messages_new_message'] = $this->lang->line('messages_new_message');
        $data['messages_new_msg_to'] = $this->lang->line('messages_new_msg_to');
        $data['messages_new_msg_subject'] = $this->lang->line('messages_new_msg_subject');
        $data['messages_new_msg_body'] = $this->lang->line('messages_new_msg_body');
        $data['messages_new_msg_send'] = $this->lang->line('messages_new_msg_send');
        $data['messages_new_msg_reset'] = $this->lang->line('messages_new_msg_reset');
        $data['messages_new_msg_close'] = $this->lang->line('messages_new_msg_close');
		$data['messages_wait'] = $this->lang->line('messages_wait');

        $data['messages_new_user_not_found'] = $this->lang->line('messages_new_user_not_found');
		$data['messages_new_title_empty'] = $this->lang->line('messages_new_title_empty');
        $data['messages_new_body_empty'] = $this->lang->line('messages_new_body_empty');
        $data['messages_new_length_limit'] = $this->lang->line('messages_new_length_limit');
        $data['messages_new_subject'] = $this->lang->line('messages_new_subject');

		//load prompt label
		$this->lang->load('prompt',$lang);
        $data['messages_select_first'] = $this->lang->line('message_6');
        $data['messages_read_confirm'] = $this->lang->line('message_5');
		$data['messages_delete_confirm'] = $this->lang->line('message_9');
		$data['messages_nothing_input'] = $this->lang->line('common_22');
        return $data;
    }
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/messages.php*/
