<?php
  class Question_pool_request extends CI_Controller
  {
     function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');
         $this->load->helper('prompt');

		 $this->load->database();
		 $this->load->library('session');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Kpc_manage');
		 $this->load->model('q2a/Question_pool_manage');
		 $this->load->model('q2a/Check_process');
         $this->load->model('q2a/Ip_location');

	 }

     //get the sorted question data
	 function sorted_question_request()
	 {
	    //todo:
		if($this->Auth->request_access_check())
		{
		    $sort_attr = $this->input->post('sort_attr',TRUE);
		    $index = $this->input->post('index',TRUE);
			$sort_type = $this->input->post('sort_type',TRUE);
		    $index = empty($index) ? 1 : $index;

		    if(!empty($sort_attr))
		    {
		      $pre_num = $this->config->item('pre_q_pool_num');
		      $range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);

		   	  echo $this->sorted_question_view_load(array('attr'=>$sort_attr,'type'=>$sort_type),$range);
		   }
		}
		else
		{
		   echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	 }

     //
     function sorted_question_view_load($data,$range)
     {
     	$q_view_data = $this->Question_pool_manage->get_sorted_question_data($data,$range);

     	$retStr = "";
	    foreach($q_view_data as $item)
	    {
	      $retStr .= $this->question_item_view($item);
	    }
	    return $retStr;
     }


     function latest_question_load($uId,$range)
	 {
	   $data = $this->Question_process->get_latest_asked_question($uId,$range);

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

	  //
	 function ajax_get_question4tag()
	 {
	     if($this->Auth->request_access_check())
		 {

		    $index = $this->input->post('index',TRUE);
		    $index = empty($index) ? 1 : $index;
			$segs = $this->uri->segment_array();

			//data for page split
		    $data['total_num'] = $this->Question_process->get_Q_num_by_tag($segs[3]);
		    $data['pre_num'] = $this->config->item('pre_question_num');
		    $data['page_num'] = floor($data['total_num']/$data['pre_num']);
		    if($data['total_num']%$data['pre_num'] != 0 || $data['total_num'] == 0)
		    {
		    		$data['page_num']++;
		    }
		    $data['is_split'] = $data['total_num'] > $data['pre_num'] ? TRUE : FALSE;

			$range = array('start'=>($index-1)*$data['pre_num'],'end'=>$index*$data['pre_num']-1);
		    $question_data = $this->Question_process->get_question_data_by_tag_id(array($segs[3]),$range);

			$question4tag_view =  "";
			foreach($question_data as $item)
	        {
	            $question4tag_view .= $this->question_item_view($item);
	        }
			echo $question4tag_view;
		}//if
	 }


  }//END OF CLASS

/*End of file*/
/*Location: ./system/appllication/controller/question_pool_request.php*/