<?php
  class Check_process extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
        $this->load->helper('prompt');
        $this->load->model('q2a/Ip_location');
	 }

	 //check the validation of the submit content
	 //input: array('text')
	 //output: check code
	 function submit_content_check($data)
	 {
		return $this->empty_check($data['text']);
		//todo:
		//string length check,Sensitive words check,etc..
	 }

	 //
	 function empty_check($text)
	 {
	    if(trim($text))
		{
		   return CONTENT_VALID;
		}
		else
		{
		   return NOTHING_INPUT;
		}
	 }

	 //
	 function string_length_check($text)
	 {
	    //todo:
	 }

	 //
	 function sensitive_word_check($data)
	 {
	   //todo:
	 }

     function email_check($email_str)
     {
        if(trim($email_str))
        {
            $data = explode('|',$email_str);
            if($this->email_same_check($data))
            {
                return INVITE_PROCESSED;
            }
            else
            {
                return SAME_EMAIL_EXIST;
            }
        }
        else
        {
            return NOTHING_INPUT;
        }
     }

     function email_same_check($data)
     {
        $distinct_data = array_unique($data);
        if(count($data) == count($distinct_data))
        {//no repeat email
            return TRUE;
        }
        else
        {
            return FALSE;
        }
     }

     //input:array('pre'=>,'code'=>)
     function get_prompt_msg($data)
     {
        $language = $this->Ip_location->get_language();
        $this->lang->load('prompt',$language);
        $val = $data['pre'].'_'.$data['code'];
        $result = $this->lang->line($val);
        return $result;
     }
  }