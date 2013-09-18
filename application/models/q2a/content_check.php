<?php
  class Content_check extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
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
		   return CONTENT_UNVALID;
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
  }