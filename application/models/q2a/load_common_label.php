<?php
    class Load_common_label extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
        }

        function load_common_label($lang = '')
        {
            $header_label = $this->load_header_label($lang);
            $right_navi_label = $this->load_right_navi_label($lang);
            $result = array_merge($header_label,$right_navi_label);
            return $result;
        }

        function load_right_navi_label($lang)
        {
            $this->lang->load('right_navi',$lang);
            $data['right_navi_user_info'] = $this->lang->line('right_navi_user_info');
            $data['right_navi_username'] = $this->lang->line('right_navi_username');
            $data['right_navi_add_friend'] = $this->lang->line('right_navi_add_friend');
            $data['right_navi_send_message'] = $this->lang->line('right_navi_send_message');
            $data['right_navi_questions'] = $this->lang->line('right_navi_questions');
            $data['right_navi_answer'] = $this->lang->line('right_navi_answer');
            $data['right_navi_following'] = $this->lang->line('right_navi_following');
            $data['right_navi_kpc'] = $this->lang->line('right_navi_kpc');
            $data['right_navi_online_friend'] = $this->lang->line('right_navi_online_friend');
            $data['right_navi_hot_tags'] = $this->lang->line('right_navi_hot_tags');
            $data['right_navi_location'] = $this->lang->line('right_navi_location');
            $data['right_navi_kpc_log'] = $this->lang->line('right_navi_kpc_log');
			$data['right_navi_new_msg'] = $this->lang->line('right_navi_new_msg');
            $data['right_navi_friend_request'] = $this->lang->line('right_navi_friend_request');

            $data['page_split_first'] = $this->lang->line('page_split_first');
            $data['page_split_last'] = $this->lang->line('page_split_last');
			$data['page_split_previous'] = $this->lang->line('page_split_previous');
            $data['page_split_next'] = $this->lang->line('page_split_next');
			$data['modal_ok'] = $this->lang->line('modal_ok');
			$data['waiting_text'] = $this->lang->line('waiting_text');
            return $data;
        }

        function load_header_label($lang)
        {
            $this->lang->load('header',$lang);
            $data['header_home'] = $this->lang->line('header_home');
            $data['header_messages'] = $this->lang->line('header_messages');
            $data['header_messages_privte'] = $this->lang->line('header_messages_privte');
            $data['header_messages_subscribe'] = $this->lang->line('header_messages_subscribe');
			$data['header_messages_notes'] = $this->lang->line('header_messages_notes');
            $data['header_friends'] = $this->lang->line('header_friends');
            $data['header_questions'] = $this->lang->line('header_questions');
            $data['header_profile'] = $this->lang->line('header_profile');
            $data['header_logout'] = $this->lang->line('header_logout');
            $data['header_login'] = $this->lang->line('header_login');
			$data['header_register'] = $this->lang->line('header_register');
            $data['header_document'] = $this->lang->line('header_document');
			
			$data['header_login_wait'] = $this->lang->line('header_login_wait');
			
			$data['header_search'] = $this->lang->line('header_search');
            $data['header_search_ask'] = $this->lang->line('header_search_ask');
			$data['header_username'] = $this->lang->line('header_username');
            $data['header_password'] = $this->lang->line('header_password');
			
			$data['header_question_pool'] = $this->lang->line('header_question_pool');
            $data['header_user_related_q'] = $this->lang->line('header_user_related_q');
            $data['header_search_question'] = $this->lang->line('header_search_question');
            return $data;
        }
		
		function load_category_data($lang)
		{
			$this->db->select('category_id,category_name');
			switch($lang)
			{
				case 'chinese':$this->db->where('langCode','zh');break;
				default:$this->db->where('langCode','en');break;
			}	
			$query = $this->db->get('category');
			$result = array();
			if($query->num_rows() > 0)
			{
				foreach($query->result_array() as $row)
				{
					array_push($result,$row);
				}
			}
			return $result;
		}
    }
