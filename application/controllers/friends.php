<?php
  class Friends extends CI_Controller
  {
    var $pre_friend_num = 0;

    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->database();
		 $this->load->library('session');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/Right_nav_data');
		 $this->load->model('q2a/Tag_process');
		 $this->load->model('q2a/Load_common_label');
		 $this->load->model('q2a/Friend_finder');
		 $this->load->model('q2a/Friend_manage');
         $this->load->model('q2a/Ip_location');
	 }

	function index()
	{
	   $data = array();
	   $user_id = "";
       $language = $this->Ip_location->get_language();
	   $data['base'] = $this->config->item('base_url');
	   $this->Auth->permission_check("login/");
	   $user_id = $this->session->userdata('uId');
	   $data['login'] = "login";
	   $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';
	   $data['my_friends'] = $this->User_data->get_user_friends($user_id);

       $data['my_friend_request'] = $this->Friend_finder->get_invite_request_userdata($user_id);
		$data['category_data'] = $this->Load_common_label->load_category_data($language);
		$data['language'] = $language;
		$data['permission'] = $this->User_data->get_invite_permission($user_id);

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $label_data = $this->load_label($language);
	   $data = array_merge($right_data,$data,$label_data);
	   $this->load->view('q2a/friends',$data);
	}

	function load_label($lang)
    {
        $friends_label = $this->load_friends_label($lang);
		$friend_msg_label = $this->load_prompt_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
		$user_info_label = $this->load_user_info_label($lang);
        $result = array_merge($friends_label,$common_label,$friend_msg_label,$user_info_label);
        return $result;
    }

	//
	function friendship()
	{
	    $data = array();
		$data['base'] = $this->config->item('base_url');
        $language = $this->Ip_location->get_language();
	    $this->Auth->permission_check($data['base']."login/");
	    $segs = $this->uri->segment_array();
	    $f_uId = $segs[3];
	    $user_id = $this->session->userdata('uId');

		$data['login'] = "login";
	    $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';

        $data['friend_num'] = $this->User_data->get_user_friend_num($f_uId);

        $pre_friend_num = $this->get_pre_friend_num();
	    $data['is_split'] = ($data['friend_num'] > $pre_friend_num) ? 1 : 0;

        $data['friend_num_per'] = floor($data['friend_num']/$pre_friend_num);
        if($data['friend_num']%$pre_friend_num != 0 || $data['friend_num'] == 0)
        {
        		$data['friend_num_per']++;
        }

		//$data['friend_data'] = $this->User_data->get_user_friend_browse_data($f_uId);
        $data['friend_data'] = $this->friend_data_load($f_uId);
		$data['username'] = $this->User_data->get_username(array('uId'=>$f_uId));
		$data['cur_user_id'] = $user_id;
        $data['f_uId'] = $f_uId;

		$right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	    $label_data = $this->friendship_load_label($language);
	    $data = array_merge($right_data,$data,$label_data);
	    $this->load->view('q2a/friendship',$data);
	}

    //return the number of friends that display in page
	function get_pre_friend_num()
	{
	    if($this->pre_friend_num === 0)
		{
		    $this->pre_friend_num = $this->config->item('pre_friend_num');
		}
		return $this->pre_friend_num;
	}

    function call_friendship_load()
	{
        $segs = $this->uri->segment_array();
        $f_uId = $segs[3];
	   echo $this->friend_data_load($f_uId);
	}

    function friend_data_load($f_uId)
    {
        $index = isset($_POST['index']) ? $_POST['index'] : 1;
	    $pre_friend_num = $this->get_pre_friend_num();
	    $range = array('start'=>($index-1)*$pre_friend_num, 'end'=>$index*$pre_friend_num-1);
        //$range = '';

	   $data = $this->User_data->get_user_friend_browse_data($f_uId,$range);

	   $retStr = "";
	   foreach($data as $item)
	   {
	      $retStr .= $this->friend_item_view($item);
	   }
	   return $retStr;
    }

    //load data to friend item view,and return html string
	function friend_item_view($data)
	{
		 if(!empty($data))
		 {
		   $data['base'] = $this->config->item('base_url');

		   //$data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
           $language = $this->Ip_location->get_language();
           $label = $this->load_friend_item_label($language);
           $data = array_merge($data,$label);
		   return $this->load->view('q2a/mainleft/friend_item',$data,true);
		 }
		 else
		 {
		   return "";
		 }
	}

    function load_friend_item_label($lang)
    {
        $this->lang->load('friends',$lang);
        $data['friendship_basic_information'] = $this->lang->line('friendship_basic_information');
        $data['friendship_location'] = $this->lang->line('friendship_location');
        $data['friendship_label_question'] = $this->lang->line('friendship_label_question');
        $data['friendship_label_answer'] = $this->lang->line('friendship_label_answer');
        $data['friendship_label_follow'] = $this->lang->line('friendship_label_follow');
        $data['friendship_label_kpc'] = $this->lang->line('friendship_label_kpc');
        $data['friendship_follow_tag'] = $this->lang->line('friendship_follow_tag');
        $data['friendship_loc_empty'] = $this->lang->line('friendship_loc_empty');
        $data['friendship_tag_empty'] = $this->lang->line('friendship_tag_empty');
        return $data;
    }

	function load_user_info_label($lang)
	{
		$this->lang->load('user_info',$lang);
		$data['user_info_kpc'] = $this->lang->line('user_info_kpc');
        $data['user_info_ask_num'] = $this->lang->line('user_info_ask_num');
        $data['user_info_answer_num'] = $this->lang->line('user_info_answer_num');
        $data['user_info_location'] = $this->lang->line('user_info_location');
		return $data;
	}

	//
	function friendship_load_label($lang)
	{
	    $friends_label = $this->friendship_load_FS_label($lang);
		$friend_msg_label = $this->load_prompt_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = array_merge($friends_label,$common_label,$friend_msg_label);
        return $result;
	}

	//
	function friendship_load_FS_label($lang)
	{
	    //todo:
        $this->lang->load('friends',$lang);
        $data['friendship_page_title'] = $this->lang->line('friendship_page_title');
        $data['friendship_head_first_part'] = $this->lang->line('friendship_head_first_part');
        $data['friendship_head_second_part'] = $this->lang->line('friendship_head_second_part');
        return $data;

	}

	//
	function load_friends_label($lang)
	{
	    $this->lang->load('friends',$lang);

        $data['friends_page_title'] = $this->lang->line('friends_page_title');

        $data['friends_title_all_info'] = $this->lang->line('friends_title_all_info');
        $data['friends_title_invite_info'] = $this->lang->line('friends_title_invite_info');
        $data['friends_title_find_info'] = $this->lang->line('friends_title_find_info');
        $data['friends_title_request_info'] = $this->lang->line('friends_title_request_info');
		
		$data['friends_title_all_friends'] = $this->lang->line('friends_title_all_friends');
        $data['friends_title_invite_friends'] = $this->lang->line('friends_title_invite_friends');
        $data['friends_title_find_friends'] = $this->lang->line('friends_title_find_friends');
        $data['friends_title_friends_request'] = $this->lang->line('friends_title_friends_request');

        $data['tips_no_friend_request'] = $this->lang->line('tips_no_friend_request');

        $data['friends_all_label'] = $this->lang->line('friends_all_label');

        $data['friends_invite_label'] = $this->lang->line('friends_invite_label');
        $data['friends_invite_email'] = $this->lang->line('friends_invite_email');
		$data['friends_invite_placeholder'] = $this->lang->line('friends_invite_placeholder');
        $data['friends_invite_reset'] = $this->lang->line('friends_invite_reset');
        $data['friends_invite_send_invitation'] = $this->lang->line('friends_invite_send_invitation');
		$data['friends_invite_permission'] = $this->lang->line('friends_invite_permission');

        $data['friends_find_by_topic'] = $this->lang->line('friends_find_by_topic');
        $data['friends_find_by_location'] = $this->lang->line('friends_find_by_location');
        $data['friends_find_by_name'] = $this->lang->line('friends_find_by_name');

        $data['friends_find_topic_title'] = $this->lang->line('friends_find_topic_title');
        $data['friends_find_topic_category'] = $this->lang->line('friends_find_topic_category');
        $data['friends_find_topic_subcategory'] = $this->lang->line('friends_find_topic_subcategory');

        $data['friends_find_location_title'] = $this->lang->line('friends_find_location_title');
        $data['friends_find_location_country'] = $this->lang->line('friends_find_location_country');
        $data['friends_find_location_state'] = $this->lang->line('friends_find_location_state');
        $data['friends_find_location_city'] = $this->lang->line('friends_find_location_city');

        $data['friends_find_name_title'] = $this->lang->line('friends_find_name_title');
        $data['friends_find_name_input'] = $this->lang->line('friends_find_name_input');
        $data['friends_find_name_search_button'] = $this->lang->line('friends_find_name_search_button');

        $data['friends_search_result'] = $this->lang->line('friends_search_result');
        $data['friends_add_button'] = $this->lang->line('friends_add_button');
        $data['friends_ignore_request'] = $this->lang->line('friends_ignore_request');

        $data['friends_sending_wait'] = $this->lang->line('friends_sending_wait');

        $data['friends_request_label'] = $this->lang->line('friends_request_label');
		$data['friends_request_confirm'] = $this->lang->line('friends_request_confirm');

		//load prompt label
		$this->lang->load('prompt',$lang);
        $data['friends_no_user_select'] = $this->lang->line('friend_10');
        $data['friends_request_wait'] = $this->lang->line('friend_9');
		$data['friends_search_wait'] = $this->lang->line('friend_8');

		//
		//$data['lang_code'] = $this->config->item('language_code');
        switch($lang)
        {
            case 'chinese':$data['lang_code'] = 'zh';break;
            case 'english':$data['lang_code'] = 'en';break;
            case 'italian':$data['lang_code'] = 'it';break;
            case 'german':$data['lang_code'] = 'de';break;
        }
	    return $data;
	}

	//load the content for the event:mouseover the avatar
	function prompt_content()
	{
        $language = $this->Ip_location->get_language();
	   if($this->Auth->request_access_check())
	   {
		  $user_info = $this->input->post('user_info',TRUE);
		  $user_data = explode('_', $user_info);

		  list($user_id,$user_name) = $user_data;
		  $data = array('user_id'=>$user_id,'user_name'=>$user_name);

		  $data['base'] = $this->config->item('base_url');
	      $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';
          $label_data = $this->load_prompt_label($language);
          $data = array_merge($data,$label_data);
	      $this->load->view('q2a/mainleft/friend_prompt_view',$data);
	   }
	   else
	   {
	   	   echo "loading failed.";
	   }
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
	//
 }//END OF CLASS

 /*End of file*/
  /*Location: ./system/appllication/controller/friends.php*/
