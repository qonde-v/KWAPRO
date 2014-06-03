<?php
  class Messages_request extends CI_Controller
  {
  	 var $pre_msg_num;
     function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('prompt');

		 $this->load->library('session');
		 $this->load->library('language_translate');

		 //$this->load->model('q2a/Dialog_event');
		 $this->load->model('q2a/Db_event_operate');
		 $this->load->model('q2a/Question_follow');
		 $this->load->model('q2a/Search');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Message_manage');
		 $this->load->model('q2a/Message_management');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Check_process');
         $this->load->model('q2a/Ip_location');
	 }

     //get the message number that display in a page from configure file
     function get_pre_msg_num()
     {
     	if(empty($this->pre_msg_num))
     	{
     	   $this->pre_msg_num = $this->config->item('pre_message_num');
     	}
     	return $this->pre_msg_num;
     }

	 //process the event: message submit
	 function send_message()
	 {
	   if($this->Auth->request_access_check())
	   {
	      $from_user_id = $this->session->userdata('uId');

          $post_arr = array();
		  foreach($_POST as $key=>$value)
		  {
                $post_value = $this->input->post($key,TRUE);
                $post_arr[$key] = $post_value ? $post_value : 0;
		  }
		  $to_user_id = $post_arr['uId'];
		  if($to_user_id != '')
		  {
		  	$data = array('from_uId'=>$from_user_id,'title'=>$post_arr['title'], 'content'=>str_replace("\n","<BR/>",$post_arr['content']),'to_uId'=>$to_user_id,
			'type'=>$post_arr['type'],'related_id'=>$post_arr['related_id']);
			$time = time();
			$data['message_id'] = $time.'_'.$data['from_uId'].'_'.$data['to_uId'];
			$data['time'] = date("Y-m-d H:i:s", $time);
			$data['stId'] = ONLINE;
			$data['sendPlace'] = '';
			  //print_r($data);
			 $message_id = $this->Message_management->message_reply($data);
			 //$event_id = $this->Db_event_operate->event_insert(array('nId'=>$node_id,'event_type'=>EVENT_TYPE_CONTENT));
	
			  //echo "Message send successed!";
			 echo $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> MESSAGE_SEND_SUCCESS));
		  }
		  else
		  {
		  	echo $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> USERNAME_NOT_EXIST));
		  }
	   }
	 }

	  //get username that match the input word
	 function message_username_search()
	 {
	     if($this->Auth->login_check())
		 {
	       $segs = $this->uri->segment_array();
		   $match_str = $segs[3];
		   if($match_str)
		   {
		      $match_str = strtolower($match_str);
			  $username_data = $this->Search->search_username(array('match_str'=>$match_str,'match_type'=>MATCH_INCLUDE));

			  $i = 0;
			  $html_str = "";
			  foreach ($username_data as $key => $value)
			  {
				 //echo "$value|$key\n";
				 $i++;
				 $html_str .= "<li id='li_".$i."' value='".$key."'>".$value."</li>";
			  }
			  echo $i."##".$html_str;
		   }
		   else
		   {
		      echo "##";
		   }
         }
	 }

	 //process the event: update the stat of message item
	 function message_request_read()
	 {
	     if($this->Auth->request_access_check())
		 {
	       //$segs = $this->uri->segment_array();
		   //$param_str = $segs[3];
		   //$param_str = $_POST['id'];
           $param_str = $this->input->post('id',TRUE);
		   $uId = $this->session->userdata('uId');
		   if($param_str)
		   {
		     $message_id_arr  = explode(',', $param_str);
			 $data = array();
			 foreach($message_id_arr as $message_id)
			 {
			 	array_push($data,array('message_id'=>$message_id,'to_uId'=>$uId));
			 }
			 $this->Message_management->message_stat_update(READ,$data);
			 //echo "STAT CHANGE SUCCESSED.";
			 echo $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> STAT_CHANGE_SUCCESS));
		   }
         }
	 }

	 //process the event: message item delete
	 function message_request_delete()
	 {
	     if($this->Auth->request_access_check())
		 {
	       //$segs = $this->uri->segment_array();
		   //$param_str = $segs[3];
		   //$param_str = $_POST['id'];
           $param_str = $this->input->post('id',TRUE);
		   $uId = $this->session->userdata('uId');
		   if($param_str)
		   {
		      $message_id_arr  = explode(',', $param_str);
			  $data = array();
			  foreach($message_id_arr as $message_id)
			  {
			  	array_push($data,array('message_id'=>$message_id,'to_uId'=>$uId));
			  }
			  $this->Message_management->message_delete($data);
			  //echo "DELETE SUCCESSED.";
			  echo $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> DELETE_SUCCESS));
		   }
         }
	 }

	//
	function message_request_inbox()
	{
	    if($this->Auth->request_access_check())
		{
		   $html_view = "";

		   $index = $this->input->post('index', TRUE);
		   $index = empty($index) ? 1 : $index;
		   $pre_msg_num = $this->get_pre_msg_num();
		   $range = array('start'=>($index-1)*$pre_msg_num,'end'=>$index*$pre_msg_num-1);

		   $user_id = $this->session->userdata('uId');

		   $message_data = $this->Message_manage->message_data_load($user_id,$range);

		   if(count($message_data))
		   {
			   foreach($message_data as $key=>$message_item)
			   {
				  $message_item['base'] = $this->config->item('base_url');
				  $message_item['userphoto_path'] = $this->User_data->get_user_headphotopath($message_item['uId']);
				  $html_view .= $this->load->view('q2a/mainleft/message_item',$message_item,true);
			   }

			   echo $html_view;
		  }
		  else
		  {
			 //echo "You have not message!";
			 echo $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> NO_MESSAGE));
		  }
		}//if
		else
		{
		   //echo "PERMISSION DENIED.";
		    echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	}

    //
    function message_request_outbox()
    {
    	if($this->Auth->request_access_check())
		{
		   $html_view = "";

		   $index = $this->input->post('index', TRUE);
		   $index = empty($index) ? 1 : $index;
		   $pre_msg_num = $this->get_pre_msg_num();
		   $range = array('start'=>($index-1)*$pre_msg_num,'end'=>$index*$pre_msg_num-1);

		   $user_id = $this->session->userdata('uId');
		   $message_data = $this->Message_manage->out_message_data_load($user_id,$range);

		   if(count($message_data))
		   {
			   foreach($message_data as $key=>$message_item)
			   {
				  $message_item['base'] = $this->config->item('base_url');
				  $message_item['userphoto_path'] = $this->User_data->get_user_headphotopath($message_item['uId']);
				  $html_view .= $this->load->view('q2a/mainleft/message_item',$message_item,true);
			   }

			   echo $html_view;
		  }
		  else
		  {
			 //echo "You have not message!";
			 echo $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> NO_MESSAGE));
		  }
		}//if
		else
		{
		   //echo "PERMISSION DENIED.";
		    echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
    }


	//get message item data by message id
	function message_request_item_data()
	{
	   if($this->Auth->request_access_check())
	   {
	      //$message_id = $_POST['message_id'];
          $message_id = $this->input->post('message_id',TRUE);
		  $stat = $this->input->post('is_stat_change',TRUE);
          $message_id = $message_id ? $message_id : 0;

		  $user_id = $this->session->userdata('uId');
		  if($this->Message_manage->message_visible_check(array('user_id'=>$user_id,'message_id'=>$message_id)))
		  {
		     $data = $this->Message_manage->message_read($message_id,$stat);
			 //print_r($data);
			 $html_str = "";
			 $node_id = 0;
			 foreach($data as $item)
			 {
			    $node_id = $item['nId'];
			    $item['base'] = $this->config->item('base_url');
				$item['userphoto_path'] = $this->User_data->get_user_headphotopath($item['uId']);
			    $html_str .= $this->load->view('q2a/mainleft/message_content',$item,true);
			 }
             $language = $this->Ip_location->get_language();
			  $this->lang->load('prompt',$language);
			  $messages_nothing_input = $this->lang->line('common_22');
			  $this->lang->load('messages',$language);
			  $send_text = $this->lang->line('messages_new_msg_send');
			  $reset_text = $this->lang->line('messages_new_msg_reset');
			  $message_reply_label = $this->lang->line('messages_reply');

			 $html_str .= $this->load->view('q2a/mainleft/message_reply_form',array('message_id'=>$message_id,'node_id'=>$node_id,'messages_nothing_input'=>$messages_nothing_input,'message_reply_send'=>$send_text,'message_reply_label'=>$message_reply_label,'message_reply_reset'=>$reset_text),true);
			 echo $html_str;
		  }
	   }
	}

	//process the event: message reply
	function message_reply_process()
	{
	   if($this->Auth->request_access_check())
	   {
            $post_arr = array();
            foreach($_POST as $key=>$value)
            {
                $post_value = $this->input->post($key,TRUE);
                $post_arr[$key] = $post_value ? $post_value : 0;
            }
			$post_arr['content'] = str_replace("\n","<BR/>",$post_arr['content']);
		  	$post_arr['stId'] = ONLINE;
			$post_arr['time'] = date("Y-m-d H:i:s", time());
			$post_arr['sendPlace'] = '';
			
			$this->Message_management->message_reply($post_arr);

		  	echo $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> MESSAGE_REPLY_SUCCESSED))."##".$post_arr['time'];
	   }
	}


	//
	function message_search()
	{
	   if($this->Auth->request_access_check())
	   {
			//$keyword = strtolower($_POST['keyword']);
            $keyword = $this->input->post('keyword',TRUE);
            $keyword = $keyword ? strtolower($keyword) : '';
			$user_id = $this->session->userdata('uId');
			$message_data = $this->Message_manage->message_search(array('keyword'=>$keyword,'user_id'=>$user_id));

			if(count($message_data))
		    {
			   $html_view = '';
			   foreach($message_data as $key=>$message_item)
			   {
				  $message_item['base'] = $this->config->item('base_url');
				  $message_item['userphoto_path'] = $this->User_data->get_user_headphotopath($message_item['uId']);
				  $html_view .= $this->load->view('q2a/mainleft/message_item',$message_item,true);
			   }

			   echo $html_view;
		   }//if
		   else
		   {
			   $msg = $this->Check_process->get_prompt_msg(array('pre'=>'message','code'=> NO_MESSAGE));
			   echo "##$msg##";//not result matched
		   }
	   }//if
	   else
	   {
	       $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	       echo "##$msg##";//permission denied.
	   }
	}


  }//END OF CLASS
