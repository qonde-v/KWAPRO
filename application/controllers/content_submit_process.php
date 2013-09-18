<?php
  class Content_submit_process extends CI_Controller
  {
     function __construct()
	 {
	   parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');

		 $this->load->database();

		 $this->load->library('session');
		 $this->load->library('language_translate');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/Question_data');
		 $this->load->model('q2a/Dialog_event');
		 $this->load->model('q2a/Content_process');
		 $this->load->model('q2a/Text_parse');
		 $this->load->model('q2a/Tag_process');
		 $this->load->model('q2a/Db_event_operate');
		 $this->load->model('q2a/Http_process');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Check_process');
		 $this->load->model('q2a/Kpc_manage');
                 $this->load->model('q2a/Question_summary');
                 $this->load->model('q2a/Node_translation_manage');
                 $this->load->model('q2a/Quick_answer');
                 $this->load->model('q2a/Ip_location');
                 $this->load->model('q2a/Expert_manage');

	 }

//
    function tag_retrieve()
    {
	//error_log(">>>>>>request post here!\n");
    	if($this->Auth->request_access_check())
		{
            $text = $this->input->post('text',TRUE);
	    //trigger_error(">>>>>>tag for text is:".$text."\n");
            $code = $this->Check_process->submit_content_check(array('text'=>$text));
            if($code == CONTENT_VALID)
		    {
		    	$lang_code = $this->language_translate->check($text);
			//trigger_error(">>>>>>code for text is:".$lang_code."\n");
		    	$tag_arr = $this->Text_parse->question_tag_get(array('text'=>$text,'lang_code'=>$lang_code));
		    	echo implode(',',$tag_arr);
		    }
		    else
		    {
                $msg = $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=>CONTENT_UNVALID));
		        echo "###".$msg;
		    }
		}
		else
		{
            $msg = $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=>USER_UNLOGIN));
			echo "###".$msg;
		}
        }

	//
	function question_send()
	{
	    if($this->Auth->request_access_check())
		{
            $text = $this->input->post('text',TRUE);
            $tags = $this->input->post('tags',TRUE);
            $expert_id_str = $this->input->post('expert_id',TRUE);

            $text = $text ? $text : '';
		    $tags = $tags ? $tags : '';
			$code = $this->Check_process->submit_content_check(array('text'=>$text));

		   if($code == CONTENT_VALID)
		   {
				$segs = $this->uri->segment_array();
				//print_r($segs);
				//echo $_SERVER['DOCUMENT_ROOT'];	
				$lang_code = $this->language_translate->check($text);
				$uId = $this->session->userdata('uId');
				$send_place = $this->session->userdata('location_city');
				$time = date("Y-m-d H:i:s", time());

				//save node data
				$data = array('ntId'=> QUESTION, 'time'=>$time,'text'=>$text,'stId'=>ONLINE,'sendPlace'=>$send_place,'langCode'=>$lang_code,'uId'=>$uId);
				$node_id = $this->Content_process->content_insert($data);
				

				//parse question
				if(!empty($tags))
				{
				   $tag_arr = explode(',', $tags);
	               $this->Tag_process->tag_store4question(array('nId'=>$node_id,'tag'=>$tag_arr));
				}
				else
				{
				   $tag_arr = $this->Text_parse->parse(array('nId'=>$node_id,'text'=>$text,'lang_code'=>$lang_code));
				}

				
				$tag_view = implode(',', $tag_arr);
                                //$msg = $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=> QUESTION_DETAIL));
				//echo $tag_view.'@@'.$node_id;
				echo  $node_id;
                                
                                //save question2expert data
                                if(!empty ($expert_id_str))
                                {
                                    $id_arr = explode(',', $expert_id_str);
                                    $q2e_data = array('nId'=>$node_id,'expert_id_arr'=>$id_arr,'time'=>$time);
                                    $this->Expert_manage->question2expert_store($q2e_data);
                                    $base_url = $this->config->item('base_url');
				    $this->Expert_manage->message_notifi4expert($q2e_data,$base_url,$uId);
                                }
                                
				//send event to app-server
				$server_data = array('host'=>'127.0.0.1','port'=>'4040','is_return'=>'');
				$content_data = $data;
				$content_data['nId'] = $node_id;
				$content_data['tags'] = $tag_view;				
				$this->Http_process->_send_content_event($server_data, $content_data);

		  }
		  else
		  {
		     $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=>$code));
             echo "##".$msg."##";
		  }

		}
		else
		{
           $msg = $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=> USER_UNLOGIN));
		   echo "##".$msg."##";
		}
	}

	//process the submitted answer for the question
	function answer_process()
	{
	   if($this->Auth->request_access_check())
	   {
            $post_arr = array();

		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : '';
		   }
	      $code = $this->Check_process->submit_content_check(array('text'=>$post_arr['answer']));
		  if($code == CONTENT_VALID)
		  {
			   $uId = $this->session->userdata('uId');
			   $time = date("Y-m-d H:i:s", time());
			   $send_place = $this->session->userdata('location_city');
			   $lang_code = $this->language_translate->check($post_arr['answer']);

			   $data = array('to_nId'=>$post_arr['question_id'], 'uId'=> $uId, 'ntId'=>ANSWER, 'text'=> $post_arr['answer'], 'langCode'=>$lang_code, 'time'=>$time, 'stId'=> ONLINE, 'sendPlace'=>$send_place);
			   $node_id = $this->Content_process->content_insert($data);

			   echo $node_id."#---#".$this->ajax_generate_answer_view($node_id);
			   
			   $server_data = array('host'=>'127.0.0.1','port'=>'4040','is_return'=>'');
			   $content_data = $data;
			   $content_data['nId'] = $node_id;
			   $this->Http_process->_send_content_event($server_data, $content_data);

			   
		  }
		  else
		  {
		     $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=>$code));
             echo "##".$msg."##";
		  }
       }
	}

    //process the instant submitted answer for the question
	function instant_answer_process()
	{
	   if($this->Auth->request_access_check())
	   {
            $post_arr = array();

		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : '';
		   }
           $code = $this->Check_process->submit_content_check(array('text'=>$post_arr['answer']));
		    if($code == CONTENT_VALID)
		  {
			   $uId = $this->session->userdata('uId');
			   $time = date("Y-m-d H:i:s", time());
			   $send_place = $this->session->userdata('location_city');
			   $lang_code = $this->language_translate->check($post_arr['answer']);

			   $data = array('to_nId'=>$post_arr['question_id'], 'uId'=> $uId, 'ntId'=>ANSWER, 'text'=> $post_arr['answer'], 'langCode'=>$lang_code, 'time'=>$time, 'stId'=> ONLINE, 'sendPlace'=>$send_place);
			   $node_id = $this->Content_process->content_insert($data);

               $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=>PROCESS_SUCCESS));
               echo $msg;
                
                //send event to app-server
                $server_data = array('host'=>'127.0.0.1','port'=>'4040','is_return'=>'');
				$content_data = $data;
				$content_data['nId'] = $node_id;
				$this->Http_process->_send_content_event($server_data, $content_data);

			   
		  }
		  else
		  {
		     $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=>$code));
             echo "##".$msg."##";
		  }
       }
	}

    //process the submitted summary for the question
	function summary_process()
	{
	   if($this->Auth->request_access_check())
	   {
            $post_arr = array();

		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : '';
		   }
	      $code = $this->Check_process->submit_content_check(array('text'=>$post_arr['text']));
		  if($code == CONTENT_VALID)
		  {
			   $uId = $this->session->userdata('uId');
			   $time = date("Y-m-d H:i:s", time());

			   $lang_code = $this->language_translate->check($post_arr['text']);
			   $lang_code = $lang_code ? $lang_code : 'zh';

			   $data = array('nId'=>$post_arr['nId'], 'uId'=> $uId, 'text'=> $post_arr['text'], 'langCode'=>$lang_code, 'time'=>$time);

               $node_id = $this->Question_summary->add_question_summary($data);

               $msg = $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=>$code));
               echo $msg;
		  }
		  else
		  {
		     $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=>$code));
             echo "##".$msg."##";
		  }
       }
	}

    //process the submitted translation for the question
    function translate_submit()
    {
        if($this->Auth->request_access_check())
	    {
            $post_arr = array();

		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : '';
		   }
	      $code = $this->Check_process->submit_content_check(array('text'=>$post_arr['text']));
		  if($code == CONTENT_VALID)
		  {
			   $uId = $this->session->userdata('uId');
			   $time = date("Y-m-d H:i:s", time());

			   $data = array('nId'=>$post_arr['nId'], 'uId'=> $uId, 'text'=> $post_arr['text'], 'langCode'=>$post_arr['langCode'], 'time'=>$time);

               $node_id = $this->Node_translation_manage->db_insert_translated_text($data);

               $msg = $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=>$code));
               echo $msg;
		  }
		  else
		  {
		     $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=>$code));
             echo "##".$msg."##";
		  }
       }
    }

	//
	function comment_process()
	{
	   if($this->Auth->request_access_check())
	   {
            $post_arr = array();

		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : '';
		   }
		  $code = $this->Check_process->submit_content_check(array('text'=>$post_arr['comment']));
		  if($code == CONTENT_VALID)
		  {
			   //retrieve comment data
			   $uId = $this->session->userdata('uId');
			   $time = date("Y-m-d H:i:s", time());
			   $send_place = $this->session->userdata('location_city');
			   $lang_code = $this->language_translate->check($post_arr['comment']);

			   $data = array('to_nId'=>$post_arr['answer_id'], 'uId'=> $uId, 'ntId'=> COMMENT, 'text'=> $post_arr['comment'] , 'langCode'=>$lang_code,'time'=>$time, 'stId'=> ONLINE, 'sendPlace'=>$send_place);

			   //content data store into DB
			   $node_id = $this->Content_process->content_insert($data);
			   echo $node_id."#---#".$this->ajax_generate_comment_view($node_id);
			   
			   //
			   $server_data = array('host'=>'127.0.0.1','port'=>'4040','is_return'=>'');
			   $content_data = $data;
			   $content_data['nId'] = $node_id;
			   $this->Http_process->_send_content_event($server_data, $content_data);

		  }
		  else
		  {
		     $msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=>$code));
             echo "##".$msg."##";
		  }
      }
	}

	//generate comment view html for ajax request
	//input: node id of comment
	function ajax_generate_comment_view($node_id)
	{
	   $data = $this->Question_data->get_comment_data($node_id);
	   $data['base'] = $this->config->item('base_url');
	   $data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);

       $language = $this->Ip_location->get_language();
	   $this->lang->load('question_detail',$language);
	   $data['question_detail_translate'] = $this->lang->line('question_detail_translate');
       $data['question_detail_submit'] = $this->lang->line('question_detail_submit');
       $data['question_detail_translate_prompt1'] = $this->lang->line('question_detail_translate_prompt1');
       $data['question_detail_translate_prompt2'] = $this->lang->line('question_detail_translate_prompt2');

	   return $this->load->view('q2a/mainleft/comment_content',$data,true);
	}

	//generate answer view html for ajax request
	//input: node id of answer
	function ajax_generate_answer_view($node_id)
	{
	   $data = $this->Question_data->get_answer_data($node_id);
	   $data['base'] = $this->config->item('base_url');
	   $data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);
	   $data['answer_score'] = 0;

       $language = $this->Ip_location->get_language();
	   $this->lang->load('question_detail',$language);
	   $data['question_detail_votes'] = $this->lang->line('question_detail_votes');
	   $data['question_detail_like_it'] = $this->lang->line('question_detail_like_it');
       $data['question_detail_dislike_it'] = $this->lang->line('question_detail_dislike_it');
	   //$data['question_participants'] = $this->lang->line('question_participants');
	   $data['question_detail_comment'] = $this->lang->line('question_detail_comment');
	   $data['question_detail_translate'] = $this->lang->line('question_detail_translate');
       $data['question_detail_submit'] = $this->lang->line('question_detail_submit');
       $data['question_detail_translate_prompt1'] = $this->lang->line('question_detail_translate_prompt1');
       $data['question_detail_translate_prompt2'] = $this->lang->line('question_detail_translate_prompt2');
	   $data['question_detail_waiting'] = $this->lang->line('question_detail_waiting');

       //$this->Question_process->update_Q_answer_num($node_id);

	   $answer_body = $this->load->view('q2a/mainleft/answer_content',$data,true);
	   return "<div class=\"answer_content\">".$answer_body."<div id=\"comment4answer_".$node_id."\">"."</div>"."</div>";
	}

    //generate question view html for ajax request
	//input: node data of question
	//output: html view of question
	function ajax_generate_question_view($data)
	{
        $language = $this->Ip_location->get_language();
	   $this->lang->load('questions',$language);
	   $data['question_views'] = $this->lang->line('question_views');
	   $data['question_answers'] = $this->lang->line('question_answers');
	   $data['question_kp_dolors'] = $this->lang->line('question_kp_dolors');
	   $data['question_participants'] = $this->lang->line('question_participants');  
	$data['question_followed'] = $this->lang->line('question_followed');
       $data['question_click_detail'] = $this->lang->line('question_click_detail');
       $data['instant_answer_title'] = $this->lang->line('instant_answer_title');
        $data['instant_answer_close'] = $this->lang->line('instant_answer_close');
        $data['instant_answer_empty'] = $this->lang->line('instant_answer_empty');
        $data['instant_answer_button'] = $this->lang->line('instant_answer_button');

	   //$data['question_answer_num'] = $this->Question_data->get_answer_num($data['nId']);
	   $data['headphoto_path'] = $this->User_data->get_user_headphotopath($data['uId']);

	   return $this->load->view('q2a/mainleft/question_item',$data,true);
	}

	//
	function related_question_request()
	{
	   if($this->Auth->request_access_check())
	   {
            $node_id = $this->input->post('node_id',TRUE);

			echo $this->generate_related_question_list($node_id);
	   }
	   else
	   {
	      echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	   }
	}

	//generate list view of questions which are related with
	//the input node id
	//input: node id of question
	//output: html views of questions list
	function generate_related_question_list($node_id)
	{
	   $html_view = "";
	   $base = $this->config->item('base_url');
 	   $question_data_arr = $this->Question_process->get_related_Q_by_nid($node_id);
           $len = count($question_data_arr);
	   if($len)
	   {
		   foreach($question_data_arr as $item)
		   {
			   $item['base'] = $base;
			   $html_view .= $this->ajax_generate_question_view($item);
		   }
       }
	   else
	   {
	      $html_view = $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=>NOT_QUESTION_MATCH));
	   }
	   return $len.'###'.$html_view;
	}

	//get the html view for the new submitted question
	function new_question_area_update()
	{
	   if($this->Auth->request_access_check())
	   {
            $node_id = $this->input->post('node_id',TRUE);

            $item = $this->Question_data->get_question_data($node_id);
            $base = $this->config->item('base_url');
            $item['base'] = $base;

			echo $this->ajax_generate_question_view($item);
	   }
	   else
	   {
	      echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	   }

	}

    //
    function save_quick_answer()
    {
        $url = $this->input->post('url',TRUE);
        $title = $this->input->post('title',TRUE);
        $description = $this->input->post('description',TRUE);
        $nId = $this->input->post('node_id',TRUE);

        $data = array('url'=>$url,'title'=>strip_tags($title),'description'=>$description,'nId'=>$nId);
        $this->Quick_answer->insert_quick_answer($data);
    }
	
	function question_edit()
	{
		if($this->Auth->request_access_check())
		{
			$nId = $this->input->post('nId',TRUE);
			$text = $this->input->post('text',TRUE);
			if(trim($text) != '')
			{
                                $data = array('nId'=>$nId,'text'=>$text,'modify_time'=>time());
				$this->Content_process->node_update($data);
				echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PROCESS_SUCCESS));
			}
			else
			{
				echo "##".$this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> NOTHING_INPUT));
			}
		}
		else
	   	{
	      	echo "##".$this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	   	}
	}
	
	function question_tag_edit()
	{
		if($this->Auth->request_access_check())
		{
			$nId = $this->input->post('nId',TRUE);
			$text = $this->input->post('text',TRUE);
			if(trim($text) != '')
			{
				$data = array('nId'=>$nId,'text'=>$text);
				$data['text'] = implode('|',explode(',',$data['text']));
				$this->Content_process->question_tag_update($data);
				echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PROCESS_SUCCESS));
			}
			else
			{
				echo "##".$this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> NOTHING_INPUT));
			}
		}
		else
	   	{
	      	echo "##".$this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
	   	}
	}


  }//END OF CLASS
