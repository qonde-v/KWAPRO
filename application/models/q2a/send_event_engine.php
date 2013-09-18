<?php
  class Send_event_engine extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
	    $this->load->helper('define');
	    $this->load->library('language_translate');
	    $this->load->model('q2a/Db_event_operate');
	    $this->load->model('q2a/Content_process');
	    $this->load->model('q2a/Send_user_select');
	    $this->load->model('q2a/User_data');
	    $this->load->model('q2a/User_profile');
		$this->load->model('q2a/Question_data');
		$this->load->model('q2a/Send_process');
	 }
	 
	 //parse content event
	 //input: array('nId','event_id')
	 function send_event_parse($data)
	 {
		 $node_data = $this->Content_process->get_nodedata_by_id($data['nId']);
		 
		 //get the user(s) and the sending text for specified user
		 $send_information_data = $this->pre_send_parse($node_data);
		 $this->do_send(array('send_data'=>$send_information_data,'node_data'=>$node_data));
		 //$this->Db_event_operate->event_delete(array('event_id'=>$data['event_id']));
	 }
	 
	 //select the user and generate sending text
	 //input: node structure data
	 //output: array(array('account'--sending address,'text'--text sending to user,'stId'--send type))
	 function pre_send_parse($node_data)
	 {
	    $user_id_arr = $this->Send_user_select->select_send_user($node_data);
	    $user_account_arr = $this->get_user_send_account($user_id_arr);
	    $user_text_arr = $this->generate_user_send_text(array('account_data'=>$user_account_arr,'node'=>$node_data));
		return $this->generate_sending_data(array('account_data'=>$user_account_arr,'text'=>$user_text_arr));
	 }
	 
	 //get user selected sending account and send type
	 //input:  array of user id
	 //output: array of ('uId'=>array('account','stId'))
	 function get_user_send_account($user_id_arr)
	 {
	     //todo:
		 $account_data = array();
		 
		 foreach($user_id_arr as $user_id)
		 {
		     $user_account = $this->User_data->get_user_send_account($user_id);
			 
			 if($user_account['account'] && $user_account['stId'])
			 {
			   $account_data[$user_id] = $user_account;
			 }
		 }
		 
		 return $account_data;
	 }

	 //generate sending text for user
	 //input:array('account_data','node')
	 //output: array of ('uId'=>text);
	 function generate_user_send_text($data)
	 {
	    //todo:
		$user_text_arr = array();
		
		foreach($data['account_data'] as $user_id=>$item)
		{
		   $user_data = $this->User_profile->get_user_basicdata($user_id);
		   $translated_text = $this->content_translate_process(array('user_langCode'=>$user_data['langCode'], 'text'=>$data['node']['text'],'text_langCode'=>$data['node']['langCode']));
		   $user_text_arr[$user_id] = $this->generate_sendtext_by_template(array('account_data'=>$item,'user_data'=>$user_data,'text_translated'=>$translated_text,'node'=>$data['node']));
		}
		//print_r($user_text_arr);
		return $user_text_arr;
	 }
	 
	 //translate the text from the language code of text to the language code of user
	 //input: array('user_langCode','text','text_langCode')
	 //output: translated text
	 function content_translate_process($data)
	 {
	    $text = '';
	    if($data['user_langCode'] != $data['text_langCode'])
		{
		   $text = $this->language_translate->translate(array('text'=>$data['text'], 'orignal_type'=>$data['text_langCode'], 'local_type'=>$data['user_langCode']));
		}
		
		return empty($text) ? $data['text'] : $text;
	 }

	 //generate sending text by template for email,gtalk on question,reply
	 //input: array('user_data','text_translated','node','account_data')
	 function generate_sendtext_by_template($data)
	 {
	    //todo:
		$template_name = $this->get_template_filename(array('stId'=>$data['account_data']['stId'], 'ntId'=>$data['node']['ntId'], 'langCode'=>$data['user_data']['langCode']));
		$temp_data = array();
		
		switch($data['node']['ntId'])
		{
		   case QUESTION:
		     $temp_data = array('nId'=>$data['node']['nId'],'username'=>$data['user_data']['username'],'text_translated'=>$data['text_translated'],'text'=>$data['node']['text']);
		     break;
		   case MESSAGE:
		     $temp_data = array('nId'=>$data['node']['nId'],'username'=>$data['user_data']['username'],'text_translated'=>$data['text_translated'],'text'=>$data['node']['text']);		     
	         $r_username = $this->User_data->get_username(array('uId'=>$data['node']['uId']));
			 $temp_data['r_username'] = $r_username;		 
			 break;
		   case ANSWER:
		   case COMMENT:
		   case MESSAGE_REPLY:
		     $reply2_data = $this->generate_original2reply_data($data['node']);
		     $temp_data = array('nId'=>$data['node']['nId'],'username'=>$data['user_data']['username'],'text_translated'=>$data['text_translated'],'text'=>$data['node']['text']);
			  $temp_data = array_merge($temp_data, $reply2_data);
		     break;
		   default:
		     break;
		}
		return $this->load->view('q2a/sending_template/'.$template_name,$temp_data,true);
	 }
     
	 //generate original data that current content reply to
	 //input: array('nId'--node id of current reply content,'uId'--id of current reply user)
	 //output: array('r_username'--reply username,'o_text'--text that is replied currently)
	 function generate_original2reply_data($data)
	 {
	    //todo:
	    $r_username = $this->User_data->get_username(array('uId'=>$data['uId']));
	    $o_text = $this->Question_data->get_original_text4reply($data['nId']);
	    
	    return array('r_username'=>$r_username, 'o_text'=>$o_text);
	 }
	  
     //generate template
	 //input:array('stId','ntId','langCode')
	 //output: file name string 
	 function get_template_filename($data)
	 {
	    $file_name = $data['langCode'].'_'.$data['ntId'].'_'.$data['stId'].'.php';
		
	    if(file_exists("system/application/views/q2a/sending_template/".$file_name))
		{
	       return $file_name;
		}
		else
		{
		   return $data['langCode'].'_'.$data['ntId'].'_'.$data['stId'].'.php';
		}
	 }
	 
	 //re-generate the following structure data for sending text
	 //input: array('account_data','text')
	 //output: array(array('account'--sending address,'text'--text sending to user,'stId'--send type))
	 function generate_sending_data($data)
	 {
	    //todo:
		$send_data = array();
		
		foreach($data['account_data'] as $user_id=>$account_item)
		{
		   $send_data[$user_id] = array('account'=>$account_item['account'], 'stId'=>$account_item['stId'], 'text'=>$data['text'][$user_id]);
		}
		
		return $send_data;
	 }
	 
	 //send data to user by the information retrieved
	 //input: array('send_data','node_data')
	 //'send_data' -- array(array('account'--sending address,'text'--sending text,'stId'--send type))
	 //'node_data' -- node structure data
	 function do_send($data)
	 {
	   //todo:
	   echo "send engine starting:";
	   print_r($data['send_data']);
	   $this->Send_process->do_send($data);
	 }
	 
  }//end of class
 
/*End of file*/
/*Location: ./system/appllication/model/q2a/send_event_engine.php*/