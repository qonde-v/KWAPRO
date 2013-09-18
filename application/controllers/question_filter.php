<?php
  class Question_filter extends CI_Controller
  {

	 var $pre_question_num = 0;

         function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->library('session');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/Tag_process');
                 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Question_data');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Right_nav_data');
                 $this->load->model('q2a/Load_common_label');
                 $this->load->model('q2a/Ip_location');
	 }
         
         //
         function index()
         {
               $base = $this->config->item('base_url');
               $language = $this->Ip_location->get_language();
               //login permission check
               $this->Auth->permission_check("login/");

               //get current login user id
               $user_id = $this->session->userdata('uId');

               $data = array('base'=>$base);
               $data['login'] = "login";
               $data['language'] = $language;
               $data['category_data'] = $this->Load_common_label->load_category_data($language);
               
               //generate question view data
               $c_id = $this->input->get('c_id',TRUE);
               $sc_id = $this->input->get('sc_id',TRUE);
               $index = $this->input->get('index',TRUE);
               
               if(!empty ($c_id))
               {
                    $langCode = $this->Ip_location->get_code_by_language($language);
                    $data['subcate_data'] = $this->Tag_process->get_subcategory_data_mutli(array('langCode'=>$langCode,'category_id'=>$c_id));
               }
               
               $pre_num = $this->config->item('pre_question_num');               
               $data['question_data'] = $this->generate_question_view(array('pre_num'=>$pre_num, 'index'=>$index,'c_id'=>$c_id, 'sc_id'=>$sc_id));

               
               $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
               $label = $this->load_label($language);
               $data = array_merge($right_data,$data,$label);
               $this->load->view('q2a/question_filter',$data);  
         }
         
         //input: array('pre_num','index','sc_id','c_id');
         //output: array('html','total','start','end','display_page_num');
         function generate_question_view($param_data)
         {
             $result = array();
             $question_data = $this->get_question_data($param_data);
             
             $base= $this->config->item('base_url');
             $language = $this->Ip_location->get_language();
             $pub_info = array('base'=>$base,'language'=>$language);
             
             $html = '';
             
             if(!empty($question_data['q_data']))
             {
                 foreach($question_data['q_data'] as $item)
                 {
                     $html .= $this->question_item_view($item, $pub_info);
                 }
             }
             $total_page = $this->page_num_calculate($question_data['total'],$param_data['pre_num']);
             $display_num = $this->config->item('pre_pagination_num');
             $page_data = $this->get_page_data(array('index'=>$param_data['index'],'total'=>$total_page,'display_num'=>$display_num));
             list($start,$end) = $page_data;
             return array('html'=>$html, 'total'=>$total_page, 'start'=>$start,'end'=>$end);
             
         }
         
         //input: array('index','total','display_num');
         function get_page_data($data)
         {
             $start = 1;
             $end = $data['display_num'];
             
             if($data['total'] < $data['display_num'])
             {
                 $end = $data['total'];
             }
             else
             {
                 $half_dis = floor($data['display_num']/2);
                 $start = $data['index'] - $half_dis;
                 $end = $data['index'] + $half_dis;
                 
                 if($end>$data['total'])
                 {
                     $end = $data['total'];
                     $start = $data['total']-$data['display_num']+1;
                 }
                 else
                 {
                     if($start<1)
                     {
                         $start = 1;
                         $end = $data['display_num'];
                     }
                 }
             }
             return array($start,$end);
         }
         
         
         //
         function page_num_calculate($total,$pre_num)
         {
            if($total == 0)
            {
                return 1;
            }
            return ($total % $pre_num == 0) ? ($total/$pre_num) : (floor($total/$pre_num)+1);
         }
         
         
         //load data to question item view,and return html string
         //input: question item data, public information: array('base','language')
	function question_item_view($data,$pub_info)
	{
             if(!empty($data))
             {
               $data['base'] = $pub_info['base'];
               
               //cache need!
               $data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);

               $label = $this->load_question_item_label($pub_info['language']);
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
        
        
         //input: array('pre_num','index','sc_id','c_id');
         //output: array('q_data','total')
         function get_question_data($param_data)
         {
             if($param_data['index']<0)
             {
                 return array('total'=>0);
             }
             
             $index = empty($param_data['index']) ? 1 : $param_data['index'];
             $range = array('start'=>($index-1)*$param_data['pre_num'],'end'=>$index*$param_data['pre_num']-1);
             
             $question_data = array();
             $total = 0;
             
             if(!empty($param_data['c_id']))
             {
                 if(!empty($param_data['sc_id']))
                 {
                     //get question by sub category
                     $question_data = $this->Question_process->get_question_by_sub_cate($param_data['sc_id'], $range);
                     $total = $this->Question_process->get_question_number_by_scate($param_data['sc_id']);
                 }
                 else
                 {
                     //get question by category
                     $question_data = $this->Question_process->get_question_by_category($param_data['c_id'], $range);
                     $total = $this->Question_process->get_question_number_by_cate($param_data['c_id']);
                     //echo $total;
                 }                 
             }
             else
             {
                 //get all question
                 $question_data = $this->Question_process->get_latest_asked_question(0, $range);
                 $total = $this->Question_process->get_all_question_number();
             }
             $result = array('q_data'=>$question_data, 'total'=>$total);
            // print_r($result);
             return $result;
         }
         
         
         //
         function load_label($lang)
         {
             $question_label = $this->load_question_filter_label($lang);
             $common_label = $this->Load_common_label->load_common_label($lang);
             $result = array_merge($question_label,$common_label);
             return $result;
         }
         
         function load_question_filter_label($lang)
         {
             $data = array();
             $this->lang->load('question_classify',$lang);
             $data['question_classify_title'] = $this->lang->line('question_classify_title');
             $data['category_title'] = $this->lang->line('category_title');
             $data['sub_cate_title'] = $this->lang->line('sub_cate_title');        
             $data['search_action_title'] = $this->lang->line('search_action_title');
             $data['waiting_title'] = $this->lang->line('waiting_title');
             
             return $data;
         }
         
  }
  /*End of file*/
  /*Location: ./system/appllication/controller/question_filter.php*/