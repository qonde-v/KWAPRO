<?php  
   if(!defined('BASEPATH')) exit('No direct script access allowed');
  
   class Google_talk
   {
	   function __construct()
	   {
	   }
	   
	   //
	   function send_message($data)
	   {
	      $path = dirname(__FILE__);
		  $exe_command = "python {$path}/kwapro_gtalk_send.py ".$data['account']." '".$data['text']."'";
		  exec($exe_command);
		  echo $exe_command;
	   }
	}
// END Google_talk class

/* End of file Google_talk.php */
/* Location: ./system/application/libraries/Google_talk.php */