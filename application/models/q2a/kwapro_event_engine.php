<?php
  class Kwapro_event_engine extends CI_Model
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
		 $this->load->model('q2a/Http_process');
		 $this->load->model('q2a/Auth');
	 }
	 
	 //**********************************************************************//
	 //process the submitted text parsing event
	 //intput: event id
	 function kwapro_event_parse($event_id)
	 {
		$event_data = $this->Db_event_operate->event_get(array('event_id'=>$event_id));
		
		if($event_data)
		{
		  $this->Content_event_engine->content_event_parse($event_data);
		}
	 }
	 
	 
	 
	 
	 //**********************************************************************//
	 //process the submitted content sending event
	 //intput: event id
	 function kwapro_event_send($event_id)
	 {
		  $event_data = $this->Db_event_operate->event_get(array('event_id'=>$event_id));
		  
		  if($event_data)
		  {
		    $this->Send_event_engine->send_event_parse($event_data);
		  }
	 }
	 
	 //
	 function kwapro_event_content_process_local($event_id)
	 {
	     $this->kwapro_event_parse($event_id);
		 $this->kwapro_event_send($event_id);
	 }
	 
	 //
	 function kwapro_event_content_process_server($event_id)
	 {
	    //send question event to server 
		$server_ip = $this->config->item('server_ip');
		$app_server_port = $this->config->item('app_server_port');
		$this->Http_process->_send_event_request(array('host'=>$server_ip, 'port'=>$app_server_port, 'event_id'=>$event_id, 'is_return'=>FALSE));
	 }
	 
	 //*********************************************************************//
	 //input: array('event_id','machine_type')
	 function kwapro_event_content_process($data)
	 {
	    $event_id = $data['event_id'];
		$machine_type = $data['machine_type'];
		
		switch($machine_type)
		{
		  case LOCAL:
		    $this->kwapro_event_content_process_local($event_id);
		    break;
		  case SERVER:
		    $this->kwapro_event_content_process_server($event_id);
			break;
		  default:
		    $this->kwapro_event_content_process_server($event_id);
		    break;
		}
	 }
	 
  }//END OF CLASS