<?php
  class Home extends CI_Controller
  {
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
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Ip_location');
	 }

	function index()
	{
	  // $this->output->enable_profiler(TRUE);
	   $data = array();
	   $user_id = "";

       $language = $this->Ip_location->get_language();

	   if($this->Auth->login_check())
	   {
	     $user_id = $this->session->userdata('uId');
		 $data['login'] = "login";
	   }

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);
	   $data['headphoto_path'] = $this->User_data->get_user_headphotopath($user_id);
	   $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';
       $data['base'] = $this->config->item('base_url');
	   $data['question_view'] = $this->generate_latest_question_view($user_id);
	   $data['left_part_view'] = $this->generate_left_part_view($language);
       $data['language'] = $language;
       $label = $this->load_label($language);
       $data = array_merge($data,$label);
	   $this->load->view('q2a/default',$data);
	}
	
	function generate_left_part_view($lang)
	{
		$data = array();
		$this->lang->load('update',$lang);
		$data['update_label'] = $this->lang->line('update_label');
		$data['update_internal_test'] = $this->lang->line('update_internal_test');
		
		$this->lang->load('home',$lang);
		$data['home_left_rss_news'] = $this->lang->line('home_left_rss_news');
		return $this->load->view('q2a/mainleft/home_left',$data,true);
	}

	//
	function generate_latest_question_view($uId)
	{
	   $html_view = "";
	   $base = $this->config->item('base_url');
	   $question_data_arr = $this->Question_process->get_latest_asked_question($uId,array('start'=>0,'end'=>5));
       $language = $this->Ip_location->get_language();

	   foreach($question_data_arr as $data)
	   {
            if(!$this->Auth->login_check())
	        {
		        $data['unlogin'] = "unlogin";
	        }
		   $data['base'] = $base;
		   $data['homepage'] = "home";
		   $data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
		   $data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);

           $label = $this->load_single_item_label($language);
           $data = array_merge($data,$label);

		   $html_view .= $this->load->view('q2a/mainleft/question_item',$data,true);
	   }

	   return $html_view;
	}

    function load_single_item_label($lang)
    {
        $this->lang->load('questions',$lang);
        $data['question_views'] = $this->lang->line('question_views');
        $data['question_answers'] = $this->lang->line('question_answers');
        $data['question_participants'] = $this->lang->line('question_participants');
        $data['question_kp_dolors'] = $this->lang->line('question_kp_dolors');
        $data['question_followed'] = $this->lang->line('question_followed');
        $data['question_click_detail'] = $this->lang->line('question_click_detail');
        $data['question_translate'] = $this->lang->line('question_translate');

        $data['instant_answer_title'] = $this->lang->line('instant_answer_title');
        $data['instant_answer_close'] = $this->lang->line('instant_answer_close');
        $data['instant_answer_empty'] = $this->lang->line('instant_answer_empty');
        $data['instant_answer_button'] = $this->lang->line('instant_answer_button');
        
        return $data;
    }

    function load_label($lang)
    {
        $home_label = $this->load_home_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = array_merge($home_label,$common_label);
        return $result;
    }

    function load_home_label($lang)
    {
        $this->lang->load('home',$lang);
        $data['home_page_title'] = $this->lang->line('home_page_title');
        $data['home_ask_label'] = $this->lang->line('home_ask_label');
        $data['home_latest_question'] = $this->lang->line('home_latest_question');
        $data['home_related_question'] = $this->lang->line('home_related_question');
        $data['home_more_question'] = $this->lang->line('home_more_question');
        $data['home_tags_label'] = $this->lang->line('home_tags_label');
        $data['home_tags_prompt'] = $this->lang->line('home_tags_prompt');
        $data['home_get_tag_button'] = $this->lang->line('home_get_tag_button');
        $data['home_tags_not_found'] = $this->lang->line('home_tags_not_found');
        $data['home_quick_answer'] = $this->lang->line('home_quick_answer');
        $data['home_question_length_zh1'] = $this->lang->line('home_question_length_zh1');
        $data['home_question_length_zh2'] = $this->lang->line('home_question_length_zh2');
        $data['home_question_length'] = $this->lang->line('home_question_length');
        $data['home_question_length_overflow'] = $this->lang->line('home_question_length_overflow');
        $data['home_question_too_short'] = $this->lang->line('home_question_too_short');
        $data['home_quick_answer_prompt'] = $this->lang->line('home_quick_answer_prompt');
        $data['home_quick_answer_button'] = $this->lang->line('home_quick_answer_button');
        $data['home_quick_answer_save'] = $this->lang->line('home_quick_answer_save');
        return $data;
    }

 }//END OF CLASS

 /*End of file*/
  /*Location: ./system/appllication/controller/home.php*/
