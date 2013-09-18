<?php
  class Question extends CI_Controller
  {
	 //private
	 var $base= "";

    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');

		 $this->load->database();
		 $this->load->library('session');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Question_data');
		 $this->load->model('q2a/Dialog_event');
		 $this->load->model('q2a/Right_nav_data');
		 $this->load->model('q2a/Load_common_label');
                 $this->load->model('q2a/Question_summary');
                 $this->load->model('q2a/Ip_location');
		 $this->load->model('q2a/Message_management');
                 $this->load->model('q2a/Mashup_search');
                 $this->load->model('q2a/Check_process');
                 $this->load->driver('cache');

        }

	function index()
	{
	   $data['base'] = $this->config->item('base_url');
	   $this->load->view('q2a/questiondetail',$data);
	}

	//generate question detail page  view
	function detail()
	{
	   $segs = $this->uri->segment_array();

	   $data['user_id'] = $this->session->userdata('uId');
	   $data['q_node_id'] = $segs[2];


	   $data['collect_type'] = FOLLOW;
           $data['base'] = $this->config->item('base_url');
	   $this->base = $data['base'];

	   //check if user has been login
	   $this->Auth->permission_check("login/");

	   //if($this->Auth->question_visible_check(array('uId'=>$data['user_id'],'nId'=>$data['q_node_id'])))
	   {
		   $right_data = $this->Right_nav_data->get_rgiht_nav_data($data['user_id']);
		   $data = array_merge($right_data,$data);
		   $data['login'] = "login";
		   //update dialog view numbers
		   $this->Dialog_event->question_view_update($segs[2]);

                   $language = $this->Ip_location->get_language();

		   $question_data = $this->Question_data->get_dialogue_data($segs[2]);
                   
		   //print_r($question_data);
		  //$question_data['q']['question_answer_num'] = count($question_data['related']);
		   $follow_data = array('user_id'=>$data['user_id'],'q_node_id'=>$data['q_node_id'],'collect_type'=>$data['collect_type']);

		   $data['question_html_str'] = $this->generate_question_view(array_merge($question_data['q'],$follow_data));
		   $data['reply_html_arr'] = $this->generate_reply_view($question_data['related']);
           //$data['quick_answer_html_str'] = $this->generate_quick_answer_view($question_data['quick_answer']);

		   $label_data = $this->load_label($language);
		   $data =array_merge($label_data,$data);
                   $data['q_data'] = $question_data['q'];
                   $data['mashup_data'] = $this->get_related_content4question(array('uId'=>$data['user_id'],'base'=>$this->base,'nId'=>$data['q_node_id'],'text'=>$question_data['q']['text']));
		   $this->load->view('q2a/question_detail',$data);
	   }
	}

	//

    function load_label($lang)
    {
        $question_label = $this->load_question_detail_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = array_merge($common_label,$question_label);
        return $result;
    }

    function load_question_detail_label($lang)
    {
	    $this->lang->load('question_detail',$lang);
        $data['question_detail_page_title'] = $this->lang->line('question_detail_page_title');
        $data['question_detail_title'] = $this->lang->line('question_detail_title');
        $data['question_detail_answer'] = $this->lang->line('question_detail_answer');
        $data['question_detail_qa_title'] = $this->lang->line('question_detail_qa_title');
        $data['question_detail_qa_prompt'] = $this->lang->line('question_detail_qa_prompt');
        $data['question_detail_tran_info'] = $this->lang->line('question_detail_tran_info');
		$data['question_detail_waiting'] = $this->lang->line('question_detail_waiting');
		
		$data['question_detail_related_question'] = $this->lang->line('question_detail_related_question');
        $data['question_detail_related_rss'] = $this->lang->line('question_detail_related_rss');
        $data['question_detail_from_note'] = $this->lang->line('question_detail_from_note');
        $data['question_detail_search_result'] = $this->lang->line('question_detail_search_result');
		$data['question_detail_view_more'] = $this->lang->line('question_detail_view_more');
		$data['question_detail_kp_recommend'] = $this->lang->line('question_detail_kp_recommend');
		$data['question_detail_related_ad'] = $this->lang->line('question_detail_related_ad');
		$data['question_detail_collect_title'] = $this->lang->line('question_detail_collect_title');
		$data['question_detail_collect_note1'] = $this->lang->line('question_detail_collect_note1');
		$data['question_detail_collect_note2'] = $this->lang->line('question_detail_collect_note2');
		
		$data['question_detail_cant_search'] = $this->lang->line('question_detail_cant_search');
        return $data;
    }

	//generate question content view on dialog page
	//input:array of question information data
	//output:html string of the question view
	function generate_question_view($data)
	{
		$data['user_id'] = $this->session->userdata('uId');
	   $data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);
	   $data['base'] = $this->base;
       $data['summary_content'] = $this->Question_summary->get_question_summary(array('nId'=>$data['nId'],'langCode'=>$data['langCode']));
       $data['follower'] = $this->Question_data->get_question_follower($data['nId']);
       $language = $this->Ip_location->get_language();
       $label = $this->load_question_content_label($language);
       $data = array_merge($data,$label);
	   return $this->load->view('q2a/mainleft/question_content',$data,true);
	}
        
        //
        //get mashup data
        //input: $para_data = array('uId','base','nId','text')
        function get_related_content4question($para_data)
        {
            $ret_data = array();
            //if($this->Auth->request_access_check())
            {
                $uId = $para_data['uId'];
                $base = $para_data['base'];
                $node_id = $para_data['nId'];
                $text = $para_data['text'];                
                $final_data = array('text'=>$text);
                $ret_data = array();
                
                $mashup_data = $this->cache->memcached->get("question_related_data_".$node_id);
                if(empty($mashup_data))
                {
                    $mashup_data = $this->cache->memcached->get($text);
                    if(empty($mashup_data))
                    {
                        $mashup_data = $this->Mashup_search->kwapro_box_search(array('text'=>$text, 'uId'=>$uId),5);
                        $this->cache->memcached->save("question_related_data_".$node_id,$mashup_data,3600);
                    }
                }
				//$mashup_data = $this->Mashup_search->kwapro_box_search(array('text'=>$text, 'uId'=>$uId),5);
                
                if(!empty ($mashup_data) && isset($mashup_data['search_result']))
                {
                	$final_data['tags'] = $mashup_data['T'];
                    foreach($mashup_data['search_result'] as $key=>$data)
                    {
                        $final_data[$key] = $data['is_more'];
                        if(!empty ($data) && !empty ($data['data']))
                        {
                            foreach($data['data'] as $item)
                            {
                                $ret_data[] = array('type_string'=>$key,'desc'=>$item['text'],'url'=>$base.$data['url_term'].$item['id']);
                            }
                        }
                    }
                }
                
            }//permission check
            $final_data['data'] = $ret_data;
            return $final_data;

        }
          
        
        

    function load_question_content_label($lang)
    {
       $this->lang->load('question_detail',$lang);
	   $data['question_detail_edit'] = $this->lang->line('question_detail_edit');
        $data['question_detail_views'] = $this->lang->line('question_detail_views');
        $data['question_detail_kp_dolors'] = $this->lang->line('question_detail_kp_dolors');
        $data['question_detail_answers'] = $this->lang->line('question_detail_answers');
        $data['question_detail_participants'] = $this->lang->line('question_detail_participants');
        $data['question_detail_translate'] = $this->lang->line('question_detail_translate');
        $data['question_detail_answer1'] = $this->lang->line('question_detail_answer1');
        $data['question_detail_summarize'] = $this->lang->line('question_detail_summarize');
        $data['question_detail_followed'] = $this->lang->line('question_detail_followed');
        $data['question_detail_related_content'] = $this->lang->line('question_detail_related_content');
        
		$data['question_detail_invite_answer'] = $this->lang->line('question_detail_invite_answer');
		$data['question_detail_input_empty'] = $this->lang->line('question_detail_input_empty');
		$data['question_detail_input_prompt'] = $this->lang->line('question_detail_input_prompt');
		$data['question_detail_invite_button'] = $this->lang->line('question_detail_invite_button');
        $data['question_detail_follower'] = $this->lang->line('question_detail_follower');
        $data['question_detail_follower_title'] = $this->lang->line('question_detail_follower_title');
        $data['question_detail_submit'] = $this->lang->line('question_detail_submit');
        $data['question_detail_translate_prompt1'] = $this->lang->line('question_detail_translate_prompt1');
        $data['question_detail_translate_prompt2'] = $this->lang->line('question_detail_translate_prompt2');
        $data['question_detail_summary_prompt'] = $this->lang->line('question_detail_summary_prompt');
		$data['question_detail_waiting'] = $this->lang->line('question_detail_waiting');
		$data['question_detail_edit_submit'] = $this->lang->line('question_detail_edit_submit');
		$data['question_detail_cancel'] = $this->lang->line('question_detail_cancel');
		$data['question_detail_operation'] = $this->lang->line('question_detail_operation');
		$data['question_detail_share'] = $this->lang->line('question_detail_share');
		$data['question_detail_note_tips'] = $this->lang->line('question_detail_note_tips');
		$data['question_detail_note_save_tips'] = $this->lang->line('question_detail_note_save_tips');
		$data['question_detail_note_save'] = $this->lang->line('question_detail_note_save');
        return $data;
    }

	//generate reply content view on dialog page,include answer and comment
	//input:array of ('answer','comment')
	//output:html string of the reply view
	function generate_reply_view($data)
	{
	   $html_arr = array();
	   $html_str = '';

	   foreach($data as $item)
	   {
                  $item['answer']['headphoto_path'] = $this->User_data->get_user_headphotopath($item['answer']['uId']);
                  $item['answer']['answer_score'] = $item['answer']['use_num'] - $item['answer']['no_use_num'];
                  if($item['answer']['answer_score'] < 0)
                  {
                        $data['answer']['answer_score'] = 0;
                  }
                  $language = $this->Ip_location->get_language();
                  $label = $this->load_answer_content_label($language);
                  $item['answer'] = array_merge($item['answer'],$label);
                  $html_str = $this->load->view('q2a/mainleft/answer_content',$item['answer'],true);

		   $html_str .= "<div id=\"comment4answer_".$item['answer']['nId']."\">";
		   foreach($item['comment'] as $comment)
		   {
		      $comment['headphoto_path'] = $this->User_data->get_user_headphotopath($comment['uId']);
		      $html_str .= $this->load->view('q2a/mainleft/comment_content',$comment,true);
		   }
		   $html_str .= "</div>";
		   array_push($html_arr,$html_str);
	   }

	   return $html_arr;
	}

    function load_answer_content_label($lang)
    {
        $this->lang->load('question_detail',$lang);
        $data['question_detail_votes'] = $this->lang->line('question_detail_votes');
        $data['question_detail_like_it'] = $this->lang->line('question_detail_like_it');
        $data['question_detail_dislike_it'] = $this->lang->line('question_detail_dislike_it');
        $data['question_detail_comment'] = $this->lang->line('question_detail_comment');
        $data['question_detail_submit'] = $this->lang->line('question_detail_submit');
        return $data;
    }

    //generate quick answer view
    //input:array('url','title','description')
    function generate_quick_answer_view($data)
    {
        if($data != '')
        {
        		$html_str = '<table>';
        		foreach($data as $item)
        		{
        				$html_str .= $this->load->view('q2a/mainleft/quick_answer',$item,true);
        		}
            return $html_str.'</table>';
        }
        else
        {
            return '';
        }
    }

    function instant_answer()
    {
        if($this->Auth->request_access_check())
	   {
          $language = $this->Ip_location->get_language();
	      $data = array();
		  $data['base'] = $this->config->item('base_url');
	      $label = $this->instant_answer_label($language);
		  $data = array_merge($data,$label);

		  $nId = $this->input->post('nId',TRUE);
		  $text = $this->input->post('q_text',TRUE);

		  $data['nId'] = $nId;
		  $data['text'] = $text;

		  echo $this->load->view('q2a/mainleft/instant_answer',$data,true);
	   }
	   else
	   {
	      echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	   }
    }

    function instant_answer_label($lang)
    {
        $this->lang->load('question_detail',$lang);
        $data['instant_answer_question'] = $this->lang->line('instant_answer_question');
        $data['instant_answer_answer'] = $this->lang->line('instant_answer_answer');
        $data['instant_answer_submit'] = $this->lang->line('instant_answer_submit');
        return $data;
    }
	
	function invite_answer()
	{
		if($this->Auth->request_access_check())
		{
			$f_uId_str = $this->input->post('friend');
			$nId = $this->input->post('nId');
			$q_text = $this->input->post('q_text');
			$uId = $this->session->userdata('uId');
			$this->Message_management->invite_answer_message(array('f_uId_str'=>$f_uId_str,'nId'=>$nId,'uId'=>$uId,'q_text'=>$q_text));
			echo $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=> INVITE_ANSWER_SEND));
		}
		else
	   	{
	      	echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	   	}
	}
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/question.php*/
