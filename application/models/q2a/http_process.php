<?php
  class Http_process extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
	 }
	 
		 
	 //server_data=array('host','port','is_return')
	 //content_data=array('nId','text','uId','time','ntId','stId','sendPlace','langCode','to_nId','tags') 
	 function _send_content_event($server_data, $content_data)
	 {
	 	$query_str = "/content?";
	 	$query_str .= "text=".urlencode($content_data['text'])."&nId=".$content_data['nId']."&uId=".$content_data['uId']."&time=".urlencode($content_data['time'])."&ntId=".$content_data['ntId']."&stId=".$content_data['stId']."&sendPlace=".urlencode($content_data['sendPlace'])."&langCode=".$content_data['langCode'];
	 	
	 	if(isset($content_data['to_nId']))
	 	{
	 		$query_str .= "&to_nId=".$content_data['to_nId'];
	 	}
	 	
	 	if(isset($content_data['tags']))
	 	{
	 		$query_str .= "&tags=".$content_data['tags'];
	 	}
	 	
	 	$server_data['query'] = $query_str;
	 	//return $this->_send_http_request($server_data);

	 }
	 
	 //send the common http request
	 //input:array('host','port','query','is_return')
	 //return respond text if the value of 'is_return' is true
	 function _send_http_request($data)
	 {
	           $host = $data['host'];
		   $port = $data['port'];
		   $query = $data['query'];
		   $body = "";
		   
		   $fp = fsockopen("127.0.0.1", "4040", $errno, $errstr, 1);
			
			/*********************CONNECT FAILED**********************/
			if (!$fp)
			{
				return '';
			}
			/*********************CONNECT SUCCESS**********************/
			$out = "GET ${query} HTTP/1.1\r\n";
			$out .= "Host: ${host}\r\n";
			$out .= "Content-Length: " . strlen($body) . "\r\n";
			$out .= "Connection: close\r\n";
			$out .= "\r\n";
			$out .= $body;
			fwrite($fp, $out);
			fclose($fp);
			return "";
	 }
	 
	 
	 //parse the respond string
	 //input:  responding string that get from http request
	 //output: body string retrieved from responding text
	 function _respond_parse($fp)
	 {
	    //todo:
		
	 }
  }//END OF CLASS
   
