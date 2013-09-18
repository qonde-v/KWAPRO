<?php
  class Content_event_engine extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
	    $this->load->helper('define');
	    $this->load->library('language_translate');
	    $this->load->model('q2a/Text_parse');
	    $this->load->model('q2a/Db_event_operate');
	    $this->load->model('q2a/Content_process');
	    $this->load->model('q2a/Question_process');		
	 }
	 
	 //parse content event
	 //input: array('nId','event_id')
	 function content_event_parse($data)
	 {
	    $content_data = $this->read_content_data($data['nId']);
	    //update the language information of the question
	    $content_data['lang_code'] = $this->content_information_update($content_data);
	    $this->content_parse($content_data);
	    //$this->Db_event_operate->event_update(array('event_id'=>$data['event_id'],'event_type'=>EVENT_TYPE_SEND));
	 }
	 
	 //
	 function content_parse($content_data)
	 {
	    switch($content_data['ntId'])
	    {
	        case QUESTION:
	          $this->question_event_parse($content_data);
	          break;  
	        case ANSWER:
	          $this->answer_event_parse($content_data);
	          break;
	        case COMMENT:
	          $this->comment_event_parse($content_data);
	          break;
	        default:
	          break;
	    }
	 }
	 
	 //update the language code of the node 
	 //input: node data structure
	 function content_information_update($content_data)
	 {
	    $lang_code = $content_data['langCode'];
	    if(empty($lang_code))
		{
				$lang_code = $this->language_translate->check($content_data['text']);
				if($lang_code)
				{
				  $this->Content_process->node_update(array('nId'=>$content_data['nId'],'langCode'=>$lang_code));
				}
		 }
        //
	    return $lang_code;
	 }
	 
	 //
	 function read_content_data($node_id)
	 {
	    //get node data from DB by node id
	    //todo:
	    return $this->Content_process->get_nodedata_by_id($node_id);
	 }
	 
	 //input: 
	 function question_event_parse($data)
	 {
	    //todo:
	    $this->Text_parse->engine_question_parse($data);
	 }
	 
	 //update the answer number of the question that the answer reply to
	 function answer_event_parse($data)
	 {
	    //todo:
		$q_node_id = $this->Question_process->update_Q_answer_num($data['nId']);
		echo "answer number of question ".$q_node_id." update\n";
	 }
	 
	 //
	 function comment_event_parse($data)
	 {
	    //todo:
		
	 }
	 
	 
  }//end of class
  
/*End of file*/
/*Location: ./system/appllication/model/q2a/content_event_engine.php*/
	 
