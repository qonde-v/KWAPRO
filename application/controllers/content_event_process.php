<?php
  class Content_event_process extends CI_Controller
  {
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 
		 $this->load->library('session');
		 $this->load->model('q2a/Db_event_operate');
		 $this->load->model('q2a/Content_event_engine');
		 $this->load->model('q2a/Send_event_engine');
		 $this->load->model('q2a/Auth');
		 
	 }
	 
	 function event_parse()
	 {
	    $segs = $this->uri->segment_array();
		$event_id = $segs[3] ? $segs[3] : 0;
		$event_data = $this->Db_event_operate->event_get(array('event_id'=>$event_id));
		
		if($event_data)
		{
		  $this->Content_event_engine->content_event_parse($event_data);
		}
	 }
	 
	 function event_send()
	 {
	      $segs = $this->uri->segment_array();
		  $event_id = $segs[3] ? $segs[3] : 0;
		  $event_data = $this->Db_event_operate->event_get(array('event_id'=>$event_id));
		  
		  if($event_data)
		  {
		    $this->Send_event_engine->send_event_parse($event_data);
		  }
	 }
	 
	 function event_process()
	 {
		  $segs = $this->uri->segment_array();
		  $node_id = $segs[3] ? $segs[3] : 0;
		  //$event_data = $this->Db_event_operate->event_get(array('event_id'=>$event_id));
		  
		  $event_data = array('nId'=>$node_id);
		  if($event_data)
		  {
		    $this->Content_event_engine->content_event_parse($event_data);
		    $this->Send_event_engine->send_event_parse($event_data);
		  }
		  //$this->Db_event_operate->event_delete(array('event_id'=>$event_id));
	 }
  }//END OF CLASS
