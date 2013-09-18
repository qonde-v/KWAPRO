<?php
  class User_information extends CI_Controller
  {
    function __construct()
     {
        parent::__construct();
         $this->load->helper('define');
         $this->load->helper('url');
         $this->load->database();
         $this->load->library('session');
         $this->load->model('q2a/Auth');
         $this->load->model('q2a/User_info');
         $this->load->model('q2a/User_privacy');
         $this->load->model('q2a/User_data');
         $this->load->model('q2a/Friend_manage');
         $this->load->model('q2a/Ip_location');
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Right_nav_data');
     }

     function index()
     {
        $base = $this->config->item('base_url');
        $language = $this->Ip_location->get_language();

        //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

       $segs = $this->uri->segment_array();
	   $f_uId = $segs[3];

       $data = array('base'=>$base);
	   $data['login'] = "login";
	   $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';
       $data['user_id'] = $user_id;
       $data['f_uId'] = $f_uId;

       $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);

       if($user_id == $f_uId)
       {
            redirect('profile');
       }

       if($this->Friend_manage->is_friendship_exist(array('uId'=>$user_id,'friend_uId'=>$f_uId)))
       {
            $info = $this->get_friend_info($f_uId,$language);
            $data = array_merge($data,$info,$right_data);
            $data['ask_data'] = $this->check_empty($data['ask_data'],$data['user_info_empty']);
            $data['answer_data'] = $this->check_empty($data['answer_data'],$data['user_info_empty']);
            $data['follow_data'] = $this->check_empty($data['follow_data'],$data['user_info_empty']);
            $data['friend_num'] = $this->User_data->get_user_friend_num($f_uId);
            $this->load->view('q2a/friend_info',$data);
       }
       else
       {
            $info = $this->get_user_info($f_uId,$language);
            $data = array_merge($data,$info,$right_data);
            $data['ask_data'] = $this->check_empty($data['ask_data'],$data['user_info_empty']);
            $data['answer_data'] = $this->check_empty($data['answer_data'],$data['user_info_empty']);
            $data['follow_data'] = $this->check_empty($data['follow_data'],$data['user_info_empty']);
            $this->load->view('q2a/user_info',$data);
       }
     }

     function check_empty($data,$msg)
     {
        if(!empty($data))
        {
            return $this->question_item_view($data[0]);
        }
        else
        {
            return $msg;
        }
     }

     function get_friend_info($f_uId,$lang)
     {
        $common_label = $this->Load_common_label->load_common_label($lang);
        $label = $this->load_friend_info_label($lang);
        $msg_label = $this->load_prompt_label($lang);
        $privacy_data = $this->User_privacy->get_user_privacy($f_uId);
        $friend_info = $this->User_info->get_friend_info($f_uId);

        if($privacy_data[GENDER] == 0)
        {//invisible
            $friend_info['gender'] = $label['user_info_secret'];
        }
        else
        {
            if($friend_info['gender'] == 1)
            {//male
                $friend_info['gender'] = $label['user_info_male'];
            }
            else
            {
                $friend_info['gender'] = $label['user_info_female'];
            }
        }
        if($privacy_data[BIRTHDAY] == 0)
        {//invisible
            $friend_info['birthday'] = $label['user_info_secret'];
        }

        $account_name_arr = array(EMAIL=>'email',GTALK=>'gtalk',SMS=>'sms',QQ=>'qq',MSN=>'msn');
        $account = $friend_info['account'];
        foreach($account_name_arr as $key => $value)
        {
            if(isset($account[$key]))
            {
                if($privacy_data[$key] == 0)
                {//invisible
                    $friend_info[$value] = $label['user_info_secret'];
                }
                else
                {
                    $friend_info[$value] = $account[$key];
                }
            }
            else
            {
                $friend_info[$value] = '';
            }
        }
        return array_merge($label,$friend_info,$common_label,$msg_label);
     }

     function get_user_info($f_uId,$lang)
     {
        $common_label = $this->Load_common_label->load_common_label($lang);
        $label = $this->load_friend_info_label($lang);
        $msg_label = $this->load_prompt_label($lang);
        $user_info = $this->User_info->get_user_info($f_uId);
        return array_merge($label,$user_info,$common_label,$msg_label);
     }

     function load_friend_info_label($lang)
     {
        $this->lang->load('user_info',$lang);
        $data['user_info_title'] = $this->lang->line('user_info_title');
        $data['user_info_male'] = $this->lang->line('user_info_male');
        $data['user_info_female'] = $this->lang->line('user_info_female');
        $data['user_info_username'] = $this->lang->line('user_info_username');
        $data['user_info_gender'] = $this->lang->line('user_info_gender');
        $data['user_info_basic_data'] = $this->lang->line('user_info_basic_data');
        $data['user_info_account'] = $this->lang->line('user_info_account');
        $data['user_info_private_tag'] = $this->lang->line('user_info_private_tag');
        $data['user_info_birthday'] = $this->lang->line('user_info_birthday');
        $data['user_info_location'] = $this->lang->line('user_info_location');
        $data['user_info_email'] = $this->lang->line('user_info_email');
        $data['user_info_kpc'] = $this->lang->line('user_info_kpc');
        $data['user_info_question_data'] = $this->lang->line('user_info_question_data');
        $data['user_info_ask_num'] = $this->lang->line('user_info_ask_num');
        $data['user_info_answer_num'] = $this->lang->line('user_info_answer_num');
        $data['user_info_follow_num'] = $this->lang->line('user_info_follow_num');
        $data['user_info_latest_ask'] = $this->lang->line('user_info_latest_ask');
        $data['user_info_latest_answer'] = $this->lang->line('user_info_latest_answer');
        $data['user_info_latest_follow'] = $this->lang->line('user_info_latest_follow');
        $data['user_info_friends'] = $this->lang->line('user_info_friends');
        $data['user_info_send_message'] = $this->lang->line('user_info_send_message');
        $data['user_info_add_friend'] = $this->lang->line('user_info_add_friend');
        $data['user_info_common_friend'] = $this->lang->line('user_info_common_friend');
        $data['user_info_secret'] = $this->lang->line('user_info_secret');
        $data['user_info_empty'] = $this->lang->line('user_info_empty');
        $data['user_info_more_friend'] = $this->lang->line('user_info_more_friend');
		
		$data['messages_new'] = $this->lang->line('messages_new');
        $data['messages_new_msg_to'] = $this->lang->line('messages_new_msg_to');
        $data['messages_new_subject'] = $this->lang->line('messages_new_subject');
        $data['messages_new_msg_body'] = $this->lang->line('messages_new_msg_body');
        $data['messages_new_msg_send'] = $this->lang->line('messages_new_msg_send');
		$data['messages_wait'] = $this->lang->line('messages_wait');
        return $data;
     }

     function question_item_view($data)
	{
		 if(!empty($data))
		 {
		   $data['base'] = $this->config->item('base_url');
           $data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
		   $data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);

		   //$data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
           $language = $this->Ip_location->get_language();
           $label = $this->load_question_item_label($language);
           $data = array_merge($data,$label);
		   return $this->load->view('q2a/mainleft/question_item',$data,true);
		 }
		 else
		 {
		   return "";
		 }
	}

    function load_question_item_label($lang)
    {
        $this->lang->load('questions',$lang);
         $data['question_views'] = $this->lang->line('question_views');
         $data['question_answers'] = $this->lang->line('question_answers');
         $data['question_participants'] = $this->lang->line('question_participants');
         $data['question_kp_dolors'] = $this->lang->line('question_kp_dolors');
         $data['question_followed'] = $this->lang->line('question_followed');
				$data['question_click_detail'] = $this->lang->line('question_click_detail');
        $data['instant_answer_title'] = $this->lang->line('instant_answer_title');
        $data['instant_answer_close'] = $this->lang->line('instant_answer_close');
        $data['instant_answer_empty'] = $this->lang->line('instant_answer_empty');
        $data['instant_answer_button'] = $this->lang->line('instant_answer_button');
         return $data;
    }

    function load_prompt_label($lang)
    {
        $this->lang->load('messages',$lang);
        $data['messages_click_button'] = $this->lang->line('messages_click_button');
        $data['messages_button_send'] = $this->lang->line('messages_button_send');

        $data['messages_new_message'] = $this->lang->line('messages_new_message');
        $data['messages_new_msg_close'] = $this->lang->line('messages_new_msg_close');
        $data['messages_new_user_not_found'] = $this->lang->line('messages_new_user_not_found');
        $data['messages_new_body_empty'] = $this->lang->line('messages_new_body_empty');
        $data['messages_new_length_limit'] = $this->lang->line('messages_new_length_limit');
        return $data;
    }

  }