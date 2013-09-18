<?php
  class Send_process extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
	    $this->load->helper('define');
	    $this->load->model('q2a/Send_mail');
	    $this->load->model('q2a/Send_gtalk');
	 }
	 
	 //send data to user by the information retrieved
	 //input: array('send_data','node_data')
	 //'send_data' -- array(array('account'--sending address,'text'--sending text,'stId'--send type))
	 //'node_data' -- node structure data
	 function do_send($data)
	 {
	    $send_data = $data['send_data'];
       foreach($send_data as $item)
		{
		   $item['nId'] = $data['node_data']['nId'];
		   $item['ntId'] = $data['node_data']['ntId'];
		   $this->send($item);
		}
	 }
	 
	 //
	 function send($data)
	 {
	   //todo:
	   switch($data['stId'])
	   {
		   case EMAIL:
		     $this->Send_mail->send($data);
		     break;
		   case GTALK:
		     $this->Send_gtalk->send($data);
		     break;
		   default :
		     break;
	   }
	 }
	 
  }//end of class
/*End of file*/
/*Location: ./system/appllication/model/q2a/send_process.php*/