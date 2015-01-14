<?php
  class Right_nav_data extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->library('session');
		$this->load->model('q2a/User_data');
		$this->load->model('q2a/User_profile');
		$this->load->model('q2a/Tag_process');
		$this->load->model('q2a/Session_process');
        $this->load->model('q2a/Ip_location');
        $this->load->model('q2a/Message_management');
        $this->load->model('q2a/Friend_invite');
        $this->load->library('session');
	 }

	 //
	 function get_rgiht_nav_data($user_id)
	 {
	    $data = array();
		$data['user_info'] = $user_id ? $this->get_user_info_data($user_id) : array();
		$data['online_friend'] = $user_id ? $this->get_online_friend($user_id) : array();
		$data['hot_tags'] = $this->get_hot_tags($user_id);

        $data['unread_msg_num'] = $user_id ? $this->Message_management->get_unread_msg_num($user_id) : 0;

        $item = array('uId'=>$user_id,'time'=>array('day'=>15,'hour'=>0,'minute'=>0,'second'=>0));
        $data['friend_request_num'] = $user_id ? count($this->Friend_invite->get_invite_request($item)) : 0;

		return $data;
	 }


	 //get user's information data
	 //output:array('answer_num','ask_num','follow_num','username','headphoto_path')
	 function get_user_info_data($user_id)
	 {
	     //todo:
		 $activity_content_data = $this->User_data->get_user_content_num($user_id);
		 $username = $this->User_data->get_username(array('uId'=>$user_id));
		 $user_photo_path = $this->User_data->get_user_headphotopath($user_id);
		 $user_gender = $this->User_data->get_user_gender($user_id);
		 $user_subpic = $this->User_data->get_user_subpic($user_id);
		 $permission = $this->User_data->get_invite_permission($user_id);
		 $tag = $this->User_data->get_user_tag($user_id);
		 $ifcollect = $this->User_data->get_user_ifcollect($user_id);
		 $kpc_score = $this->User_data->get_user_kpc($user_id);
			
		 $answer_num = isset($activity_content_data[ANSWER]) ? $activity_content_data[ANSWER] :0;
		 $question_num = isset($activity_content_data[QUESTION]) ? $activity_content_data[QUESTION] : 0;
         $follow_num = isset($activity_content_data[FOLLOW]) ? $activity_content_data[FOLLOW] : 0;
	     //$location_data = $this->session->userdata('location_city');
		 $location_data = $this->User_data->get_user_location($user_id);
		 $data = array('location'=>$location_data,'kpc_score'=>$kpc_score,'username'=>$username,'headphoto_path'=>$user_photo_path,'answer_num'=>$answer_num,'question_num'=>$question_num,'follow_num'=>$follow_num,'gender'=>$user_gender,'subpic'=>$user_subpic,'permission'=>$permission,'tag'=>$tag,'ifcollect'=>$ifcollect);

		 $basic_data = $this->User_profile->get_user_basicdata($user_id);
		 //print_r($data);
		 return array_merge($data,$activity_content_data,$basic_data);
	 }

	 //get online friends
	 //array of ('headphoto_path','user_id','username')
	 function get_online_friend($user_id)
	 {
	    //todo:
		$data = array();
		$online_user_id_arr = $this->Session_process->session_online_user_id();
		$lang = $this->Ip_location->get_language();

		if(count($online_user_id_arr))
		{
			$lang = $this->Ip_location->get_language();
			$this->lang->load('right_navi',$lang);
			$question_label = $this->lang->line('right_navi_questions');
			$answer_label = $this->lang->line('right_navi_answer');
			$follow_label = $this->lang->line('right_navi_following');
			$kpc_label = $this->lang->line('right_navi_kpc');
			$base = $this->config->item('base_url');
			foreach($online_user_id_arr as $user_id)
			{
				$username = $this->User_data->get_username(array('uId'=>$user_id));
				$headphoto_path = $this->User_data->get_user_headphotopath($user_id);
				$activity_content_data = $this->User_data->get_user_content_num($user_id);
				$kpc_score = $this->User_data->get_user_kpc($user_id);
				
				$answer_num = isset($activity_content_data[ANSWER]) ? $activity_content_data[ANSWER] :0;
				$question_num = isset($activity_content_data[QUESTION]) ? $activity_content_data[QUESTION] : 0;
				$follow_num = isset($activity_content_data[FOLLOW]) ? $activity_content_data[FOLLOW] : 0;
				
				$item = array('headphoto_path'=>$headphoto_path,'user_id'=>$user_id, 'username'=>$username,'question_num'=>$question_num,'answer_num'=>$answer_num);
				array_push($data,$item);
			}
		}

		return $data;
	 }

	 //
	 function get_hot_tags($user_id="")
	 {
	 		$hot_tags = $this->session->userdata('hot_tags');
	 		if($hot_tags)
	 		{
	 				return $hot_tags;
	 		}
	 		//not exist in session data
	    $result_data  =  array();
			$tag_data = $this->Tag_process->get_hot_tags(array());
			if(!empty($tag_data))
			{
		  		foreach($tag_data as $tag_item)
		   		{
		      		$new_item = $this->generate_tag_caution_text($tag_item);
		      		array_push($result_data, $new_item);
		   		}
			}
			return $result_data;
	 }

	 //generate caution text for specified tag
	 //input: array('tag_id','tag_name','count')
	 //output: array('tag_id','tag_name','count','caution_text')
	 function generate_tag_caution_text($tag_item)
	 {
	    //todo:
        $language = $this->Ip_location->get_language();
		$this->lang->load('right_navi',$language);
		$caution_text_temp = $this->lang->line('right_navi_tag_caution');

		//$langCode = $this->config->item('language_code');
        switch($language)
        {
            case 'chinese':$langCode = 'zh';break;
            case 'english':$langCode = 'en';break;
            case 'italian':$langCode = 'it';break;
            case 'german':$langCode = 'de';break;
        }

		$tag_input_data = array('tag_id'=> $tag_item['tag_id'],'langCode'=>$langCode);

		$cate_info = $this->Tag_process->generate_cate_name_info($tag_input_data);

		$tag_item['caution_text'] = sprintf($caution_text_temp, $cate_info['c_name'], $cate_info['sc_name'], $tag_item['count']);
		return $tag_item;
	 }

  }//END OF CLASS
