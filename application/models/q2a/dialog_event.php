<?php
  class Dialog_event extends CI_Model
  {
	function __construct()
	 {
	    parent::__construct();
	 }
	 
	//process the user voting for answer
	//input: array('nId'--node id of answer)
	function answer_vote_process($data)
	{
	  $sql = "UPDATE node_relation SET vote_num=vote_num+1 WHERE nFromId = {$data['nId']}";
	  $query = $this->db->query($sql);
	}
	
	//update question view number by the question node id of the dialog 
	function question_view_update($nId)
	{
	   $sql = "UPDATE question SET question_view_num = question_view_num+1 WHERE nId = {$nId}";
	   $query = $this->db->query($sql);
	}
	
  }//class
  
 /*End of file*/
  /*Location: ./system/appllication/controller/dialog_event.php*/   
  