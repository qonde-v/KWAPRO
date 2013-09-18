<?php
  class Question_search extends CI_Controller
  {
     var $keyword;
	 var $pre_question_num;
	 var $page_num;
	 var $is_split;

     function __construct()
	 {
	     parent::__construct();
		 $this->load->helper('url');
         $this->load->helper('prompt');
		 $this->load->library('session');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/Tag_process');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Question_data');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Right_nav_data');
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Check_process');
         $this->load->model('q2a/Ip_location');
	 }

	 //
	 function index()
	 {
	 	$base = $this->config->item('base_url');
	    //login permission check
	    $this->Auth->permission_check($base."login/");

        $language = $this->Ip_location->get_language();

	    //get current login user id
	    $user_id = $this->session->userdata('uId');

	    $data = array('base'=>$base);
	    $data['login'] = "login";
        $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';

	    $keyword_string = $this->input->post('keyword', TRUE);
		$index = $this->input->post('index', TRUE);
		$index = empty($index) ? 1 : $index;

		$data['question_search_view'] = (empty($keyword_string)) ? '' : $this->generate_search_result($keyword_string, $index);
        $data['is_split'] = $this->is_split;
		$data['page_num'] = $this->page_num;
		$data['keyword'] = $this->keyword;

	    $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
        $label = $this->load_label($language);
	    $data = array_merge($right_data,$data,$label);
	    $this->load->view('q2a/question_search',$data);
	 }

	 //
	 function get_pre_question_num()
     {
     	if(empty($this->pre_question_num))
     	{
     	   $this->pre_question_num = $this->config->item('pre_question_num');
     	}
     	return $this->pre_question_num;
     }

	 //ajax data request for pagesplit of question search
	 function ajax_QS_data_load()
	 {
	      if($this->Auth->request_access_check())
		 {
		     $keyword_string = $this->input->post('keyword', TRUE);
		     $index = $this->input->post('index', TRUE);
		     $index = empty($index) ? 1 : $index;
			 echo $this->generate_search_result($keyword_string,$index);
		 }
	 }

	 //generate search result for input keyword
	 //input: array of tag id
	 //output: html view of question result
	 function generate_search_result($keyword_string,$index)
	 {
	      $html_view = "";
	      $parse_data = $this->get_keyword_id_info($keyword_string);
		  list($id_data,$name_data) = $parse_data;
          $this->keyword = implode(',', $name_data);

		  $pre_Q_num = $this->get_pre_question_num();
		  $range = array('start'=>($index-1)*$pre_Q_num, 'end'=>$index*$pre_Q_num-1);

		  $question_data = $this->Question_process->get_question_data_by_tag_id($id_data, $range);
		  $total_num = $this->Search->_get_searched_Q_num($id_data);

		  $this->is_split = ($total_num > $pre_Q_num) ? TRUE : FALSE;
		  $this->page_num = floor($total_num/$pre_Q_num);
		  if($total_num%$pre_Q_num != 0 || $total_num == 0)
		  {
		  		$this->page_num++;
		  }

		  foreach($question_data as $item)
		  {
	          $html_view.= $this->question_item_view($item);
		  }

          if($html_view == "")
          {
                $html_view = $this->Check_process->get_prompt_msg(array('pre'=>'question_search','code'=>NO_RESULT));
          }

		  return $html_view;
	 }

	 //get tag id from input keyword string
	 //input: keyword string
	 //output:
	 function get_keyword_id_info($keyword_string)
	 {
	     $result = array(array(),array());
	     if(!empty($keyword_string))
		 {
		     $data = explode(',', $keyword_string);
			 foreach($data as $item)
			 {
			    $item_data = explode('_',$item);
			    $result[1][] = $item_data[0];
			    $result[0][] = isset($item_data[1]) ? $item_data[1] : $this->Tag_process->_fun_get_text_by_id(array('table'=>'tag','column_id'=>'tag_name','column_name'=>'tag_id','val'=>$item_data[0]));
			 }
		 }
		 return $result;
	 }


	 //
	 function load_label($lang)
     {
         $question_label = $this->load_question_search_label($lang);
         $common_label = $this->Load_common_label->load_common_label($lang);
         $result = array_merge($question_label,$common_label);
         return $result;
     }

	 //
	 function load_question_search_label($lang)
	 {
	 	//todo:
        $this->lang->load('question_search',$lang);
        $data['question_search_title'] = $this->lang->line('question_search_title');
        $data['question_search_label'] = $this->lang->line('question_search_label');
        $data['question_search_button'] = $this->lang->line('question_search_button');
	 	return $data;
	 }

     //load data to question item view,and return html string
	function question_item_view($data)
	{
		 if(!empty($data))
		 {
		   $data['base'] = $this->config->item('base_url');
           $data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
		   $data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);

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

  }//END OF CLASS

  /*End of file*/
  /*Location: ./system/appllication/controller/question_search.php*/
