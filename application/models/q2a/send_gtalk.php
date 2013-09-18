<?php
  class Send_gtalk extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
	    $this->load->helper('define');
	    $this->load->library('google_talk');
	 }
	 
	 //input: array('account','text','nId','ntId')
	 function send($data)
	 {
	   $this->google_talk->send_message($data);
	 }
	 
	 //
	 function _get_gtalk_configure()
	 {
       $config_data = array();
		$config_data['host'] = 'talk.google.com';
		$config_data['port'] = 5222;
		$config_data['resource'] = "xmpphp";
		$config_data['server'] = "gmail.com";
		
		$config_data['mail'] = "kwaproq2a@gmail.com";
		$config_data['pass'] = "851212840607";
		
		return $config_data;
	 }
  }//end of class
/*End of file*/
/*Location: ./system/appllication/model/q2a/send_talk.php*/