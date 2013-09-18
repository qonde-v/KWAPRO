<?php
  class Questions extends CI_Controller
  {

	  var $pre_question_num = 0;

      function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->library('session');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Question_data');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Right_nav_data');
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Ip_location');
	 }

	function index()
	{
	   //$this->output->cache(1);
	//   $this->output->enable_profiler(TRUE);
	   $base = $this->config->item('base_url');

       $language = $this->Ip_location->get_language();

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $data = array('base'=>$base);
	   $data['login'] = "login";
	   $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';
	   $data['my_asked_question'] = $this->myasked_question_load();
	   $data['my_answered_question'] = $this->myanswered_question_load();
	   $data['my_followed_question'] = $this->myfollowed_question_load();
	   $data['my_recommened_question'] = $this->myrecommend_question_load();

	   /************page split data calculate**************/

	   $pre_Q_num = $this->get_pre_Q_num();
	   //$data['is_split'] = ($data['asked_num'] > $pre_Q_num) ? 1 : 0;
	   
	   $data['asked_num'] = $this->page_num_calculate($this->Question_process->get_user_activity_num($user_id,QUESTION));
	   $data['answered_num'] = $this->page_num_calculate($this->Question_process->get_user_activity_num($user_id,ANSWER));
	   $data['followed_num'] = $this->page_num_calculate($this->Question_process->get_user_activity_num($user_id,FOLLOW));
	   $data['recommend_num'] = $this->page_num_calculate($this->Question_process->get_recommendation_Q_num($user_id));

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
       $label = $this->load_label($language);
	   $data = array_merge($right_data,$data,$label);
	   $this->load->view('q2a/private_question',$data);
	}

    //return the number of question that display in page
	function get_pre_Q_num()
	{
	    if($this->pre_question_num === 0)
		{
		    $this->pre_question_num = $this->config->item('pre_question_num');
		}
		return $this->pre_question_num;
	}

	//load html string of question that system recommand to user by uId
	function myrecommend_question_load($index=1)
	{
	    $pre_Q_num = $this->get_pre_Q_num();
	    $range = array('start'=>($index-1)*$pre_Q_num, 'end'=>$index*$pre_Q_num-1);

	   $uId = $this->session->userdata('uId');
	   $data = $this->Question_process->get_question_4user($uId,$range);

	   $retStr = "";
	   foreach($data as $item)
	   {
	      $retStr .= $this->question_item_view($item);
	   }
	   return $retStr;
	}
	
	function call_myrecommend_question_load()
	{
	   $index = isset($_POST['index']) ? $_POST['index'] : 1;
	   echo $this->myrecommend_question_load($index);
	}

	//load html string of user's asked question by uId
	function myasked_question_load($index=1)
	{
	    $pre_Q_num = $this->get_pre_Q_num();
	    $range = array('start'=>($index-1)*$pre_Q_num, 'end'=>$index*$pre_Q_num-1);
		
		$uId = $this->session->userdata('uId');

	   $data = $this->Question_process->get_user_asked($uId,$range);

	   $retStr = "";
	   foreach($data as $item)
	   {
	      $retStr .= $this->question_item_view($item);
	   }
	   return $retStr;
	}

	function call_myasked_question_load()
	{
	   $index = isset($_POST['index']) ? $_POST['index'] : 1;
	   echo $this->myasked_question_load($index);
	}

	//load html string of user's answered question by uId
	function myanswered_question_load($index=1)
	{
	    $pre_Q_num = $this->get_pre_Q_num();
	    $range = array('start'=>($index-1)*$pre_Q_num, 'end'=>$index*$pre_Q_num-1);

	   $uId = $this->session->userdata('uId');
	   $data = $this->Question_process->get_user_answered($uId, $range);

	   $retStr = "";
	   foreach($data as $item)
	   {
	      $item_html = $this->question_item_view($item);
	      $retStr .= $item_html;
	   }
	   return $retStr;
	}
	
	function call_myanswered_question_load()
	{
	   $index = isset($_POST['index']) ? $_POST['index'] : 1;
	   echo $this->myanswered_question_load($index);
	}

	//load html string of user's followed question by uId
	function myfollowed_question_load($index=1)
	{
	    $pre_Q_num = $this->get_pre_Q_num();
	    $range = array('start'=>($index-1)*$pre_Q_num, 'end'=>$index*$pre_Q_num-1);

	   $uId = $this->session->userdata('uId');
	   $data = $this->Question_process->get_user_followed($uId,$range);

	   $retStr = "";
	   foreach($data as $item)
	   {
	      $retStr .= $this->question_item_view($item);
	   }
	   return $retStr;
	}
	
	function call_myfollowed_question_load()
	{
	   $index = isset($_POST['index']) ? $_POST['index'] : 1;
	   echo $this->myfollowed_question_load($index);
	}

	//load data to question item view,and return html string
	function question_item_view($data)
	{
		 if(!empty($data))
		 {
		   $data['base'] = $this->config->item('base_url');
           //$data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
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

    function load_label($lang)
     {
         $question_label = $this->load_question_label($lang);
         $common_label = $this->Load_common_label->load_common_label($lang);
         $result = array_merge($question_label,$common_label);
         return $result;
     }

     function load_question_label($lang)
     {
         $this->lang->load('questions',$lang);
         $data['question_page_title'] = $this->lang->line('question_page_title');
         $data['question_asked_title'] = $this->lang->line('question_asked_title');
         $data['question_answered_title'] = $this->lang->line('question_answered_title');
         $data['question_following_title'] = $this->lang->line('question_following_title');
         $data['question_recommendation_title'] = $this->lang->line('question_recommendation_title');
         $data['question_private_title'] = $this->lang->line('question_private_title');
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
         $data['question_search_button'] = $this->lang->line('question_search_button');
         return $data;
     }
     
     function page_num_calculate($num)
     {
     		if($num == 0)
     		{
     				return 1;
     		}
     		$pre_Q_num = $this->get_pre_Q_num();
     		return ($num % $pre_Q_num == 0) ? ($num/$pre_Q_num) : (floor($num/$pre_Q_num)+1);
    	}
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/questions.php*/
