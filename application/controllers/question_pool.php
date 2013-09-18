<?php
  class Question_pool extends CI_Controller
  {
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->library('session');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/Tag_process');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Question_data');
		 $this->load->model('q2a/Question_pool_manage');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Right_nav_data');
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Ip_location');
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
	   $data['question_view'] = $this->latest_question_load($user_id);

	   $q_toal_num = $this->Question_process->get_all_question_number();
	   $pre_page_num = $this->config->item('pre_q_pool_num');
	   $data['total_page'] = ceil($q_toal_num/$pre_page_num);

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
       $label = $this->load_label($language);
	   $data = array_merge($right_data,$data,$label);
	   $this->load->view('q2a/question_pool',$data);
	}


	//load html string of question that system recommand to user by uId
	function latest_question_load($uId)
	{
	   $data = $this->Question_process->get_latest_asked_question($uId,array('start'=>0,'end'=>9));

	   $retStr = "";
	   foreach($data as $item)
	   {
	      $retStr .= $this->question_item_view($item);
	   }
	   return $retStr;
	}



	//load data to question item view,and return html string
	function question_item_view($data)
	{
		 if(!empty($data))
		 {
		   $data['base'] = $this->config->item('base_url');
           $data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
		   if(iconv_strlen($data['text'],"UTF-8") > 30)
		   {
		   		$data['text'] = iconv_substr($data['text'],0,30,"UTF-8")."...";
			}
			else
			{
				$data['text'] = iconv_substr($data['text'],0,30,"UTF-8");
			}
		   
		   //$data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);

		   //$data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
           //$language = $this->Ip_location->get_language();
           //$label = $this->load_question_item_label($language);
           //$data = array_merge($data,$label);
		   return $this->load->view('q2a/mainleft/question_pool_item',$data,true);
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

    function load_label($lang)
     {
         $question_label = $this->load_question_pool_label($lang);
         $common_label = $this->Load_common_label->load_common_label($lang);
         $result = array_merge($question_label,$common_label);
         return $result;
     }

     function load_question_pool_label($lang)
     {
     	 $this->lang->load('question_pool',$lang);

         $data['question_pool_page_title'] = $this->lang->line('question_pool_page_title');
         $data['question_pool_tag_title'] = $this->lang->line('question_pool_tag_title');
         $data['question_pool_head_label'] = $this->lang->line('question_pool_head_label');
         $data['question_pool_answer_num'] = $this->lang->line('question_pool_answer_num');
         $data['question_pool_follow_num'] = $this->lang->line('question_pool_follow_num');
         $data['question_pool_view_num']   = $this->lang->line('question_pool_view_num');
         $data['question_pool_kpc_reward'] = $this->lang->line('question_pool_kpc_reward');
         $data['question_pool_submit_time'] = $this->lang->line('question_pool_submit_time');
		 $data['question_pool_q_desc'] = $this->lang->line('question_pool_q_desc');
         $data['question_pool_tag_other_lan'] = $this->lang->line('question_pool_tag_other_lan');
         $data['question_pool_tag_chi_lan'] = $this->lang->line('question_pool_tag_chi_lan');
         $data['question_pool_search_button'] = $this->lang->line('question_pool_search_button');
         return $data;
     }


     function load_question_label($lang)
     {
         $this->lang->load('questions',$lang);
         $data['question_asked_title'] = $this->lang->line('question_asked_title');
         $data['question_answered_title'] = $this->lang->line('question_answered_title');
         $data['question_following_title'] = $this->lang->line('question_following_title');
         $data['question_recommendation_title'] = $this->lang->line('question_recommendation_title');
         $data['questions_asked'] = $this->lang->line('questions_asked');
         $data['questions_answered'] = $this->lang->line('questions_answered');
         $data['questions_following'] = $this->lang->line('questions_following');
         $data['questions_recommendation'] = $this->lang->line('questions_recommendation');
         $data['question_sorted_by'] = $this->lang->line('question_sorted_by');
         $data['question_date'] = $this->lang->line('question_date');
         $data['question_highest_views'] = $this->lang->line('question_highest_views');
         $data['question_most_answered'] = $this->lang->line('question_most_answered');
         $data['question_views'] = $this->lang->line('question_views');
         $data['question_answers'] = $this->lang->line('question_answers');
         return $data;
     }

	 ////
	 function question4tag()
	 {
	    //if($this->Auth->request_access_check())
		$base = $this->config->item('base_url');
	    $this->Auth->permission_check($base."login/");

		if($this->Auth->request_access_check())
		{
	       $segs = $this->uri->segment_array();

		   $data['user_id'] = $this->session->userdata('uId');

		   $data['base'] = $base;

		   $right_data = $this->Right_nav_data->get_rgiht_nav_data($data['user_id']);
		   $data = array_merge($right_data,$data);
		   $data['login'] = "login";
		   $data['tag_id'] = $segs[3];
           $data['tag_name'] = $this->Tag_process->_fun_get_text_by_id(array('table'=>'tag','column_id'=>'tag_id','column_name'=>'tag_name','val'=>$segs[3]));

		   //data for page split
		   $data['total_num'] = $this->Question_process->get_Q_num_by_tag($segs[3]);
		   $data['pre_num'] = $this->config->item('pre_question_num');
		   $data['page_num'] = ($data['total_num']==0) ? 1 : ceil($data['total_num']/$data['pre_num']);

		   //load question view
		   $data['question4tag_view'] = '';
		   $index = 1;
		   $range = array('start'=>($index-1)*$data['pre_num'],'end'=>$index*$data['pre_num']-1);
		   $question_data = $this->Question_process->get_question_data_by_tag_id(array($segs[3]),$range);
		   foreach($question_data as $item)
	       {
	          $data['question4tag_view'] .= $this->question4tag_item_view($item);
	       }

		   //loading label
           $language = $this->Ip_location->get_language();
		   $label_data = $this->load_label($language);
		   $data =array_merge($label_data,$data);
		   $this->load->view('q2a/question4tag',$data);
		}
	 }
	 
	 function question4tag_item_view($data)
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
	 
	function question4tag_request()
	{
		$base = $this->config->item('base_url');
		$this->Auth->permission_check($base."login/");
	
		if($this->Auth->request_access_check())
		{
			$index = $this->input->post('index');
			$tag_id = $this->input->post('tag_id');
			
			$pre_num = $this->config->item('pre_question_num');
			$range = array('start'=>($index-1)*$pre_num,'end'=>$index*$pre_num-1);
			$question_data = $this->Question_process->get_question_data_by_tag_id(array($tag_id),$range);
			$html_view = '';
			foreach($question_data as $item)
			{
			  	$html_view .= $this->question4tag_item_view($item);
			}
		   	echo($html_view);
		}
	}
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/question_pool.php*/
