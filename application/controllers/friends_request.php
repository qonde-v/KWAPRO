<?php
  class Friends_request extends CI_Controller
  {
     function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');
         $this->load->helper('prompt');

		 $this->load->database();
		 $this->load->library('session');
		 $this->load->library('account_format_check');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Send_mail');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Search');
		 $this->load->model('q2a/Friend_finder');
		 $this->load->model('q2a/Friend_invite');
		 $this->load->model('q2a/Friend_manage');
		 $this->load->model('q2a/Invite_data_process');
		 $this->load->model('q2a/Kpc_manage');
         $this->load->model('q2a/Check_process');
	 }

	 //invite friends to be a kwapro-er by sending invite emails
	 function invite_friends()
	 {
	    //todo:
		if($this->Auth->request_access_check())
		{
		   //todo:
		   //$email_string = $_POST['email'];
           $email_str = $this->input->post('email',TRUE);
           $email_string = $email_str ? $email_str : '';
           $code = $this->Check_process->email_check($email_string);
		   $email_arr = explode('|',$email_string);
		  // print_r($email_arr);
          // echo "====>".$code;
		   if($code == INVITE_PROCESSED)
		   {
		     if($this->account_format_check->email_format_check($email_arr))
			 {
			      $msg_text = "";
			      $base = $this->config->item('base_url');
				  $user_id = $this->session->userdata('uId');
				  $username = $this->User_data->get_username(array('uId'=>$user_id));

				  foreach($email_arr as $email)
				  {
				     if(!$this->Invite_data_process->is_account_exist($email))
					 {
					    $this->Kpc_manage->kpc_update_process(array('uId'=>$user_id,'kpc_value'=>KPC_VALUE_INVITE_USER,'kpc_type'=>KPC_TYPE_INVITE_USER));
					    $invite_code = $this->Invite_data_process->create_invite_data(array('account'=>$email,'user_id'=>$user_id));
					    $email_data = $this->Invite_data_process->generate_invite_email(array('invite_code'=>$invite_code,'url'=>$base.'register/','username'=>$username,'account'=>$email));
					    //print_r($email_data);
						$this->Send_mail->send_common_mail(array('account'=>$email,'subject'=>$email_data['subject'],'text'=>$email_data['text']));
					 }
					 else
					 {
					    $msg_text .= sprintf($this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> INVITE_SENT_ALREADY)),$email);
					 }
				  }
				  echo $msg_text ? $msg_text : $this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> INVITE_PROCESSED));
			 }//if
			 else
			 {
			    echo $this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> WRONG_EMAIL_FORMAT));
			 }
		   }//if
		   else
		   {
                $ext_str = ($code == NOTHING_INPUT) ? "common" : "friend";
                //echo  $ext_str."_".$code;
                echo $this->Check_process->get_prompt_msg(array('pre'=>$ext_str,'code'=>$code));
           }
		}
		else
		{
		   echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	 }

	 //
	 function search_by_name()
	 {
	     if($this->Auth->request_access_check())
		 {
		   //$match_str = $_POST['param'];
           $match_string = $this->input->post('param',TRUE);
           $match_str = $match_string ? $match_string : '';
           $base = $this->config->item('base_url');
		   if($match_str)
		   {
		      $match_str = strtolower($match_str);
			  $user_data = $this->Search->search_username(array('match_str'=>$match_str,'match_type'=>MATCH_INCLUDE));
			  if(count($user_data))
			  {
				  $html_str = "";
			      $base = $this->config->item('base_url');
				  $cur_user_id = $this->session->userdata('uId');
				  foreach ($user_data as $key => $value)
				  {
					 if($cur_user_id != $key)
					 {
				         $headphoto_path = $base.$this->User_data->get_user_headphotopath($key);
						 $tags = array_slice($this->User_data->get_user_private_tag_data($key),0,5);
						 $html = "<div class='q_tags'>";
						   foreach($tags as $tag)
						   {
						   		$html .= "<a class='label'>".$tag['tag_name']."</a>";
						   }
						   $html .= "</div>";
					     $data = array('base'=>$base,'check_name'=>'searchBYname_check', 'headphoto_path'=>$headphoto_path, 'username'=>$value, 'user_id'=>$key,'tag_html'=>$html);
					     $html_str .= $this->load->view('q2a/mainleft/friend_user_item',$data,true);
					  }
				  }
				  echo $html_str;
			  }
			  else
			  {
                $msg = $this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> NO_USER_MATCH));
			     echo "##".$msg."##";
			  }
		   }
           else
           {
                $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> NOTHING_INPUT));
			     echo "##".$msg."##";
           }
         }
	 }

	 //search user by topic,inclue category and sub category
	 function search_by_topic()
	 {
	     //todo:
		 //echo $_POST['topic_id']."|".$_POST['topic_type'];
		if($this->Auth->request_access_check())
		{
            $post_arr = array();
            $base = $this->config->item('base_url');
            foreach($_POST as $key=>$value)
            {
                $post_value = $this->input->post($key,TRUE);
                $post_arr[$key] = $post_value ? $post_value : 0;
            }
		   $user_data = $this->Friend_finder->find_friend_in_topic(array('topic_id'=>$post_arr['topic_id'],'topic_type'=>$post_arr['topic_type']));
		   if(count($user_data))
		   {
				  $html_str = "";
			      $base = $this->config->item('base_url');
				  $cur_user_id = $this->session->userdata('uId');
				  foreach ($user_data as $item)
				  {
				     list($user_id,$username,$headphoto_path,$tag_html) = $item;
				     if($cur_user_id != $user_id)
					 {
					    $data = array('base'=>$base,'check_name'=>'searchBYtopic_check', 'headphoto_path'=>$base.$headphoto_path, 'username'=>$username, 'user_id'=>$user_id,'tag_html'=>$tag_html);
					    $html_str .= $this->load->view('q2a/mainleft/friend_user_item',$data,true);
					 }
				  }
				  echo $html_str;
		  }
		  else
		  {
			 //echo "no user match the condition.";
			 echo $this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> NO_USER_MATCH));
		  }
		}
	 }

	 //search user by their location information
	 function search_by_location()
	 {
	    //todo:
		if($this->Auth->request_access_check())
		{
            $post_arr = array();
            $base = $this->config->item('base_url');
            foreach($_POST as $key=>$value)
            {
                $post_value = $this->input->post($key,TRUE);
                $post_arr[$key] = $post_value ? $post_value : 0;
            }
		   $key = $post_arr['key'];
		   $value = $post_arr['value'];
		   $user_data = $this->Friend_finder->find_friend_in_location(array($key=>$value));
		   if(count($user_data))
		   {
				  $html_str = "";
			      $base = $this->config->item('base_url');
				  $cur_user_id = $this->session->userdata('uId');
				  foreach ($user_data as $item)
				  {
				      list($user_id,$username,$headphoto_path,$tag_html) = $item;
				      if($cur_user_id != $user_id)
					  {
						  $data = array('base'=>$base,'check_name'=>'searchBYlocation_check', 'headphoto_path'=>$base.$headphoto_path, 'username'=>$username, 'user_id'=>$user_id,'tag_html'=>$tag_html);
						  $html_str .= $this->load->view('q2a/mainleft/friend_user_item',$data,true);
                      }
				  }
				  echo $html_str;
		  }
		  else
		  {
			 //echo "no user match the condition.";
			 echo $this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> NO_USER_MATCH));
		  }
		}
	 }

	 //send the request of add as friend
	 function add_as_friend_request()
	 {
	    if($this->Auth->request_access_check())
		{
           $friend_id_string = $this->input->post('friend',TRUE);
           $friend_id_arr = $friend_id_string ? explode(',',$friend_id_string) : array();

           $user_id = $this->input->post('uId',TRUE);
		   $user_id = empty($user_id) ? $this->session->userdata('uId') : $user_id;

		   $msg_arr = $this->Friend_manage->friend_request_update($user_id, $friend_id_arr);

		   if(count($msg_arr))
		   {
		      echo $this->Friend_manage->error_print($msg_arr);
		   }
		   else
		   {
		      //echo "ADD SUCCESSED.";
			  echo $this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> REQUEST_SENT));
		   }
		 }
	   }

		//process the request of add as friend
		function friend_request_process()
		{
			if($this->Auth->request_access_check())
			{
	           $friend_id_string = $this->input->post('friend',TRUE);
	           $friend_id_arr = $friend_id_string ? explode(',',$friend_id_string) : array();

			   $user_id = $this->session->userdata('uId');
			   $msg_arr = $this->Friend_manage->add_as_freind_process($user_id, $friend_id_arr);
			   $this->Friend_invite->batch_delete_invite_request(array('from_uId'=>$friend_id_arr, 'to_uId'=>$user_id));

			   if(count($msg_arr))
			   {
			      echo $this->Friend_manage->error_print($msg_arr);
			   }
			   else
			   {
			      //echo "ADD SUCCESSED.";
				  echo $this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> ADD_SUCCESS));
			   }
			}
	    }

        //process the ignore of friends request
		function friend_ignore_process()
		{
			if($this->Auth->request_access_check())
			{
	           $friend_id_string = $this->input->post('friend',TRUE);
	           $friend_id_arr = $friend_id_string ? explode(',',$friend_id_string) : array();

			   $user_id = $this->session->userdata('uId');
			   $this->Friend_invite->batch_delete_invite_request(array('from_uId'=>$friend_id_arr, 'to_uId'=>$user_id));

			    echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PROCESS_SUCCESS));
			}
	    }

	    //request the friend list for user
	    function friend_list_request()
	    {
	    	if($this->Auth->request_access_check())
			{
			   $user_id = $this->session->userdata('uId');
			   $user_data = $this->User_data->get_user_friends($user_id);

			   $html_str = "<div class=\"friends_list\">";
		       $base = $this->config->item('base_url');
			  //print_r($user_data);
			   foreach ($user_data as $item)
			   {
			   		$data = array('base'=>$base,'check_name'=>'','headphoto_path'=>$base.$item['headphoto_path'], 'username'=>$item['username'], 'user_id'=>$item['user_id']);
				    $html_str .= $this->load->view('q2a/mainleft/friend_user_item',$data,true);
			   }
			   $html_str .= "</div>";
			   echo $html_str;
			}
	    }

  }//END OF CLASS

/*End of file*/
/*Location: ./system/appllication/controller/friends_request.php*/
